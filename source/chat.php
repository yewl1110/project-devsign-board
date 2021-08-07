<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/session_handler.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/declared.php';

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
    <link rel="stylesheet" href="assets/css/theme.css">
</head>

<body>
    <header>
        <?php write_header(); ?>
    </header>
    <div class="container-lg">
        <div class="iframe-wrapper" id="chatting-wrapper">
            <iframe src="" title="chatting" style="width:100%; height:calc(100vh - 56px); border:none;"></iframe>
        </div>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="/assets/js/index.js"></script>
    <script type="text/javascript" src="/assets/js/notification.js" async=""></script>
    <script type="text/javascript">
        $(document).ready(function() {
            document.title = "Devsign-board";

            var list = $('#header-menu').children();
            $(list[1]).addClass('active');

            // iframe GET METHOD로 SESSION ID 전달
            var wrapper = $('#chatting-wrapper').children()[0];
            var url = <?php echo '"' . getChatURL() . '?sessid=' . $_COOKIE['PHPSESSID'] . '"'; ?>;
            $(wrapper).attr('src', url);

            console.log($('#chatting-wrapper').outerHeight());
        });
    </script>
</body>

</html>