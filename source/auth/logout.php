<?php
require_once('../auth.class.php');
require_once('../declared.php');

Auth::logout();

header("Location:".getRootURL());
?>