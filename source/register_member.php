<?php
require_once("declared.php");
require_once("db.class.php");

if (session_status() != PHP_SESSION_NONE) {
    header("Location:".$_SERVER["HTTP_REFERER"]);
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if($_POST["submit"]){
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="js/register_member.js" type="text/javascript"></script>
</head>
<body>
<link href="register_member.css" rel="stylesheet" type="text/css">
    <div class="main">
        <?php write_header();?>
        <div class="contents">
            <h1>회원가입</h1>
            <div class="form-box">
                <form action="" method="POST">
                    <table>
                        <tr>
                            <th style="width: 50px;"></th>
                            <th style="width: 300px;"></th>
                            <th style="width: 100px;"></th>
                        </tr>
                        <tr>
                            <td><label style="color: red;">* </label></td>
                            <td><input id="value_id" type="text" name="id" placeholder="ID" required></td>
                            <td><button id="check_id">Check</button></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><label id="message_id"> </label></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><label style="color: red;">* </label></td>
                            <td><input id="passwd" type="password" name="passwd" placeholder="Password" required></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><label style="color: red;">* </label></td>
                            <td><input id="confirm" type="password" name="confirm" placeholder="Re-enter password" required></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><label id="message_passwd"> </label></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><label style="color: red;">* </label></td>
                            <td><input id="value_email" type="email" name="email" placeholder="E-Mail" required></td>
                            <td><button id="check_email">Check</button></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><label id="message_email"> </label></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="text" name="name" placeholder="Name"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="text" name="nickname" placeholder="Nickname"></td>
                            <td></td>
                        </tr>
                    </table>
                    <div class="buttons">
                        <input type="submit" name="submit" value="Register">
                        <button id="Cancel">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
