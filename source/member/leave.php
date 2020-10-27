<?php
require_once("../declared.php");
require_once("../auth.class.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_COOKIE["auto_login"])) {
    Auth::check_auto_login();
}
if (!isset($_SESSION["id"])) {
    header("Location: index.php?message=NO_AUTH");
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.0/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap-grid.min.css" integrity="sha512-QTQigm89ZvHzwoJ/NgJPghQPegLIwnXuOXWEdAjjOvpE9uaBGeI05+auj0RjYVr86gtMaBJRKi8hWZVsrVe/Ug==" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="../style/theme.css">
</head>

<body>
    <header>
        <!-- 상단 네비게이션 바 -->
        <?php write_header(); ?>
    </header>
    <div class="container-fluid">
        <div class="row">
            <!-- 사이드 네비게이션 바 -->
            <?php write_sidebar(); ?>
            <!-- 주 컨텐츠 표시 -->
            <main class="col-lg-10 col-12">
                <div class="row justify-content-md-center">
                    <div class="col-12 col-md-8 col-lg-6" id="form-box">
                        <form action="delete_member.php" method="post">
                            <div class="form-group">
                                <h2>회원탈퇴</h2>
                            </div>
                            <div class="form-group">
                                <label>비밀번호 입력</label>
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                            </div>
                            <input type="submit" class="btn btn-danger" value="회원탈퇴">
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <footer></footer>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        var list = $('#side ul').children();
        $(list[1]).addClass('active');
    </script>
</body>

</html>