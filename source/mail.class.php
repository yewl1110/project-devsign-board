<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require('phpmailer/PHPMailer.php');
require('phpmailer/SMTP.php');
require('phpmailer/Exception.php');
require_once('errors.php');

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
}
?>