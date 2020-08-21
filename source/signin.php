<?php
require_once('declared.php');
require_once('db.class.php');
require_once('auth.class.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION["id"])){
    header("Location:".$_SERVER["HTTP_REFERER"]);
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["id"])){
        $_SESSION = array();

        DB::connect();
        $rows = DB::query2("SELECT * FROM member WHERE id = :id", 
        array(":id" => $_POST["id"]));
        
        if(!$rows['0'] || !password_verify($_POST["passwd"], $rows['0']["password"])){
            header("Location:".getRootURL()."/login.php?message=ACCOUNT_WRONG");
            exit(0);
        }else{
            $account = array(
                "id" => $rows['0']["id"],
                "email" => $rows['0']["email"],
                "name" => $rows['0']["name"],
                "nickname" => $rows['0']["nickname"]
            );
            Auth::login($account);
        }

        if(isset($_POST["auto_login"])){
            Auth::set_auto_login($_POST["id"]);
        }
    }
    header("Location:".getRootURL()."/index.php");
}
?>