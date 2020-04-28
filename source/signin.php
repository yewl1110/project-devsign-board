<?php
require_once('declared.php');
$id = "syj";
$passwd = "123123";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["submit"])){
        // 정규식으로 거르는 코드 추가하기
        if($id != trim($_POST["id"]) || $passwd != $_POST["passwd"]){
            header("Location:".$_SERVER["HTTP_REFERER"]);
        }else{
            $_SESSION["id"] = $_POST["id"];
            echo "로그인성공";
            header("Location:".getRootURL()."/index.php");
        }
    }
}
?>