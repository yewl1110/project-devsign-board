<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/declared.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth.class.php';

@session_start();

if (session_status() != PHP_SESSION_NONE) {
    if(isset($_SESSION['ID'])) {
        if(isset($_SERVER["HTTP_REFERER"])){
            header("Location:" . $_SERVER["HTTP_REFERER"]);
            exit();
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["id"])) {
        DB::connect();
        DB::query2(
            "INSERT INTO member VALUES (:id, :passwd, :email, :name, :nickname, :email_key, 0)",
            array(
                ":id" => $_POST["id"],
                ":passwd" => password_hash($_POST["passwd"], PASSWORD_DEFAULT),
                ":email" => $_POST["email"],
                ":name" => $_POST["id"],
                ":nickname" => $_POST["id"],
                ":email_key" => ''
            )
        );

        Auth::send_verification_mail($_POST["id"], $_POST['email']);
        $data = array(
            'id' => base64_encode($_POST['id']),
            'email' => base64_encode($_POST['email'])
        );
        header("Location: " . getRootURL() . 'auth/verification_info.php?' . http_build_query($data));
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.0/css/bootstrap.css">
    <base href="..">
    <link rel="stylesheet" href="assets/css/register_member.css">
    <link rel="stylesheet" href="assets/css/theme.css">
</head>

<body>
    <main>
        <div id="join-form">
            <div style="text-align: center">
                <label>
                    <h3>
                        <a href="#">Devsign-board</a></h3>
                </label>
                <label>
                    <h3>회원가입</h3>
                </label>
            </div>
            <div id="join">
                <form action="member/register_member.php" method="POST">
                    <!-- ID -->
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-1">
                                <label style="color: red;">*</label>
                            </div>
                            <div class="col-9">
                                <input type="text" class="form-control invalid" id="value_id" name="id" placeholder="ID" required>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-outline-dark" id="check_id">Check</button>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-9 offset-1 invalid-feedback" id="message_id"></div>
                        </div>
                    </div>
                    <!-- 비밀번호 -->
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-1">
                                <label style="color: red;">*</label>
                            </div>
                            <div class="col-9">
                                <input type="password" class="form-control invalid" id="passwd" name="passwd" placeholder="Password" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-9 offset-1 invalid-feedback" id="message_passwd"></div>
                        </div>
                    </div>
                    <!-- 비밀번호 확인 -->
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-1">
                                <label style="color: red;">*</label>
                            </div>
                            <div class="col-9">
                                <input type="password" class="form-control invalid" id="confirm" name="confirm" placeholder="Re-enter password" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-9 offset-1 invalid-feedback" id="message_confirm"></div>
                        </div>
                    </div>
                    <!-- 이메일 -->
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-1">
                                <label style="color: red;">*</label>
                            </div>
                            <div class="col-9">
                                <input type="email" class="form-control invalid" id="value_email" name="email" placeholder="E-Mail" required>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-outline-dark" id="check_email">Check</button>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-9 offset-1 invalid-feedback" id="message_email"></div>
                        </div>
                    </div>
                    <!-- 버튼 -->
                    <div class="row justify-content-around">
                        <div class="col-sm-4 col-5">
                            <button type="submit" class="btn btn-secondary">Register</button>
                        </div>
                        <div class="col-sm-4 col-5">
                            <button class="btn btn-secondary" id="cancel">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <footer></footer>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/js/bootstrap.min.js"></script>
    <script src="assets/js/register_member.js" type="text/javascript"></script>
</body>

</html>