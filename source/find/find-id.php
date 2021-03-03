<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/errors.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/declared.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mail.class.php';

if (session_status() == PHP_SESSION_NONE) {
    @session_start();
}

$result = false;
if(isset($_POST['find-id-email']) && !isset($_SESSION['id'])) {
    DB::connect();

    $row = DB::query2("SELECT * FROM member WHERE email=:email LIMIT 1",
        array(
            ':email' => $_POST['find-id-email']
        ));

    if($row[0]['id'] != "") {
        $result = true;
        Mail::send(
            'ID 찾기 결과',
            Mail::getFindIdTemplate($row[0]['id']),
            array(
                array('email' => $_POST['find-id-email'],
                    'name' => $row[0]['id']))
        );
    }
}
echo json_encode(array(
    'success' => $result
));
