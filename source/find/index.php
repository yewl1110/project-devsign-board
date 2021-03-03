<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/declared.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/errors.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth.class.php';

if (session_status() == PHP_SESSION_NONE) {
    @session_start();
}

if (isset($_GET["message"])) {
    ErrorManager::requestAlert($_GET["message"]);
}

if (Auth::isLogin()) {
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
    <title>Find Account</title>
</head>

<body>
    <main>
        <div class="container" id="find-form">
            <div class="row mb-4 form-title">
                <label>
                    <h3>
                        <?php
                        echo '
                        <a href="' . getRootURL() . '">Devsign-board</a>
                        ';
                        ?>
                        계정 찾기</h3>
                </label>
            </div>
            <div class="row form-wrapper mb-1">
                <div class="col-12 form-sub-title">
                    <label>
                        <h5>ID 찾기</h5>
                    </label>
                </div>
                <div class="col-12">
                    <form method="POST" id="find-id-form">
                        <div class="form-group">
                            <input type="email" class="form-control" id="find-id-email"  name="find-id-email" placeholder="EMAIL" required="required">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-light" type="submit">찾기 <i class="fas fa-chevron-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row form-wrapper">
                <div class="col-12 form-sub-title">
                    <label>
                        <h5>PW 찾기</h5>
                    </label>
                </div>
                <div class="col-12">
                    <form method="POST" id="find-password-form">
                        <div class="form-group">
                            <input type="text" class="form-control" id="find-pw-id" name="find-pw-id" placeholder="ID" required="required">
                            <input type="email" class="form-control" id="find-pw-email" name="find-pw-email" placeholder="EMAIL" required="required">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-light" type="submit">찾기 <i class="fas fa-chevron-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/8426c7d90d.js" crossorigin="anonymous"></script>
    <script src="./index.js"></script>
</body>

</html>