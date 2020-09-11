<?php
require_once('../declared.php');
require_once('../db.class.php');
require_once('../auth.class.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//이미 로그인 되어있을 경우
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
            // 아이디가 존재하지 않거나 비밀번호가 틀릴 때
            header("Location: login.php?message=ACCOUNT_WRONG");
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
        
        // 자동로그인 체크했을 때
        if(isset($_POST["auto_login"])){
            Auth::set_auto_login($_POST["id"]);
        }
    }
    header("Location:".getRootURL());
}
?>