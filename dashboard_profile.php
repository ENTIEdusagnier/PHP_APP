<?php

require_once("func.check_session.php");
$session = check_session();

if (!$session) {
    header("Location: login.php");
    exit();
}

require_once("template.php");
open_html ("Dashboard");

require_once("func.dashboard_menu.php");
dashboard_menu();




close_html();

?>