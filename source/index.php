<?php
$dsn = "mysql:host=localhost;port=3306;dbname=devsign_board;charset=utf8";

try{
    $db = new PDO($dsn, "pi", "980809");
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "연결 성공<br>";
}catch(PDOException $e){
    assert($e->getMessage());
    echo $e->getMessage();
}
$stmt = null;
if(empty($_GET['page'])){ //1페이지
    $stmt = $db->query("SELECT * FROM board ORDER BY board_id DESC LIMIT 10");
}
//GET으로 page 번호 받아서 컨텐츠 표시하는 코드 추가해야함

?>

<!DOCTYPE html>
<html>
    <head></head>
    <body>
    <!--<link href="writing.css" rel="stylesheet" type="text/css">-->
        <div id="header_wrap" role="heading">
            <div class="header_group">
                <a href="http://hotcat.ddns.net:40080/">
                    <img src="resource/devsign.jpg" width="280"></a>
                <a class="home" href="http://hotcat.ddns.net:40080/">home</a>
            </div>
        </div>
        <a href="./writing.php">글쓰기</a>
        <div class="contents">
            <div class="list">
                <?php
                if($stmt != null){
                    while($row = $stmt->fetch()){
                        printf("<p> %s %s %s %s %d %s</p><br>", $row['board_id'], $row['user_id'], $row['user_name'], $row['subject'], $row['hits'], $row['reg_date']);
                    }
                }
                ?>
            </div>
            <div class="index">
                <button id=""></button>
                <button></button>
                <button></button>
                <button></button>
            </div>
        </div>
        <script type="text/javascript" src="js/a.js"></script>
    </body>
</html>