<?php

function write_message ($message_info){
	
	$id_user = 0;

	if (isset($_SESSION["id_user"])){
		$id_user = intval($_SESSION["id_user"]);
	}

	$delete_link = "";

	if ($id_user == $message_info["id_user"]){
		$delete_link = <<<EOD
		<p class ="delete-message"><a href="delete_message.php?message={$message_info["id_message"]}">Delete</a><p> 
		EOD;
	}


	echo <<<EOD
	<section class="message">
	<h3><a href="profile.php?user={$message_info["username"]}">{$message_info["name"]}</a></h3>
	<p class="message-text">{$message_info["message"]}</p>
	<p class="message-date">{$message_info["post_time"]}</p>
	<p class ="delete-message"><a href="delete_message.php?message={$message_info["id_message"]}">Delete</a><p>
	{$delete_link}
	</section>
	EOD;
}


session_start();
require_once("template.php");

$session = false;

if (isset($_SESSION["id_user"])){
	$session = true;
}

open_html();

if ($session) {
	echo <<<EOD
<aside id="message_form">
	<h2> Que esta ocurriendo </h2>
	<form method ="POST" action="message_check.php">
		<p><textarea placeholder="Introduce tu mensaje" name="message"></textarea></p>
		<p><input type="submit" value="Enviar" /> </p>
	</form>
</aside>

EOD;
}
else{
	echo <<<EOD
<aside>
	<p><a href="login.php">Identifícate o regístrate para interactuar</a></p>
</aside>
EOD;
}

echo <<<EOD
<section id="message-block">
<h2> Que esta ocurriendo </h2>
EOD;
require_once("db_conf.php");
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_db);

$query = <<<EOD
SELECT
	users.id_user
	users.username, 
	users.name,
	messages.message,
	messages.post_time,
	messages.id_message
FROM 
	users
INNER JOIN 
	messages 
ON 
	users.id_user=messages.id_user
WHERE
	messages.status = 1
ORDER BY 
	messages.post_time DESC
EOD;



$resultado = mysqli_query($conn, $query);

if (!$resultado){
    echo "Error 1: Peticion incorrecta";
    echo <<<EOD
	</section>
	close_html();
	EOD;
	exit();
}

while ($msg = $resultado->fetch_assoc()){
	write_message($msg);
}


close_html();


?>


