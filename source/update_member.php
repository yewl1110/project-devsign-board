<?php
require_once("db.class.php");
require_once("errors.php");

if(isset($_POST["id"])){
    DB::connect();
    $rows = DB::query2("SELECT password FROM member WHERE id = :id", array(":id" => $_POST["id"]));
    $query = "UPDATE member SET name = :name, nickname = :nickname WHERE id = :id";
    $params = array();
    $params[":name"] = $_SESSION["name"] = $_POST["name"];
    $params[":nickname"] = $_SESSION["nickname"] = $_POST["nickname"];
    $params[":id"] = $_POST["id"];
    
    if($_POST["new_password"] != ''){
        if(!password_verify($_POST["password"], $rows["0"]["password"])){
            echo -1;
        }else{
            $query = "UPDATE member SET name = :name, nickname = :nickname, password = :password WHERE id = :id";
            $params[":password"] = password_hash($_POST["new_password"], PASSWORD_DEFAULT);
            DB::query2($query, $params);
            echo 1;
        }
    }else{
        DB::query2($query, $params);
        echo 1;
    }
}else{
    echo -2;
}
?>