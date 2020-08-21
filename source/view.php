<?php 
require_once("declared.php");
require_once("db.class.php");
require_once("auth.class.php");


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_COOKIE["auto_login"])){
    Auth::check_auto_login();
}

$id = null;
if(isset($_SESSION["id"])){
    $id = $_SESSION["id"];
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/css/bootstrap.css">
    <link rel="stylesheet" href="style/post.css">
    <style>
        body{
            background-color:#FAFAFA;
        }
        .container {
            padding: 100px 0 100px 0;
        }
    </style>
</head>
<body>
    <header>
        <?php write_header();?>
    </header>
    <main>
        <div class="container">
            <div class="row justify-content-start">
                <div class="col-12">
                    <div class="row post">
                        <div class="post-title col-12">
                            <h4 id="subject"></h4>
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
                        <div class="other col-12"></div>
                        <div class="other col-12"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer></footer>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/view.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var id = '<?php echo $id;?>';
            if(id == '' || id != $("#user_id").text()){
                $("#edit").remove();
            }
        });
    </script>
</body>
</html>