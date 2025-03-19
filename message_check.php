<?php

session_start();

if (!isset($_SESSION["id_user"])){
	header("Location: login.php");
    exit();
}

if (!isset($_POST["message"])){
    die("Error 1: Mensaje no enviado");
}

$msg = trim($_POST["message"]);
if (strlen($msg) <= 0){
    die("Error 2a: Mensaje demasiado corto");
}

$msg = trim($_POST["message"]);
if (strlen($msg) > 240){
    die("Error 2b: Mensaje demasiado largo");
}

$msg = addslashes ($msg);

$id_user = intval($_SESSION["id_user"]);

$query = <<<EOD
INSERT INTO messages (message, post_time, id_user)
VALUE('{$msg}',now(),'{$id_user}')
EOD;

require_once("db_conf.php");

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_db);
$resultado = mysqli_query($conn, $query);

if (!$resultado){
    echo "Error 3: Peticion incorrecta";
    exit();
}

header("Location: index.php");

?>