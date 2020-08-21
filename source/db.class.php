<?php 
require_once('errors.php');

class DB{
    private static $conn;
    private static $stmt;
    private static $id;
    private static $passwd;
    private static $dsn;

    public static function connect(){
        if(!self::$conn){
            self::$id = "pi";
            self::$passwd = "980809";
            self::$dsn = "mysql:host=localhost;port=3306;dbname=devsign_board;charset=utf8";
            try{
                self::$conn = new PDO(self::$dsn, self::$id, self::$passwd);
                self::$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                ErrorManager::write_log($e->getMessage());
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
        return "../../files/";
    }
}
?>