<?php

session_start();

session_destroy();

$_COOKIE["logout"] = $name;

setcookie("logout", $name);

header("Location: index.php?logout=");

exit();
?>