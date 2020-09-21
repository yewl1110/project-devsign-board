<?php 
require_once('../auth.class.php');

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['id']) && isset($_GET['email'])){
        Auth::send_verification_mail(base64_decode($_GET['id']), base64_decode($_GET['email']));
    }
}
?>