<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/errors.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/declared.php';

DB::connect();

$result = false;

if(isset($_GET['email']) && isset($_GET['email_key'])) {
    $row = DB::query2('SELECT * FROM member WHERE email = :email AND email_key = :email_key',
            array(
                ':email'    => base64_decode($_GET['email']),
                ':email_key'=> base64_decode($_GET['email_key'])
            ));
            
    if(count($row) > 0 && $row[0]['id'] != '') {
        $result = true;
    }
}

if(!$result) {
    header('Location: ' . getRootURL());
    exit();
}
?>
<!DOCTYPE html>
<html>


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/css/bootstrap.css">
    <link href="/assets/css/find.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/theme.css" rel="stylesheet" type="text/css">
    <title>Change Password</title>
</head>

<body>
    <main>
        <div class="container form-wrapper">
            <div class="form-title mb-3">
                <label><h4>새 비밀번호 설정</h4></label>
            </div>
            <form id="change-form">
                <div class="form-group">
                    <div class="form-sub-title">
                        <label>New Password</label>
                    </div>
                    <input type="password" class="form-control" id="new-password" name="new-password">
                </div>
                <div class="form-group">
                    <div class="form-sub-title">
                        <label>Confirm</label>
                    </div>
                    <input type="password" class="form-control" id="confirm" name="confirm">
                </div>
                <div class="form-group submit">
                    <div class="alert alert-danger col-12" id="message-passwd" role="alert">
                    </div>
                    <button class="btn btn-light" type="submit">확인 <i class="fas fa-chevron-right"></i></button>
                </div>
            </form>
        </div>
    </main>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/8426c7d90d.js" crossorigin="anonymous"></script>
    <script src="./index.js"></script>
    <script src="./change.js"></script>
</html>