<?php
require_once("func.check_session.php");

$session = check_session();
if (!$session){
	header("Location: login.php");
	exit();
}

if (!isset($_GET["id_message"])){
	die("Error 1: No hay mensaje que borrar");
}

$id_message = intval($_GET["id_message"]);

if ($id_message <= 0){
	die("Error 2: Identificador incorrecto");
}


$id_user = intval($_SESSION["id_user"]);


require_once("db_conf.php");

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_db);


$query = <<<EOD
UPDATE
	messages
SET
	status=0
WHERE
	id_message={$id_message}
	AND id_user={$id_user}
EOD;


$result = mysqli_query($conn, $query);

if (!$result) {
	die("Error 3: Error al hacer la petición");
}

header("Location: dashboard_message.php");
exit();


?>
