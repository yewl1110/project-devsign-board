<?php
if($_SERVER["REQUEST_METHOD"] == "GET"){
    $filePath = $_SERVER['DOCUMENT_ROOT']."/pi/files/".$_GET["download"];
    $fileSize = filesize($filePath);
    $path_parts = pathinfo($filePath);
    $fileName = $path_parts['basename'];
    $extension = $path_parts['extension'];

    header("Pragma: public");
    header("Expires: 0");
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=$fileName"); // 원래 이름으로 바꾸는 코드 
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: $fileSize");

    ob_clean();
    flush();
    readfile($filePath);

    exit();
}

?>