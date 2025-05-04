<?php

function open_html ($title = "ENTIhub")
{
$session = false;

if (isset($_SESSION["id_user"])){
	$session = true;
}

$loginout = "";
if ($session){
	$loginout = "<a href =\"/logout.php\">Logout</a>";
}else{
	$loginout = "<a href =\"/login.php\">Login</a>";
}

echo <<<EOD
<!doctypr html>
<html>
<head>
	<title>{$title}</title>
</head>

<body>
	<header>
		<h1><a href ="/index.php">ENTIhub</a></h1>
		<link rel="stylesheet" type="text/css" href="entihub.css">
		<nav>
			<ul>
				<li><a href ="/index.php">Home</li>
				<li><a href ="/profile.php">Perfil</li>
				<li><a href ="/users.php">Usuarios</li>
				<li><a href ="/dashboard.php">Dashboard</a></li>
				<li>$loginout</li>
			</ul>
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


