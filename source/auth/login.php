<?php
require_once('../declared.php');
require_once("../errors.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_GET["message"])){
    ErrorManager::requestAlert($_GET["message"]);
}

if(isset($_SESSION["id"])){
    header("Location: ".getRootURL());
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/css/bootstrap.css">
    <link href="../style/login.css" rel="stylesheet" type="text/css">
    <style>
        body{
            background-color:#FAFAFA;
        }
        .container-md {
            padding: 100px 0 100px 0;
        }
    </style>
</head>
<body>
    <main>
        <div class="container-md">
            <div class="row justify-content-center">
                <div class="col-5" id="container-header">
                    <h1>로그인</h1>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-4" id="login">
                    <form action="signin.php" method="POST">
                        <div class="form-group">
                            <div class="form-row">
                                <input type="text" class="form-control" name="id" placeholder="ID" required>
                            </div>
                            <div class="form-row">
                                <input type="password" class="form-control" name="passwd" placeholder="Password" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <button type="submit" class="btn btn-secondary btn-block">로그인</button>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="auto_login" name="auto_login">
                                <label class="form-check-label" for="auto_login">자동로그인</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php
                            echo '
                            <a href="'.getRootURL().'member/register_member.php">회원가입</a>
                            <a href="">아이디/비밀번호 찾기</a>
                            ';
                            ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </main>
    <footer></footer>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/js/bootstrap.min.js"></script>
</body>
</html>