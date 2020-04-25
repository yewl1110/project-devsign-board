<?php
require_once('contents_list.php');
$dsn = "mysql:host=localhost;port=3306;dbname=devsign_board;charset=utf8";

try{
    $db = new PDO($dsn, "pi", "980809");
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    write_log($e->getMessage());
}

$stmt = null;
$amt_contents = 20;

try{
    $paging_query = "SELECT count(*) FROM board ";
    $stmt = $db->query($paging_query);
    $row = $stmt->fetch();
    $_GET['full_pages'] = ceil($row['count(*)'] / $amt_contents);
    $_GET['cur_page'] = 1;
    // 전체 게시글 수 가져옴 (페이징할거임)
    
    $query = "SELECT * FROM board ";
    //페이징
    if(empty($_GET['page']) || $_GET['page'] == '1'){ //1페이지
        $paging = "ORDER BY board_id DESC LIMIT ".$amt_contents;
    }else{
        //$cur_page = $_GET['page'];
        $_GET['cur_page'] = $_GET['page'];
        $offset = ($_GET['cur_page'] - 1) * $amt_contents;
        $paging = "ORDER BY board_id DESC LIMIT ".$offset.",".$amt_contents;
    }

    //검색 구현
    if(!empty($_GET['keyword'])){
        $params = array();
        array_push($params, "%".$_GET['keyword']."%");

        if($_GET['search_mode'] == "1"){
            $condition = "WHERE subject LIKE ? ";
        } else if($_GET['search_mode'] == "2"){
            $condition = "WHERE contents LIKE ? ";
        }else{
            $condition = "WHERE subject LIKE ? OR contents LIKE ? ";
            array_push($params, "%".$_GET['keyword']."%");
        }

        $paging_query = "SELECT count(*) FROM board ".$condition;
        $stmt = $db->prepare($paging_query);
        $stmt->execute($params);
        $row = $stmt->fetch();
        $_GET['full_pages'] = ceil($row['count(*)'] / $amt_contents);

        $query = $query.$condition.$paging;
        $stmt = $db->prepare($query);
        $stmt->execute($params);
    }
    else{
        $query = $query.$paging;
        $stmt = $db->query($query);
    }
}
catch(PDOException $e){
    write_log($e->getMessage());
}
?>

<!DOCTYPE html>
<html>
    <head></head>
    <body>
    <link href="index.css" rel="stylesheet" type="text/css">
        <div class="main">
            <div id="header_wrap" role="heading">
                <div class="header_group">
                    <a href="http://hotcat.ddns.net:40080/">
                        <img src="resource/devsign.jpg" width="280"></a>
                    <a class="home" href="http://hotcat.ddns.net:40080/">home</a>
                </div>
            </div>
            <div class="contents"> 
                <div class="write"><a href="./writing.php">글쓰기</a></div>
                <div class="search">
                    <form action="." method="GET">
                        <select name="search_mode">
                            <option value="1">제목+내용</option>
                            <option value="2">제목</option>
                            <option value="3">내용</option>
                        </select>
                        <input name="keyword"></input>
                        <button type="submit">search</button>
                    </form>
                </div>
                <div class="contents-body">
                    <div class="list">
                        <table id="listtb">
                            <tr>
                                <th style="width:70px;"><label>번호</label></th>
                                <th style="width:350px;"><label>제목</label></th>
                                <th style="width:100px;"><label>작성자</label></th>
                                <th style="width:70px;"><label>조회 수</label></th>
                                <th style="width:200px;"><label>날짜</label></th>
                            </tr>
                        <?php
                        if($stmt != null){
                            while($row = $stmt->fetch()){
                                write_list($row);
                            }
                        }
                        ?>
                        </table>
                    </div>
                    <div class="index">
                    <?php
                        write_index();
                    ?>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            function getNum(value){
                alert(value);
            }
        </script>
    </body>
</html> 