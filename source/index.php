<?php
require_once('contents_list.php');
require_once('declared.php');
require_once("errors.php");

if(isset($_GET["message"])){
    ErrorManager::requestAlert($_GET["message"]);
}
write_table();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/css/bootstrap.css">
    <link rel="stylesheet" href="style/index.css">
    <style>
        body{
            background-color:#FAFAFA;
        }
        .container {
            padding: 100px 0 100px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <?php write_header();?>
    </header>
    <main>
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-2">
                    <select id="amt_contents">
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="50">50</option>
                    </select>
                    <label> 개의 글 표시</label>
                </div>
                <div class="col-2" id="write">
                    <a href="./writing.php">글쓰기</a>
                </div>
                <div class="search">
                </div>
            </div>
            <div class="row" id="search">
                <div class="col-12">
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
            </div>
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="list">
                        <table id="listtb">
                            <tr>
                                <th style="width:70px;"><label>번호</label></th>
                                <th style="width:640px;"><label>제목</label></th>
                                <th style="width:100px;"><label>작성자</label></th>
                                <th style="width:70px;"><label>조회 수</label></th>
                                <th style="width:200px;"><label>날짜</label></th>
                            </tr>
                            <?php write_list();?>
                        </table>
                    </div>
                </div>
                <div class="col-8" id="index">
                    <?php write_index(); ?>
                </div>
            </div>
        </div>
    </div>
</main>
<footer></footer>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/index.js"></script>
</body>
</html> 