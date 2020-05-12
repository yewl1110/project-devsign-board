<?php
require_once("db.class.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_GET["board_id"])){
    DB::connect();
    $result = array();
    $rows = DB::query2("SELECT user_id, user_name, subject, contents, hits, reg_date FROM board WHERE board_id = :id", array(":id" => $_GET["board_id"]));
    $result["board"] = $rows;

    $id = $rows["0"]["user_id"];
    if(!isset($_SESSION["id"]) || $_SESSION["id"] != $id){
        DB::query2("UPDATE board SET hits = hits + 1 WHERE board_id = :id", array(":id" => $_GET["board_id"]));
    }
    
    $rows = DB::query2("SELECT file_name_origin, file_name_save FROM table_attach WHERE board_id = :id", array(":id" => $_GET["board_id"]));
    $result["table_attach"] = $rows;

    print_r(json_encode($result));
}else{
    echo "0";
}
?>