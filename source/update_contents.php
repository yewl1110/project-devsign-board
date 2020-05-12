<?php 
require_once("declared.php");
require_once("db.class.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_POST["board_id"])){
    DB::connect();
    $rows = DB::query2("SELECT user_id FROM board WHERE board_id = :board_id",
    array(":board_id" => $_POST["board_id"]));

    if($rows["0"]["user_id"] == $_SESSION["id"]){
        DB::query2("UPDATE board SET subject = :subject, contents = :contents WHERE board_id = :board_id",
        array(":subject" => $_POST["subject"],
        ":contents" => htmlspecialchars($_POST['contents'], ENT_QUOTES),
        ":board_id" => $_POST["board_id"]));
    }
    header("Location: ".getRootURL());
}

?>