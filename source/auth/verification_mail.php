<?php
//회원가입 후 이메일로 인증
require_once('../mail.class.php');
require_once('../db.class.php');
require_once('../declared.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION["id"])) {
    header("Location: " . getRootURL());
}

// 이메일, 키 검증
if (isset($_GET["email"]) && isset($_GET["email_key"])) {
    try {
        DB::connect();
    } catch (PDOException $e) {
        exit();
    }

    $email = base64_decode($_GET["email"]);
    // email key의 유효시간까지 확인해야함
    $result = DB::query2(
        "SELECT id FROM member WHERE email = :email AND email_key = :email_key",
        array(
            ":email" => $email,
            ":email_key" => $_GET["email_key"]
        )
    );

    if ($result[0]['id'] != '') {
        // 유효한 키면 키 제거
        DB::query2(
            "UPDATE member SET email_key = '' WHERE email = :email AND email_key = :email_key",
            array(
                ":email" => $email,
                ":email_key" => $_GET["email_key"]
            )
        );
        echo '
        <script>
            if(!alert("인증되었습니다.")){
                document.location = ' . getRootURL() . '
            }
        </script>';
        return;
    }
}

echo '
<script>
if(!alert("잘못된 링크입니다.")){
    close();
}
</script>';
