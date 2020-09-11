<?php
require_once('declared.php');
require_once('auth.class.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

Auth::logout();

header("Location:".getRootURL()."index.php");
?>