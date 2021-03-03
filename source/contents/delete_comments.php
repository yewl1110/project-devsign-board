<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/session_handler.php";
require_once $_SERVER['DOCUMENT_ROOT'] . '/errors.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/declared.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

DB::connect();

if($_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_GET["comment_id"]) && isset($_SESSION["id"])){
        $query = "SELECT board_id FROM comment WHERE comment_id = :comment_id";
        $params = array(
            ":comment_id" => $_GET['comment_id']
        );
        $result = DB::query2($query, $params);

        $board_id = $result['0']['board_id'];

        $query = "DELETE FROM comment WHERE comment_id = :comment_id AND user_id = :user_id";
        $params = array(
            ":comment_id" => $_GET['comment_id'],
            ":user_id" => $_SESSION["id"]
        );
        DB::query2($query, $params);

        $query = "UPDATE board SET comment_count = comment_count - 1 WHERE board_id = " . $board_id;
        DB::query1($query);
        echo '0';
        exit();
    }
}
header("Location:".getRootURL());
?>
