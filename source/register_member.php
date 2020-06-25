<?php
require_once("declared.php");
require_once("db.class.php");

if (session_status() != PHP_SESSION_NONE) {
    header("Location:".$_SERVER["HTTP_REFERER"]);
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if($_POST["id"]){
        DB::connect();
        DB::query2("INSERT INTO member VALUES (:id, :passwd, :email, :name, :nickname)",
        array(
        ":id" => $_POST["id"],
        ":passwd" => password_hash($_POST["passwd"], PASSWORD_DEFAULT),
        ":email" => $_POST["email"],
        ":name" => $_POST["name"],
        ":nickname" => $_POST["nickname"]
        ));
        header("Location: ".getRootURL());
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/css/bootstrap.css">
    <link href="style/register_member.css" rel="stylesheet" type="text/css">
</head>
<body>
    <header>
        <?php write_header();?>
    </header>
    <main>
        <div class="container">
            <div class="row justify-content-center" id="container-head">
                <div class="col-6">
                    <h1>회원가입</h1>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-6" id="formbox">
                    <form class="" action="" method="POST">
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-1">
                                    <label style="color: red;">*</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control invalid" id="value_id" name="id" placeholder="ID" required>
                                    <div class="invalid-feedback" id="message_id"></div>
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-outline-dark" id="check_id">Check</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-1">
                                    <label style="color: red;">*</label>
                                </div>
                                <div class="col-9">
                                    <input type="password" class="form-control invalid" id="passwd" name="passwd" placeholder="Password" required>
                                    <div class="invalid-feedback" id="message_passwd">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-1">
                                    <label style="color: red;">*</label>
                                </div>
                                <div class="col-9">
                                    <input type="password" class="form-control invalid" id="confirm" name="confirm" placeholder="Re-enter password" required>
                                    <div class="invalid-feedback" id="message_confirm">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row"> 
                                <div class="col-1">
                                    <label style="color: red;">*</label>
                                </div>
                                <div class="col-9">
                                    <input type="email" class="form-control invalid" id="value_email" name="email" placeholder="E-Mail" required>
                                    <div class="invalid-feedback" id="message_email">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-outline-dark" id="check_email">Check</button>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-around">
                                <div class="col-4">
                                    <button type="submit" class="btn btn-secondary">Register</button>
                                </div>
                                <div class="col-4">
                                    <button class="btn btn-secondary" id="cancel">Cancel</button>
                                </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <footer></footer>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/js/bootstrap.min.js"></script>
    <script src="js/register_member.js" type="text/javascript"></script>
</body>
</html>
