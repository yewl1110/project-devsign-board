<?php
require_once("db.class.php");
require_once("declared.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_GET["board_id"]) && isset($_SESSION["id"])){
    DB::connect();
    DB::query2("DELETE FROM board WHERE board_id = :board_id AND user_id = :user_id",
    array(
        ":board_id" => $_GET["board_id"],
        ":user_id" => $_SESSION["id"]
    ));
    echo "1";
}else{
    echo "0";
}
header("Location: ".getRootURL());
?>