<?php
require_once("func.check_session.php");

$session = check_session();


if (!$session){
	header("Location: login.php");
	exit();
}
$id_user = intval($_SESSION["id_user"]);

if(isset($_POST["cancel"])){
	header("Location: dashboard_message.php");
	exit();
}


if (!isset($_POST["id_message"]) || !isset($_POST["message"])){
	header("Location: dashboard_message.php");
	exit();
}


if (!isset($_POST["draft"]) && !isset($_POST["publish"])){
	header("Location: dashboard_message.php");
	exit();
}


$id_message = intval($_POST["id_message"]);
if ($id_message <= 0){
	header("Location: dashboard_message.php");
	exit();
}


//COMPROBAR QUE EL MENSAJE ES CORRECTO (Copiado del check message)
$message = trim($_POST["message"]);

if (strlen($message) <= 0){
    die("Error 2a: Mensaje demasiado corto");
}

$message = trim($_POST["message"]);
if (strlen($message) > 240){
    die("Error 2b: Mensaje demasiado largo");
}

$message = addslashes ($message);


$status = 1;
if (isset($_POST["draft"])){
	$status = 2;
}

$query = <<<EOD
UPDATE
	messages
SET
	message='{$message}',
	status={$status}
WHERE
	id_message={$id_message}
	AND id_user={$id_user}
EOD;

require_once("db_conf.php");
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_db);
$resultado = mysqli_query($conn, $query);

if (!$resultado) {
	die("Error 3: Error al hacer la petición");
}

header("Location: dashboard_message.php");
exit();


?>
