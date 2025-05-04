<?php

function open_html ($title = "ENTIhub")
{
$session = false;

if (isset($_SESSION["id_user"])){
	$session = true;
}

$loginout = "";
$buscador= "";
if ($session){
	$loginout = "<a href =\"/logout.php\">Logout</a>";
	$buscador = <<<EOD
<form action="buscador.php" method="get" class="search-form">
    <input type="text" name="busqueda" placeholder="Buscar mensajes o usuarios" required>
    <button type="submit">Buscar</button>
</form>
EOD;
}else{
	$loginout = "<a href =\"/login.php\">Login</a>";
}

echo <<<EOD
<!doctype html>
<html>
<head>
	<title>{$title}</title>
	<link rel="stylesheet" type="text/css" href="entihub.css">
</head>

<body>
	<header>
		<h1><a href ="/index.php">ENTIhub</a></h1>
		<nav>
			<ul>
				<li><a href="/index.php">Home</a></li>
				<li><a href ="/profile.php">Perfil</a></li>
				<li><a href ="/users.php">Usuarios</a></li>
				<li><a href ="/dashboard.php">Dashboard</a></li>
				<li>$loginout</li>
			</ul>
			$buscador
		</nav>
	</header>
		
	<main>
EOD;
}


function close_html ()
{
	echo <<<EOD
	</main>
	<footer>
		<p>Copyright (c) ENTIhub 2025</p>
	</footer>
</body>
</html>
EOD;
}

?>


