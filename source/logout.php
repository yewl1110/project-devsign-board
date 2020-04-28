<?php
require_once('declared.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION["id"])){
    session_unset();
    session_destroy();
}
header("Location:".getRootURL()."/index.php");
?>