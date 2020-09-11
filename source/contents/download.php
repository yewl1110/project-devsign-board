<?php
require_once("../db.class.php");

if($_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_GET["download"])){
        //$filePath = $_SERVER['DOCUMENT_ROOT']."/pi/files/".$_GET["download"];
        $filePath = "../../files/".$_GET["download"];
        $fileSize = filesize($filePath);
        $path_parts = pathinfo($filePath);
        $fileName = $path_parts['basename'];
        $extension = $path_parts['extension'];
        
        DB::connect();
        $rows = DB::query2("SELECT file_name_origin FROM table_attach WHERE file_name_save = :name", array(":name" => $fileName));
        $fileName = $rows["0"]["file_name_origin"];
        
        header("Pragma: public");
        header("Expires: 0");
        header("Content-Type: application/octet-stream");
        header('Content-Disposition: attachment; filename="'.$fileName.'"');
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: ".$fileSize);
        
        ob_clean();
        flush();
        readfile($filePath);
    }
    exit();
}

?>