<?php

function open_html ()
{
	echo <<<EOD
<!doctypr html>
<html>
<head>
	<title>ENTIhub</title>
</head>

<body>
	<header>
		<h1>ENTIhub</h1>
		<nav>
			<ul>
				<li>Home</li>
				<li>Perfil</li>
				<li>Usuaros</li>
				<li>Configuración</li>
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


