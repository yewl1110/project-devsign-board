<?php
require_once("errors.php");
$dsn = "mysql:host=localhost;port=3306;dbname=devsign_board;charset=utf8";

try{
    $db = new PDO($dsn, "pi", "980809");
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    ErrorManager::write_log($e->getMessage());
}

$stmt = null;

try{
    $query = "SELECT * FROM table_attach";
    $stmt = $db->query($query);
}catch(PDOException $e){
    ErrorManager::write_log($e->getMessage());
}

function writeTable($row){
    $url = "http://hotcat.ddns.net:40080/pi/project-devsign-board/source/download.php?download=". $row['file_name_save'];
    printf('<a href=%s>%s</a><br>', $url, $row['file_name_origin']);
}
?>

<!DOCTYPE html>
<html>
    <head></head>
    <body>
        <div>
            <table>
            <tr>
                <th style="width:70px;" onclick="getId()"><label>번호</label></th>
                <th style="width:350px;"><label>제목</label></th>
                <th style="width:100px;"><label>작성자</label></th>
            </tr>
            <?php
            if($stmt != null){
                while($row = $stmt->fetch()){
                    writeTable($row);
                }
            }
            ?>
            </table>
        </div>
        <script type="text/javascript">
        function getId(id){
            header("Location: http://hotcat.ddns.net:40080/pi/project-devsign-board/source/downldoad.php?download=".id);
        }
        </script>
    </body>
</html>