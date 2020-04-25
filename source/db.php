<?php 
require_once('errors.php');

class DB{
    private $db;
    private $stmt;
    function construct($id, $passwd){
        try{
            $db = new PDO($dsn, "pi", "980809");
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            write_log($e->getMessage());
        }
    }


    //
}

?>