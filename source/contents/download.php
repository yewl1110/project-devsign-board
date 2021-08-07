<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/db.class.php";

if($_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_GET["download"])){
        //$filePath = $_SERVER['DOCUMENT_ROOT']."/pi/files/".$_GET["download"];
        DB::connect();
        $rows = DB::query2("SELECT file_name_origin, file_name_save FROM table_attach WHERE file_id = :file_id", array(":file_id" => $_GET["download"]));
        $fileName = $rows["0"]["file_name_origin"];
        $fileLocalName = $rows["0"]["file_name_save"];

        $filePath = "../../files/".$fileLocalName;
        $fileSize = filesize($filePath);
        $path_parts = pathinfo($filePath);
        //$fileName = $path_parts['basename'];
        $extension = $path_parts['extension'];
        
        // 파일 다운로드 위한 헤더 설정
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