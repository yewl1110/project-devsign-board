<?php
require_once('declared.php');
require_once('db.class.php');

class Auth
{
    public static function login($account)
    {
        $_SESSION = array();
        foreach($account as $key => $value){
            $_SESSION[$key] = $value;
        }
    }

    public static function logout()
    {
        setcookie("auto_login", null, -1, "/");
        setcookie("id", null, -1, "/");
        setcookie("token", null, -1, "/");
        $_SESSION = [];
        session_destroy();
    }

    public static function check_auto_login()
    {
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
    
                $account = array(
                    "id" => $rows['0']["id"],
                    "email" => $rows['0']["email"],
                    "name" => $rows['0']["name"],
                    "nickname" => $rows['0']["nickname"]
                );
                Auth::login($account);
                
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

    public static function set_auto_login($id){
        $token = bin2hex(random_bytes(32));
        DB::query2("DELETE FROM auth_tokens WHERE id = :id", array(":id" => $id));
        DB::query2("INSERT INTO auth_tokens VALUES (:id, :token, :expires)",
        array(
            ":id" => $id,
            ":token" => $token,
            ":expires" => date('Y-m-d H:i:s', strtotime('+3 days'))
        ));

        if(isset($_COOKIE["id"])){
            unset($_COOKIE["id"]); 
            setcookie("id", null, -1, '/'); 
        }
        if(isset($_COOKIE["token"])){
            unset($_COOKIE["token"]); 
            setcookie("token", null, -1, '/'); 
        }
        setcookie("auto_login", true, time()+3600*24*3, "/");
        setcookie("id", $id, time()+3600*24*3, "/");
        setcookie("token", $token, time()+3600*24*3, "/");
    }
}
