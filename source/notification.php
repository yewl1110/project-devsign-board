<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/session_handler.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/db.class.php';
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    define('LIMIT', 10);

    $result = 0;  
    if(isset($_GET["index"]) && isset($_SESSION['id'])) {
        DB::connect();
        
        $tmpResult = array();
        if(isset($_GET["last_id"])) {
            $tmpResult = DB::query2('SELECT * FROM notification WHERE user_id = :userId AND id > :id ORDER BY reg_date',
            array(
                ':userId' => $_SESSION['id'],
                ':id'     => (int)$_GET['last_id']
            ));
        } else {
            $offset = LIMIT * (int)$_GET["index"];

            $tmpResult = DB::query2('SELECT * FROM notification WHERE user_id = :userId ORDER BY id desc LIMIT ' . LIMIT . ' OFFSET ' . $offset,
            array(
                ':userId' => $_SESSION['id']
            ));
        }

        $result = array();
        for($i = 0 ; $i < count($tmpResult) ; $i++) {
            $row = array();
            $row['id'] = $tmpResult[$i]['id'];
            $row['user_id'] = $tmpResult[$i]['user_id'];
            $row['data'] = json_decode($tmpResult[$i]['data']);
            $result[] = $row;
        }
    }
    echo json_encode($result);
?>