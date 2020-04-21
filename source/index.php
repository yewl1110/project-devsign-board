<?php
require 'App.php';

$logPath = $_SERVER['DOCUMENT_ROOT'].'/pi/log/error_log.txt';
$defaultPath = 'http://hotcat.ddns.net:40080/pi/project-devsign-board/source/'.basename($_SERVER['SCRIPT_FILENAME']);

$dsn = "mysql:host=localhost;port=3306;dbname=devsign_board;charset=utf8";

try{
    $db = new PDO($dsn, "pi", "980809");
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    error_log($e->getMessage(), 3, $logPath);
}

$stmt = null;

// 전체 게시글 수 가져옴 (페이징할거임)
try{
    $stmt = $db->query("SELECT count(*) FROM board");
    $row = $stmt->fetch();
    $full_pages = $row['count(*)'];
    $cur_page = 1;

    if(empty($_GET['page']) || $_GET['page'] == '1'){ //1페이지
        $stmt = $db->query("SELECT * FROM board ORDER BY board_id DESC LIMIT 10");
    }else{
        // 페이지에 맞는 자료들 찾을 수 있는 쿼리 추가해야함
        $cur_page = $_GET['page'];
        $offset = ($cur_page - 1) * 10;
        $query = "SELECT * FROM board ORDER BY board_id DESC LIMIT ".$offset.",10";
        $stmt = $db->query($query);
    }
}
catch(PDOException $e){
    error_log($e->getMessage(), 3, $logPath);
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
            <?php
                if($cur_page % 10 == 0){
                    $start_page = $cur_page - 9;
                    $end_page = $cur_page;
                }else{
                    $start_page = intval($cur_page / 10) * 10 + 1;
                    $end_page = (intval($cur_page / 10) + 1) * 10;    
                }
                if($end_page > $full_pages)
                    $end_page = $full_pages;
                    
                echo '<table id="pages"><tr>';
                if($start_page > 10){
                    if($cur_page % 10 == 1){
                        $des_page = $cur_page - 10;
                    }else{
                        $des_page = intval($cur_page / 10) * 10 + 1;
                        if($cur_page % 10 == 0)
                            $des_page -= 10;
                    }
                    echo '<tr><a href="'.$defaultPath.'?page='.$des_page.'"/>◀◀ </a></tr>';
                }
                if($cur_page > 1){
                    echo '<tr><a href="'.$defaultPath.'?page='.($cur_page-1).'">◀ </a></tr>';
                }
                for($i = $start_page; $i <= $end_page; $i++){
                    if($i == $cur_page){
                        echo '<tr><b><a href="'.$defaultPath.'?page='.$i.'">'.$i.' </a></b></tr> ';
                    }else{
                        echo '<tr><a href="'.$defaultPath.'?page='.$i.'">'.$i.' </a></tr> ';
                    }
                }
                if($cur_page < $full_pages){
                    echo '<tr><a href="'.$defaultPath.'?page='.($cur_page+1).'">▶ </a></tr>';
                }
                if($cur_page != $full_pages && intval($cur_page / 10) <= intval($end_page / 10)){
                    if(intval($cur_page / 10) == intval($end_page / 10)){
                        $des_page = $end_page;
                        if($des_page != $full_pages)
                            $des_page += 10;
                    }
                    else{
                        $des_page = (intval($cur_page / 10) + 1) * 10 + 1;
                    }
                    echo '<tr><a href="'.$defaultPath.'?page='.$des_page.'">▶▶</a></tr>';
                }
                echo '</tr></table>';
            ?>
            </div>
        </div>
        <script type="text/javascript">
        </script>
    </body>
</html>