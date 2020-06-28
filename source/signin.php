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
    if(isset($_POST["id"])){
        $_SESSION = array();

        DB::connect();
        $rows = DB::query2("SELECT * FROM member WHERE id = :id", 
        array(":id" => $_POST["id"]));
        
        if(!$rows['0'] || !password_verify($_POST["passwd"], $rows['0']["password"])){
            header("Location:".getRootURL()."/login.php?message=ACCOUNT_WRONG");
            exit(0);
        }else{
            $_SESSION["id"] = $rows['0']["id"];
            $_SESSION["email"] = $rows['0']["email"];
            $_SESSION["name"] = $rows['0']["name"];
            $_SESSION["nickname"] = $rows['0']["nickname"];
        }

        if(isset($_POST["auto_login"])){
            $token = bin2hex(random_btyes(64));
            DB::query2("DELETE FROM auth_tokens WHERE id = :id", array(":id" => $_POST["id"]));
            DB::query2("INSERT INTO auth_tokens VALUES (:id, :token, :expires)",
            array(
                ":id" => $_POST["id"],
                ":token" => $token,
                ":expires" => strtotime(date('Y-m-d', strtotime('+3 days')));
            ));

            if(isset($_COOKIE["id"])){
                unset($_COOKIE["id"]); 
                setcookie("id", null, -1, '/'); 
            }
            if(isset($_COOKIE["token"])){
                unset($_COOKIE["token"]); 
                setcookie("token", null, -1, '/'); 
            }
            setcookie("id", $_POST["id"], time()+3600*24*3, "/");
            setcookie("token", hash("sha256", $token), time()+3600*24*3, "/");
        }
    }
    header("Location:".getRootURL()."/index.php");
}
?>