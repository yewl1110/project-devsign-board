<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db.class.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SESSION["id"]) && isset($_POST["password"])){
    DB::connect();
    $row = DB::query2("SELECT password FROM member WHERE id = :id", array(":id" => $_SESSION["id"]));
    if(password_verify($_POST["password"], $row["0"]["password"])){
        DB::query2("DELETE FROM member WHERE id = :id", array(":id" => $_SESSION["id"]));

        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        header("Location: index.php");
    }else{
        header("Location: index.php?message=PASSWORD_WRONG");
    }
}else{
    header("Location: index.php?message=NO_AUTH");
}

?>