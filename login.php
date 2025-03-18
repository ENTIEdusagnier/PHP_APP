<?php

require_once("template.php");

open_html ();

echo <<<EOD
<form method="POST" action="login_check.php">
<h2>Login</h2>
<p><label for="username-login">usuario:</label>
<input type="text" id="username-login" name="username" /></p>

<p><label for="password-login">Password:</label>
<input type="password" id="password-login" name="password" /></p>
<p><input type="submit" value="Entrar" /> </p>
</form>
EOD;



echo <<<EOD
<form method="POST"  action="register_check.php">
<h2>Register</h2>

<p><label for="name-register">Nombre y apellido:</label>
<input type="text" id="name-register" name="name" /></p>

<p><label for="birthdate">Fecha de naciemiento:</label>
<input type="date" id="birthdate" name="date" /></p>

<p><label for="username-register">Usuario:</label>
<input type="text" id="username-register" name="username" /></p>

<p><label for="mail-register">Email:</label>
<input type="email" id="mail-register" name="email" /></p>

<p><label for="password-register">Password:</label>
<input type="password" id="password-register" name="password" /></p>

<p><label for="password-check">Password:</label>
<input type="password" id="password-check" name="password-check" /></p>

<p><input type="submit" value="Enviar" /> </p>
</form>
EOD;

close_html ();


?>
