<?php
require_once('declared.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<link href="login.css" rel="stylesheet" type="text/css">
    <div class="main">
        <?php write_header();?>
        <div class="contents">
            <div class="login-box">
                <form action="signin.php" method="POST">
                    <label>ID</label>
                    <input type="text" name="id" required><br>
                    <label>Password</label>
                    <input type="password" name="passwd" required><br>
                    <input type="submit" name="submit">
                </form>
            </div>
            <div class="login-add-func">
                <a href="">회원가입</a>
                <a href="">아이디/비밀번호 찾기</a>
            </div>
        </div>

    </div>
</body>
</html>