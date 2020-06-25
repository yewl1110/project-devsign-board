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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.0/css/bootstrap.css">
    <!--<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/css/dataTables.bootstrap.css">-->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="style/index.css">
    <style>
        body {
            background-color: #FAFAFA;
        }

        .container {
            padding: 100px 0 100px 0;
            text-align: center;
        }

        table.dataTable.hover tbody tr:hover,
        table.dataTable.display tbody tr:hover {
            background-color: #f6f6f6;
        }
    </style>
</head>

<body>
    <header>
        <?php write_header();?>
    </header>
    <main>
        <div class="container">
            <div class="row col-12">
                <!--<div class="col-3">
                    <select id="amt_contents">
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="50">50</option>
                    </select>
                    <label> 개의 글 표시</label>
                </div>-->
                <div class="col-2 offset-md-10" id="write">
                    <a href="./writing.php">글쓰기</a>
                </div>
            </div>
            <div class="row" id="search">
                <div class="row col-12">
                    <div class="col-2">
                        <select class="custom-select" id="search_mode">
                            <option value="1">제목+내용</option>
                            <option value="2">제목</option>
                            <option value="3">내용</option>
                        </select>
                    </div>
                    <div class="col-9">
                        <input class="form-control" id="keyword"></input>
                    </div>
                    <div class="col-1">
                        <button class="btn btn-secondary" id="btn_search">search</button>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="list">
                        <table id="tb" class="display">
                            <thead>
                                <tr>
                                    <th style="width:70px;"><label>번호</label></th>
                                    <th style="width:640px;"><label>제목</label></th>
                                    <th style="width:100px;"><label>작성자</label></th>
                                    <th style="width:70px;"><label>조회 수</label></th>
                                    <th style="width:200px;"><label>날짜</label></th>
                                </tr>
                            </thead>
                            <!--<?php write_list();?>-->
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
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.0/js/bootstrap.min.js"></script>
    <!--<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/js/dataTables.bootstrap.js"></script>-->
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/index.js"></script>
</body>
</html>