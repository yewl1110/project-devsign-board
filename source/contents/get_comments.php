<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/session_handler.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db.class.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_GET["board_id"]) && isset($_GET["index"])){
    DB::connect();
    
    $index = (isset($_GET["index"]) && ($_GET["index"] != '0')) ? ' AND comment_id < ' . $_GET["index"] : '';

    $rows = DB::query2('SELECT comment_id, user_id, contents, reg_date FROM comment WHERE board_id = :id' . $index . ' order by reg_date desc limit :limit', 
    array(
        ":id" => $_GET["board_id"],
        ":limit" => 15));
    
    // 유효하지 않은 board_id일 때
    if($rows == null || count($rows) == 0){
        echo "0";
        exit();
    }
    $id = isset($_SESSION['id']) ? $_SESSION['id'] : '';
    for($i = 0; $i < count($rows) ; $i++) {
        $rows[$i]['edit'] = (strcmp($rows[$i]['user_id'], $id) == 0) ? 1 : 0;
    }

    print_r(json_encode($rows));
}else{
    echo "0";
}
?>