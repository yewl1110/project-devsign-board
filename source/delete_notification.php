<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/session_handler.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/db.class.php';
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $result = 0; 
    if(isset($_GET["id"]) && isset($_SESSION['id'])) {
        DB::connect();

        $result = DB::query2('DELETE FROM notification WHERE id = :id AND user_id = :userId',
        array(
            ':id'     => (int)$_GET['id'],
            ':userId' => $_SESSION['id']
        ));
    }
    echo $result;
?>