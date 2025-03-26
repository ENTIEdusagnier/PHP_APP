<?php

if (!isset($_SESSION["id_user"])){
    header("Location: login.php");
    exit();
}

if (!isset($_GET["id_message"])){
    die("Error 1; No hay mensaje");
}


$id_message = intval($_GET["id_message"]);

if ($id_message <= 0){
    die("Error 2: Indentificador Incorrecto");
}


$id_user = 0;

if (isset($_SESSION["id_user"])){
	$id_user = intval($_SESSION["id_user"]);
}

require_once("db_conf.php");

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_db);

$query = <<<EOD
    SELECT 
        id_message
    FROM 
        messages
    WHERE
        id_message={$id_message} AND id_user={$id_user}

EOD;

$result = mysqli_query($conn, $query);

if (!$result){
    die("Error 3: Error peticion incorrecta.");
}

if (mysqli_num_rows($result) !=1) {
    die("Error 3: Error peticion incorrecta.");
} 

$query = <<<EOD
UPDATE
    messages
SET
    status=0
WHERE
    id_message={$id_message} AND id_user={$id_user}
EOD;

$result = mysqli_query($conn, $query);

if (!$result){
    die("Error 5: HACER PETICION");
}

header("Location: index.php")

?>