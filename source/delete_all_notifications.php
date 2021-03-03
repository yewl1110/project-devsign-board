<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/session_handler.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/db.class.php';
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $result = 0;  
    if(isset($_SESSION['id'])) {
        DB::connect();

        $offset = LIMIT * (int)$_GET["index"];

        $result = DB::query2('DELETE FROM notification WHERE user_id = :userId',
        array(
            ':userId' => $_SESSION['id']
        ));
    }
    echo $result;
?>