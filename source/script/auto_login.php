<?php
require_once('declared.php');
require_once('db.class.php');


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION["id"])){
    header("Location:".$_SERVER["HTTP_REFERER"]);
}

if(isset($_COOKIE["id"]) && isset($_COOKIE["token"])){
    DB::connect();

    $rows = DB::query2("SELECT token, expires FROM auth_tokens WHERE id = :id",
        array(":id" => $_POST["id"]));

    // 토큰 중복 생성 또는 토큰 만료시
    if(len($rows) != 1 || strtotile($rows[0]['expires']) < strtotile(date('Y-m-d')) || !hash_equals($rows[0]['token'], $_COOKIE["token"])){
        DB::query2("DELETE FROM auth_tokens WHERE id = :id", array(":id" => $_COOKIE["id"]));
        header("Location:".getRootURL()."/index.php"); // 잘못된 접근이라고 말하기
        exit(0);
    }else { // 유효한 토큰
        $_SESSION["id"] = $rows['0']["id"];
        $_SESSION["email"] = $rows['0']["email"];
        $_SESSION["name"] = $rows['0']["name"];
        $_SESSION["nickname"] = $rows['0']["nickname"];
        
        // 토큰 연장
        setcookie("id", $_COOKIE["id"], time()+3600*24*3, "/");
        setcookie("token", $_COOKIE["token"], time()+3600*24*3, "/");
        header("Location:".getRootURL()."/index.php");
    }
}
?>