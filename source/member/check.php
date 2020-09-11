<?php
require_once("../db.class.php");

DB::connect();

if(isset($_GET["id"])){
    $rows = DB::query2("SELECT count(*) FROM member WHERE id=:id", array(":id"=>$_GET["id"]));
    echo $rows["0"]["count(*)"];
}

if(isset($_GET["email"])){
    $rows = DB::query2("SELECT count(*) FROM member WHERE email=:email", array(":email"=>$_GET["email"]));
    echo $rows["0"]["count(*)"];
}

?>