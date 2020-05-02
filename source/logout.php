<?php
require_once('declared.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

session_destroy();
$_SESSION = [];
setcookie(session_name(), '', 1);

header("Location:".getRootURL()."/index.php");
?>