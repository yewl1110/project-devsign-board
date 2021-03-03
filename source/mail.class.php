<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER['DOCUMENT_ROOT'] . '/assets/lib/phpmailer/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/assets/lib/phpmailer/SMTP.php';
require $_SERVER['DOCUMENT_ROOT'] . '/assets/lib/phpmailer/Exception.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/declared.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/errors.php';

class Mail{
    private static $username = "yewl1110@naver.com";
    private static $password = "syj2468916na";
    private static $host = "smtp.naver.com";
    private static $port = 465;
    private static $smtpSecure = "ssl";
    private static $charset = "utf-8";

    public static function send($subject, $body, $address_array){
        $mail = new PHPMailer(true);
        try{
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $mail->SMTPDebug = 2;
            $mail->isSMTP();
        
            $mail->Host = self::$host;
            $mail->SMTPAuth = true;
            $mail->Username = self::$username;
            $mail->Password = self::$password;
            $mail->SMTPSecure = self::$smtpSecure;
            $mail->Port = self::$port;
        
            $mail->CharSet = self::$charset;
            $mail->setFrom(self::$username, "hotcat");
            foreach($address_array as $address){
                $mail->addAddress($address['email'], $address['name']);
            }
        
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;
            
            $mail->send();
        }catch(Exception $e){
            ErrorManager::write_log($mail->ErrorInfo);
            echo $mail->ErrorInfo;
        }finally{
            $mail = NULL;
        }
    }

    public static function getFindIdTemplate($id){
        $url = getRootURL() . 'auth/login.php';
        return '
        <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
        </head>

        <body style="margin: 0; padding: 0;">
            <table style="width:100%; font-family: sans-serif">
                <tr>
                    <td align="center" style="padding: 10px 10px 10px 10px;">
                        <table border="1" align="center" cellpadding="0" cellspacing="0" width="600">
                            <tr>
                                <td style="padding: 10px 10px 10px 10px;">
                                    <table cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td style="padding: 10px 10px 10px 10px">
                                                <label>
                                                    <h1><a href="' . getRootURL() . '" style="color: rgba(0, 0, 0, 0.7); font-weight: bold; text-decoration: none;">Devsign-board</a>
                                                    </h1>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr style="height:auto">
                                            <td style="padding: 10px 20px 10px 20px; height:auto;">
                                                <table width="100%" style=" box-sizing: border-box;">
                                                    <tr>
                                                        <td style="font-size: 1.2rem;">ID 찾기 결과입니다.</td>
                                                    </tr>
                                                    <tr style="text-align: center;">
                                                        <td style="padding: 15px 20px 15px 20px;">
                                                            <span
                                                                style="display:inline-block; min-width: 200px; background-color: #e6e6e6; color: rgba(0, 0, 0, 0.7);">
                                                                <h2>' . $id . '</h2>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr style="text-align: center;">
                                                        <td style="padding-bottom: 20px;">
                                                            <button style="display: inline-block; height:auto; font-weight: 400; text-align: center; vertical-align: middle; border: 1px solid transparent; padding: .5rem 1rem; font-size: 1.25rem; line-height: 1.5; border-radius: .3rem; color: #fff; background-color: #343a40; border-color: #343a40;"><a href="' . $url . '" style="font-size: 1.1rem; color: white; text-decoration: none">사이트로 이동</a></button>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>

        </html>';
    }

    public static function getFindPwTemplate($data) {
        $url = getRootURL() . 'find/change.php?email=' . base64_encode($data['email']) . '&email_key=' . base64_encode($data['email_key']);
        // return '
        //     비밀번호 초기화 메일<br>
        //     id: ' . $data['user_id'] . '<br>
        //     <a href="' . $url . '">Link</a>
        // ';
        return '
        <html>

        <head>
            <meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
        </head>

        <body style="margin: 0; padding: 0;">
            <table style="width:100%; font-family: sans-serif">
                <tr>
                    <td align="center" style="padding: 10px 10px 10px 10px;">
                        <table border="1" align="center" cellpadding="0" cellspacing="0" width="600">
                            <tr>
                                <td style="padding: 10px 10px 10px 10px;">
                                    <table cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td style="padding: 10px 10px 10px 10px">
                                                <label>
                                                    <h1><a href="' . getRootURL() . '" style="color: rgba(0, 0, 0, 0.7); font-weight: bold; text-decoration: none;">Devsign-board</a>
                                                    </h1>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr style="height:auto">
                                            <td style="padding: 10px 20px 10px 20px; height:auto;">
                                                <table width="100%" style=" box-sizing: border-box;">
                                                    <tr>
                                                        <td style="padding: 15px 20px 15px 20px; font-size: 1.2rem;">링크를 누르면 비밀번호 초기화 페이지로 이동합니다.</td>
                                                    </tr>
                                                    <tr style="text-align: center;">
                                                        <td style="padding: 15px 20px 15px 20px;">
                                                            <button style="display: inline-block; height:auto; font-weight: 400; text-align: center; vertical-align: middle; border: 1px solid transparent; padding: .5rem 1rem; font-size: 1.25rem; line-height: 1.5; border-radius: .3rem; color: #fff; background-color: #343a40; border-color: #343a40;"><a href="' . $url . '" style="font-size: 1.1rem; color: white; text-decoration: none;">사이트로 이동</a></button>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>

        </html>
        ';
    }
}
?>