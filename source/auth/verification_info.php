<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/declared.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth.class.php';

if (Auth::isLogin()) {
    if(isset($_SERVER["HTTP_REFERER"])) {
        header("Location:" . $_SERVER["HTTP_REFERER"]);
    } else {
        header("Location:" . getRootURL());
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.0/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.0/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap-grid.min.css" integrity="sha512-QTQigm89ZvHzwoJ/NgJPghQPegLIwnXuOXWEdAjjOvpE9uaBGeI05+auj0RjYVr86gtMaBJRKi8hWZVsrVe/Ug==" crossorigin="anonymous" />
    <link rel="stylesheet" href="/assets/css/index.css">
    <link rel="stylesheet" href="/assets/css/theme.css">
    <style>
        div[class^="col"] {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
    <header>
        <?php write_header(); ?>
    </header>
    <main>
        <div class="container-xl">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h4 style="display: inline;">
                        인증메일을 확인해주세요
                    </h4>
                </div>
            </div>
            <dlv class="row">
                    <div class="col-12">
                        <button type="button" class="btn btn-secondary" onclick="sendMail()">다시 전송</button>
                    </div>
            </dlv>
        </div>
    </main>
</body>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/js/bootstrap.min.js"></script>
<script>
    function sendMail() {
        var params = new URLSearchParams(window.location.search);;

        $.ajax({
            url: "/auth/send_mail.php?id=" + params.get('id') + "&email=" + params.get('email'),
            type: "get",
            async: false,
            success: function(result) {
                if (!alert('재전송완료')) {
                    history.back();
                }
            }
        });
    }
</script>

</html>