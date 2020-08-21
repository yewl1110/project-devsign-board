<?php
require_once('declared.php');
require_once('db.class.php');

function check_auto_login(){
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $url = getRootURL();
    if(isset($_SERVER['HTTP_REFERER'])){
        $url = $_SERVER['HTTP_REFERER'];
    }
    
    if(isset($_COOKIE["id"]) && isset($_COOKIE["token"])){
        DB::connect();
    
        $rows = DB::query2("SELECT token, expires FROM auth_tokens WHERE id = :id",
            array(":id" => $_COOKIE["id"]));
    
        // 토큰 중복 생성 또는 토큰 만료시
        if(count($rows) != 1 || strtotime($rows['0']['expires']) < strtotime(time()) || !hash_equals($rows['0']['token'], $_COOKIE["token"])){
            DB::query2("DELETE FROM auth_tokens WHERE id = :id", array(":id" => $_COOKIE["id"]));
        }else { // 유효한 토큰
            $rows = DB::query2("SELECT * FROM member WHERE id = :id", 
            array(":id" => $_COOKIE["id"]));

            $_SESSION["id"] = $rows['0']["id"];
            $_SESSION["email"] = $rows['0']["email"];
            $_SESSION["name"] = $rows['0']["name"];
            $_SESSION["nickname"] = $rows['0']["nickname"];
            
            // 토큰 연장
            $time = time()+3600*24*3;
            DB::query2("UPDATE auth_tokens SET expires = :time WHERE id = :id AND token = :token",
                array(
                    ":id" => $_COOKIE["id"],
                    ":token" => $_COOKIE["token"],
                    ":time" => date('Y-m-d H:i:s', $time)
                ));
            setcookie("auto_login", true, $time, "/");
            setcookie("id", $_COOKIE["id"], $time, "/");
            setcookie("token", $_COOKIE["token"], $time, "/");
        }
    }
}
