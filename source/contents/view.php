<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/declared.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/db.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/auth.class.php";


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_COOKIE["auto_login"])) {
    Auth::check_auto_login();
}

$id = null;
if (isset($_SESSION["id"])) {
    $id = $_SESSION["id"];
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap-grid.min.css" integrity="sha512-QTQigm89ZvHzwoJ/NgJPghQPegLIwnXuOXWEdAjjOvpE9uaBGeI05+auj0RjYVr86gtMaBJRKi8hWZVsrVe/Ug==" crossorigin="anonymous" />
    <base href="..">
    <link rel="stylesheet" href="/assets/css/post.css">
    <link rel="stylesheet" href="/assets/css/theme.css">
</head>

<body>
    <header>
        <?php write_header(); ?>
    </header>
    <main>
        <div class="container-lg view">
            <div class="row justify-content-start post-wrapper">
                <div class="col-12">
                    <div class="row post">
                        <div class="post-title col-12">
                            <div id="subject"></div>
                        </div>
                        <div class="post-meta col-12">
                            <span id="user_id"></span>
                        </div>
                        <div class="post-contents col-12" contenteditable="false">
                            <pre></pre>
                        </div>
                        <div class="files border col-12">
                            <label>첨부파일</label>
                        </div>
                        <div class="btn-group btn-group-sm col-2 offset-md-10" role="group" id="edit">
                            <button class="btn btn-secondary" id="btn_edit">수정</button>
                            <button class="btn btn-secondary" id="btn_remove">삭제</button>
                        </div>
                        <!-- <div class="other col-12"></div>
                        <div class="other col-12"></div> -->
                    </div>
                </div>
                <!-- <div class="col-12" id="disqus_thread"></div> -->
                <div class="comment-wrapper">
                    <div class="col-12">
                        <h4>댓글</h4>
                    </div>
                    <form id="submit-form" onsubmit="return false;" style="width: 100%">
                        <div class="input-group col-12" id="comment-form">
                            <input style="display:none;" id="board_id" name="board_id" />
                            <textarea class="form-control" style="resize: none;" aria-label="With textarea" name="contents"></textarea>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary"  type="submit">Send</button>
                            </div>
                        </div>
                    </form>
                    <div class="col-12" id="comments"></div>
                    <div class="col-12">
                        <button class="btn btn-outline-secondary btn-block" id="comment-btn" type="submit">Load More</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer></footer>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/8426c7d90d.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/assets/js/view.js"></script>
    <script type="text/javascript" src="/assets/js/notification.js" async=""></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var list = $('#header-menu').children();
            $(list[0]).addClass('active');
            var params = new URLSearchParams(window.location.search);

            var id = '<?php echo $id; ?>';
            if (id == '' || id != $("#user_id").text()) {
                $("#edit").remove();
            }
            document.title = $('#subject').html();
            $('#board_id').val(params.get("board_id"));

            $('textarea').on('change input', function () {
                this.style.height = "";
                this.style.height = this.scrollHeight + "px";
            });
            $('textarea').change();
        });
    </script>
</body>

</html>