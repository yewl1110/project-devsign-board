<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/errors.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/declared.php';

if (session_status() == PHP_SESSION_NONE) {
    @session_start();
}

$result = false;
if(isset($_POST['new-password'])) {
    DB::connect();

    if($_POST['new-password'] != '' && $_POST['new-password'] == $_POST['confirm']) {
        $queryResult = DB::query2("UPDATE member SET password=:new_password, email_key=:new_email_key WHERE eamail=:email AND email_key=:email_key",
            array(
                ':new_password' => password_hash($_POST['new-password'], PASSWORD_DEFAULT),
                ':new_email_key'=> '',
                ':email'        => base64_decode($_POST['email']),
                ':email_key'    => base64_decode($_POST['email_key'])
            ));
        // if(empty($queryResult) == 0) {
        // }
        $result = true;
    }
}
echo json_encode(array(
    'success' => $result
));

?>