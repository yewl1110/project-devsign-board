<?php
require_once('contents_list.php');
require_once('db.class.php');
require_once('declared.php');
require_once("errors.php");

if(isset($_GET["message"])){
    ErrorManager::requestAlert($_GET["message"]);
}

DB::connect();
$amt_contents = 20; //한 페이지에 표시할 게시글 수
if(isset($_COOKIE["amt_contents"])){
    $amt_contents = $_COOKIE["amt_contents"];
}

try{
    $paging_query = "SELECT count(*) FROM board ";
    $rows = DB::query1($paging_query);
    // 전체 게시글 수 가져옴 (페이징할거임)
    $_GET['full_pages'] = ceil($rows['0']['count(*)'] / $amt_contents);
    $_GET['cur_page'] = 1;
    
    $query = "SELECT * FROM board ";
    //페이징
    if(empty($_GET['page']) || $_GET['page'] == '1'){ //1페이지
        $paging = "ORDER BY board_id DESC LIMIT {$amt_contents}";
    }else{
        $_GET['cur_page'] = $_GET['page'];
        if($_GET['cur_page'] > $_GET['full_pages']){
            $_GET['cur_page'] = $_GET['full_pages'];
        }
        $offset = ($_GET['cur_page'] - 1) * $amt_contents;
        $paging = "ORDER BY board_id DESC LIMIT {$offset}, {$amt_contents}";
    }

    //검색 구현
    if(!empty($_GET['keyword'])){
        $params = array();

        if($_GET['search_mode'] == "1"){
            $condition = "WHERE subject LIKE :subject OR contents LIKE :contents ";
            $params[":subject"] = "%{$_GET['keyword']}%";
            $params[":contents"] = "%{$_GET['keyword']}%";
            
        } else if($_GET['search_mode'] == "2"){
            $condition = "WHERE subject LIKE :subject ";
            $params[":subject"] = "%{$_GET['keyword']}%";
        }else{
            $condition = "WHERE contents LIKE :contents ";
            $params[":contents"] = "%{$_GET['keyword']}%";
        }
        
        $row = DB::query2($query.$condition, $params);
        $_GET['full_pages'] = ceil($row['0']['count(*)'] / $amt_contents);

        $rows = DB::query2($query.$condition.$paging, $params);
    }
    else{
        $query = $query.$paging;
        $rows = DB::query1($query);
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
        <?php write_header();?>
        <div class="contents">
            <span class="amt_contents">
                <select id="amt_contents">
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                </select>
                <label> 개의 글 표시</label>
            </span>
            <span class="write"><a href="./writing.php">글쓰기</a></span>
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
                    if($rows != null){
                        foreach($rows as $row){
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
    <script type="text/javascript" src="js/index.js"></script>
</body>
</html> 