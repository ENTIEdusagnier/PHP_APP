<?php
require_once("func.check_session.php");
$session = check_session();

if (!$session) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET["busqueda"])){
	die("Error 1: No hay busqueda");
}

require_once("template.php");
open_html();

$busqueda = $_GET["busqueda"];

if (strlen($busqueda) <= 0){
    die("Error 2a: Busqueda demasiado corto");
}

if (strlen($busqueda) > 240){
    die("Error 2b: Busqueda demasiado largo");
}

$busqueda = addslashes ($busqueda);

//Hacemos una query que busca coicidecias en los usuario y nombres.
$query_users = <<<EOD
SELECT
    users.username,
    users.name
FROM
    users
WHERE
    users.username LIKE '%$busqueda%' 
    OR users.name LIKE '%$busqueda%'
EOD;



require_once("db_conf.php");
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_db);


$resultado = mysqli_query($conn, $query_users);
if (!$resultado){
    echo "Error 3b: Peticion incorrecta";
    exit();
}

//En caso que nos devuelva algo negativo o algun ataque verificamos.
if (mysqli_num_rows($resultado) <= -1){
    die("Error 4a: Algo salio mal en la peticion");
}


//Documentacion utilizada sobre arrays.
// https://www.w3schools.com/php/php_arrays_create.asp
// https://www.geeksforgeeks.org/best-way-to-initialize-empty-array-in-php/ 
$lista_usuarios = [];

// https://www.php.net/manual/en/function.stripos.php es una fucnion de php que nos permite hacer busqueda de strings

//Sacamos los datos de la base de datos si hay
while ($datos_query = mysqli_fetch_assoc($resultado)) {
    //Con stripos miramos si la busqueda esta en el usuario o nombre del usuario
    if (stripos($datos_query['username'], $busqueda) !== false || stripos($datos_query['name'], $busqueda) !== false) {
        $lista_usuarios[] = $datos_query;
    }
}    

$query_mensajes = <<<EOD
SELECT
    users.username,
    users.name,
    messages.message,
    messages.id_message
FROM
    messages
INNER JOIN 
    users 
ON 
    users.id_user = messages.id_user
WHERE
    messages.message LIKE '%$busqueda%'
ORDER BY messages.id_message DESC
EOD;
//Hacemos la peticion para mensajes
$resultado = mysqli_query($conn, $query_mensajes);
if (!$resultado){
    echo "Error 3b: Peticion incorrecta";
    exit();
}

//En caso que nos devuelva algo negativo o algun ataque verificamos.
if (mysqli_num_rows($resultado) <= -1){
    die("Error 4b: Algo salio mal en la peticion");
}

$lista_mensajes = [];
while ($datos_query = mysqli_fetch_assoc($resultado)) {
    // Si el mensaje contiene algo parecido a la busqueda añadira el comentario en la array
    if (stripos($datos_query['message'], $busqueda) !== false) {
        $lista_mensajes[] = $datos_query;
    }
}


//Una vez creada las arrays con la informacion sacaremos la informacion fomateada en html para el usuario.
//Creo una variable vacia donde se iran insertando los diferentes usuarios encontrados con formato html
$usuarios_html = "";
$mensajes_html = "";

// https://www.php.net/manual/en/function.empty.php
// https://www.php.net/manual/en/control-structures.foreach.php
if (!empty($lista_usuarios)) {
    //Por cada usuario guardaremos en una variable un html para luego sacarlo.
    foreach ($lista_usuarios as $usuario) {
        $usuarios_html .= <<<EOD
<li><p class="usuario"><a href="profile.php?user={$usuario['username']}">Usuario: {$usuario['username']}</a> Nombre: {$usuario['name']}</p></li>
EOD;
}
}
//Si la array esta vacia guardara el mensaje de que no hay usuarios. 
else {
    $usuarios_html = "<p>No se encontraron usuarios</p>";
}

// Mostrar lista de mensajes
if (!empty($lista_mensajes)) {
    //Por cada mensaje que hay en la array guardaremos un html con la informacion del mismo
    foreach ($lista_mensajes as $mensaje) {
        //Añadira a la variable el contendio de EOD
        $mensajes_html .= <<<EOD
<section class="message">
<h3><a href="profile.php?user={$mensaje["username"]}">{$mensaje["name"]}</a></h3>
<p class="message-text">{$mensaje["message"]}</p>
</section>
EOD;
    }

}
//Si la array esta vacia guardara el mensaje de que no hay mensajes.  
else {
    $mensajes_html = "<p>No se encontraron mensajes</p>";
}

//Aqui hacemos el html el cual en la lista sacara cada li de cada usuario o mensaje que haya encontrado en la base de datos.
echo <<<EOD
    <h1>Resultados de la busqueda</h1>
    <section class=resultados_users>
        <h2>Usuarios encontrados:</h2> 
        <ul class="lista-usuarios">
        {$usuarios_html}
        </ul>

        <h2>Mensajes encontrados:</h2>
        <ul class="lista-mensajes">
        {$mensajes_html}
        </ul>
    </section>
EOD;


close_html();
?>