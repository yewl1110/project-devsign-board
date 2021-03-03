<?php
if (session_status() == PHP_SESSION_NONE) {
    @session_start();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/declared.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/errors.php';

if (isset($_GET["message"])) {
    ErrorManager::requestAlert($_GET["message"]);
}

if (isset($_SESSION["id"])) {
    header("Location: " . getRootURL());
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/css/bootstrap.css">
    <link href="/assets/css/login.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/theme.css" rel="stylesheet" type="text/css">
    <title>Devsign-board Login</title>
</head>

<body>
    <main>
        <div id="login-form">
            <div class="form-title">
                <label>
                    <h3>
                        <?php
                        echo '
                            <a href="' . getRootURL() . '">Devsign-board</a>
                            ';
                        ?>
                        로그인</h3>
                </label>
            </div>
            <div id="login">
                <form action="/auth/signin.php" method="POST">
                    <div class="form-group">
                        <div class="form-row">
                            <input type="text" class="form-control" name="id" placeholder="ID" required="required">
                        </div>
                        <div class="form-row">
                            <input type="password" class="form-control" name="passwd" placeholder="Password" required="required">
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
                            <a href="' . getRootURL() . 'member/register_member.php">회원가입</a>
                            <a href="' . getRootURL() . 'find">아이디/비밀번호 찾기</a>
                            ';
                        ?>
                    </div>
                </form>
            </div>
        </div>

    </main>
    <footer></footer>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/js/bootstrap.min.js"></script>
</body>

</html>