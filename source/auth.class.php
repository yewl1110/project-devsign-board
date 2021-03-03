<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/session_handler.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/declared.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mail.class.php';

class Auth
{
    public static function login($account)
    {
        // 이메일 인증이 된 계정일 때
        if (self::check_verification($account)) {
            // 세션 생성
            $_SESSION = array();
            foreach ($account as $key => $value) {
                $_SESSION[$key] = $value;
            }
        } else {
            // 인증 페이지로 이동시킴 POST로 ID도 같이 보내야함

            $data = array('id' => $account['id'], 'email' => $account['email']);

            header("Location: " . getRootURL() . "auth/verification_info.php?" . http_build_query($data));
            exit();
        }
    }

    public static function logout()
    {
        // 자동 로그인 해제
        setcookie("auto_login", null, -1, "/");
        setcookie("id", null, -1, "/");
        setcookie("token", null, -1, "/");

        // 세션 제거
        // $_SESSION = [];
        //session_unset();
        session_destroy(); // 서버 측 세션 종료
    }

    public static function isLogin(){
        return isset($_SESSION["id"]);
    }

    // 자동 로그인인지 체크
    public static function check_auto_login()
    {
        $url = getRootURL();
        if (isset($_SERVER['HTTP_REFERER'])) {
            $url = $_SERVER['HTTP_REFERER'];
        }

        if (isset($_COOKIE["id"]) && isset($_COOKIE["token"])) {
            DB::connect();

            $rows = DB::query2(
                "SELECT token, expires FROM auth_tokens WHERE id = :id",
                array(":id" => $_COOKIE["id"])
            );

            // 토큰 중복 생성이나 토큰 시간 만료시 기존 토큰 삭제
            if (count($rows) != 1 || strtotime($rows['0']['expires']) < strtotime(time()) || !hash_equals($rows['0']['token'], $_COOKIE["token"])) {
                DB::query2("DELETE FROM auth_tokens WHERE id = :id", array(":id" => $_COOKIE["id"]));
            } else {
                // 유효한 토큰이면 로그인
                $rows = DB::query2(
                    "SELECT * FROM member WHERE id = :id",
                    array(":id" => $_COOKIE["id"])
                );

                $account = array(
                    "id" => $rows['0']["id"],
                    "email" => $rows['0']["email"],
                    "name" => $rows['0']["name"],
                    "nickname" => $rows['0']["nickname"]
                );
                Auth::login($account);

                // 자동로그인 기간 연장
                $time = time() + 3600 * 24 * 3;
                DB::query2(
                    "UPDATE auth_tokens SET expires = :time WHERE id = :id AND token = :token",
                    array(
                        ":id" => $_COOKIE["id"],
                        ":token" => $_COOKIE["token"],
                        ":time" => date('Y-m-d H:i:s', $time)
                    )
                );
                setcookie("auto_login", true, $time, "/");
                setcookie("id", $_COOKIE["id"], $time, "/");
                setcookie("token", $_COOKIE["token"], $time, "/");
            }
        }
    }

    // 자동로그인 설정
    public static function set_auto_login($id)
    {
        // 인증 위한 토큰 생성 후 저장
        $token = bin2hex(random_bytes(32));
        DB::query2("DELETE FROM auth_tokens WHERE id = :id", array(":id" => $id));
        DB::query2(
            "INSERT INTO auth_tokens VALUES (:id, :token, :expires)",
            array(
                ":id" => $id,
                ":token" => $token,
                ":expires" => date('Y-m-d H:i:s', strtotime('+3 days'))
            )
        );

        // 기존에 설정된 자동 로그인 해제
        if (isset($_COOKIE["id"])) {
            unset($_COOKIE["id"]);
            setcookie("id", null, -1, '/');
        }
        if (isset($_COOKIE["token"])) {
            unset($_COOKIE["token"]);
            setcookie("token", null, -1, '/');
        }

        // 새로운 자동 로그인 설정
        // 쿠키 생성
        setcookie("auto_login", true, time() + 3600 * 24 * 3, "/");
        setcookie("id", $id, time() + 3600 * 24 * 3, "/");
        setcookie("token", $token, time() + 3600 * 24 * 3, "/");
    }

    // 이메일 인증 여부 확인
    public static function check_verification($account)
    {
        DB::connect();
        $row = DB::query2(
            "SELECT activated FROM member WHERE id = :id",
            array(":id" => $account["id"])
        );
        if ($row[0]["activated"] == '1') {
            DB::query2(
                "UPDATE member SET email_key='' WHERE id = :id",
                array(":id" => $account["id"])
            );
            return true;
        } else {
            return false;
        }
    }

    // 이메일 인증키 생성, 인증 메일 전송
    public static function send_verification_mail($id, $email)
    {
        DB::connect();
        $email_key = hash('sha256', rand());
        $row = DB::query2(
            "SELECT email, name, email_key FROM member WHERE id = :id",
            array(
                ":id" => $id
            )
        );

        if ($row[0]["email"] == $email && $row[0]['email_key'] != '') {
            DB::query2(
                "UPDATE member SET email_key = :email_key WHERE email = :email",
                array(
                    ":email_key" => $email_key,
                    ":email" => $row[0]["email"]
                )
            );

            $send_data = array(
                "email" => base64_encode($row[0]["email"]),
                "email_key" => $email_key
            );

            $send_address = [];
            array_push($send_address, array(
                "email" => $row[0]["email"],
                "name" => $row[0]["name"]
            ));

            Mail::send(
                "이메일 인증이 필요합니다.",
                '
        url을 클릭하면 이메일 인증이 완료됩니다.<br>
        <a href="' . getRootURL() . 'auth/verification_mail.php?' . http_build_query($send_data) . '">Link</a>
        ',
                $send_address
            );
        }
    }
}
