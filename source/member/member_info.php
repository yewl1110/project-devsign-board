<?php
require_once("../declared.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["id"])) {
    header("Location: index.php?message=NO_AUTH");
}
?>
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
        <!-- 사이드 네비게이션 바 버튼 -->
        <?php write_sidebar_button(); ?>
    </header>
    <div class="container-fluid">
        <div class="row">
            <!-- 사이드 네비게이션 바 -->
            <?php write_sidebar(); ?>
            <!-- 주 컨텐츠 표시 -->
            <main class="col-lg-10 col-12">
                <div class="row justify-content-md-center">
                    <div class="col-12 col-md-8 col-lg-6" id="form-box">
                        <form action="update_member.php" id="account" method="post" name="account">
                            <div class="form-group">
                                <h2>정보변경</h2>
                            </div>
                            <div class="form-group">
                                <label>ID</label>
                                <input type="text" class="form-control" id="id" name="id" readonly>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" id="email" readonly>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12 col-md-6">
                                    <label>New Password</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password">
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label>Confirm</label>
                                    <input type="password" class="form-control" id="confirm" placeholder="Re enter the new password.">
                                </div>
                            </div>
                            <div class="alert alert-danger col-12" id="message_passwd" role="alert">
                            </div>
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                            <div class="form-group">
                                <label>Nickname</label>
                                <input type="text" class="form-control" id="nickname" name="nickname">
                            </div>
                            <input type="submit" class="btn btn-primary" value="Edit">
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <footer></footer>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/member_info.js"></script>
    <script type="text/javascript">
        var id = '<?php echo $_SESSION["id"]; ?>';
        var email = '<?php echo $_SESSION["email"]; ?>';
        var name = '<?php echo $_SESSION["name"]; ?>';
        var nickname = '<?php echo $_SESSION["nickname"]; ?>';
        $("#id").val(id);
        $("#email").val(email);
        $("#name").val(name);
        $("#nickname").val(nickname);
        
        var list = $('#side-menu').children();
        $(list[0]).addClass('active');

        $('#sidebar_button button').click(function() {
            // 메뉴 접혀있을 때
            if ($('#sidebar_button button').hasClass('collapsed')) {
                // 메뉴 펼쳐질 때
                $('#sidebar_button').addClass('sidebar-m').addClass('navbar-dark').removeClass('navbar-light');
            } else {
                // 색 제거
                $('#sidebar_button').removeClass('sidebar-m').removeClass('navbar-dark').addClass('navbar-light');
            }
        });
    </script>
</body>

</html>