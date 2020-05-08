<?php
require_once("db.class.php");
// db에서 읽어와 마이페이지에 뿌려주는 코드 작성
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>