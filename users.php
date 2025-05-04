<?php
require_once("func.check_session.php");

$session = check_session();
//Si no tiene cuenta iniciado no podra ver los usuarios
if (!$session){
	header("Location: login.php");
	exit();
}

require_once("template.php");
open_html();

//Hacemos una query que sacara los nombres y usuarios y los ordenara ascendente de A-Z
$query = <<<EOD
SELECT
    users.username,
    users.name 
FROM 
    users
ORDER BY 
    users.name ASC
EOD;

require_once("db_conf.php");
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_db);
$resultado = mysqli_query($conn, $query);

if (!$resultado){
    die("Error 1: en la query");
}

if (mysqli_num_rows($resultado) == 0){
    echo "Error 2: Plataforma no encuntra usuarios";
	close_html();
    exit();
}

//Hacemos un menu para sacar a los usuarios.
echo <<<EOD
<h2>Usuarios registrados</h2>
<ul>
EOD;

while ($info_user = $resultado->fetch_assoc()){
	echo <<<EOD
    <li>
        <h3><a href="profile.php?user={$info_user["username"]}">Name: {$info_user["name"]}</a></h3>
        <p> Username: {$info_user["username"]}</p>
    </li>
EOD;
}
echo "</ul>";

close_html();
?>