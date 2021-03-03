<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/declared.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/errors.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/auth.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/contents/contents_list.php";

if (isset($_COOKIE["auto_login"])) {
    Auth::check_auto_login();
}

if (isset($_GET["message"])) {
    ErrorManager::requestAlert($_GET["message"]);
}
write_table();
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.0/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap-grid.min.css" integrity="sha512-QTQigm89ZvHzwoJ/NgJPghQPegLIwnXuOXWEdAjjOvpE9uaBGeI05+auj0RjYVr86gtMaBJRKi8hWZVsrVe/Ug==" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="/assets/css/index.css">
    <link rel="stylesheet" href="/assets/css/theme.css">
</head>

<body>
    <header>
        <?php write_header(); ?>
    </header>
    <main>
        <div class="container-xl">
            <!-- 글 목록 -->
            <div class="row justify-content-center">
                <div class="col-12 list">
                    <table id="tb" class="display">
                        <thead>
                            <th style="width:8%;"><label>번호</label></th>
                            <th style=""><label>제목</label></th>
                            <th style="width:10%"><label>작성자</label></th>
                            <th style="width:8%"><label>조회수</label></th>
                            <th style="width:20%" id="date"><label>날짜</label></th>
                        </thead>
                    </table>
                    <!-- <?php //write_list(); ?> -->
                </div>
                <!--<div class="col-8" id="index">
                    <?php //write_index(); ?>
                </div>-->
            </div>
        </div>
    </main>
    <footer></footer>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="/assets/js/index.js"></script>
    <script type="text/javascript" src="/assets/js/notification.js" async=""></script>
    <script src="https://kit.fontawesome.com/8426c7d90d.js" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            document.title = "Devsign-board";

            var list = $('#header-menu').children();
            $(list[0]).addClass('active');
            $('#tb').on('draw.dt', function() {});
        });
    </script>
</body>

</html>