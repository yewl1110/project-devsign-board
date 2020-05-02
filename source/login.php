<?php
require_once('declared.php');
require_once("errors.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_GET["message"])){
    ErrorManager::requestAlert($_GET["message"]);
}

if(isset($_SESSION["id"])){
    exit;
}
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
            <h1>로그인</h1>
            <div class="form-box">
                <form action="signin.php" method="POST">
                    <div class="login-box">
                        <input type="text" name="id" placeholder="ID" required><br>
                        <input type="password" name="passwd" placeholder="Password" required><br>
                        <input id="submit" type="submit" name="submit" value="로그인">
                    </div>
                    <span class="auto-login">
                        <label><input id="check_auto_login" type="checkbox" name="auto_login">자동로그인</label>
                    </span>
                </form>
                
                <div class="login-add-func">
                    <?php
                    echo '
                    <a href="'.getRootURL().'/register_member.php">회원가입</a>
                    <a href="">아이디/비밀번호 찾기</a>
                    ';
                    ?>
                </div>
            </div>
        </div>

    </div>
</body>
</html>