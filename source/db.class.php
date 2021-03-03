<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/errors.php';

class DB{
    private static $conn;
    private static $conn2;
    private static $stmt;
    private static $id = "pi";
    private static $passwd = "980809";
    private static $dsn;

    public static function connect(){
        if(!self::$conn){
            self::$dsn = "mysql:host=localhost;port=3306;dbname=devsign_board;charset=utf8";
            try{
                self::$conn = new PDO(self::$dsn, self::$id, self::$passwd);
                self::$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                ErrorManager::write_log($e->getMessage());
                throw $e;
            }
        }
    }

    public static function query1($query){
        try{
            self::$stmt = self::$conn->query($query);
            $result = self::$stmt->fetchAll();
        }catch(PDOEXCEPTION $e){
            ErrorManager::write_log($e->getMessage());
            $result = null;
        }
        return $result;
    }

    public static function query2($query, $params){
        try{
            self::$stmt = self::$conn->prepare($query);
            foreach($params as $column=>$value){
                self::$stmt->bindValue($column, $value);
            }
            self::$stmt->execute();
            $result = self::$stmt->fetchAll();
        }catch(PDOEXCEPTION $e){
            ErrorManager::write_log($e->getMessage());
            $result = null;
        }
        return $result;
    }
    
    public static function lastInsertId(){
        if(self::$conn){
            return self::$conn->lastInsertId();
        }
    }

    public static function getFilePath(){
        return $_SERVER['DOCUMENT_ROOT'] . "/../files/";
    }

    public static function connectSession(){
        if(!self::$conn2){
            self::$dsn = "mysql:host=localhost;port=3306;dbname=session;charset=utf8";
            try{
                self::$conn2 = new PDO(self::$dsn, self::$id, self::$passwd);
                self::$conn2->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                self::$conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                ErrorManager::write_log($e->getMessage());
                throw $e;
            }
        }
    }

    public static function s_query1($query){
        try{
            self::$stmt = self::$conn2->query($query);
            $result = self::$stmt->fetchAll();
        }catch(PDOEXCEPTION $e){
            ErrorManager::write_log($e->getMessage());
            $result = null;
        }
        return $result;
    }

    public static function s_query2($query, $params){
        try{
            self::$stmt = self::$conn2->prepare($query);
            foreach($params as $column=>$value){
                self::$stmt->bindValue($column, $value);
            }
            self::$stmt->execute();
            $result = self::$stmt->fetchAll();
        }catch(PDOEXCEPTION $e){
            ErrorManager::write_log($e->getMessage());
            $result = null;
        }
        return $result;
    }
}
?>