<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/errors.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/declared.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mail.class.php';

if (session_status() == PHP_SESSION_NONE) {
    @session_start();
}

$result = false;
if(isset($_POST['find-pw-email']) && !isset($_SESSION['id'])) {
    DB::connect();

    $row = DB::query2("SELECT * FROM member WHERE id=:id AND email=:email AND activated = 1 LIMIT 1",
        array(
            ':id'      => $_POST['find-pw-id'],
            ':email'   => $_POST['find-pw-email']
        ));
        
    if($row[0]['id'] != "") {
        $id = $row[0]['id'];
        $email = $_POST['find-pw-email'];
        $email_key = hash('sha256', rand());

        $data = array(
            'email'     => $email,
            'user_id'   => $id,
            'email_key'      => $email_key
        );

        DB::query2("UPDATE member SET email_key=:email_key WHERE id=:id",
        array(
            ':email_key'    => $email_key,
            ':id'        => $id
        ));
        
        Mail::send(
            '비밀번호 재설정',
            Mail::getFindPwTemplate($data),
            array(
                array(
                    'name'  => $id,
                    'email' => $email
            ))
        );

        $result = true;
    }
}
echo json_encode(array(
    'success' =>$result
));
