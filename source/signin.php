<?php
require_once('declared.php');
require_once('db.class.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION["id"])){
    header("Location:".$_SERVER["HTTP_REFERER"]);
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["submit"])){
        DB::connect();
        $rows = DB::query2("SELECT id, password FROM member WHERE id = :id", 
        array(":id" => $_POST["id"]));
        
        
        if(!$rows['0'] || !password_verify($_POST["passwd"], $rows['0']["password"])){
            header("Location:".getRootURL()."/login.php?message=ACCOUNT_WRONG");
        }else{
            $_SESSION["id"] = $rows['0']["id"];
            $_SESSION["nickname"] = $rows['0']["nickname"];
            print_r($_COOKIE);
            //로그인 성공
            header("Location:".getRootURL()."/index.php");
        }
    }
}
?>