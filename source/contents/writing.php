<?php
require_once('../declared.php');
require_once("../auth.class.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_COOKIE["auto_login"])) {
    Auth::check_auto_login();
}
if (!isset($_SESSION["id"])) {
    header("Location:" . getRootURL() . "index.php?message=NO_AUTH");
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap-grid.min.css" integrity="sha512-QTQigm89ZvHzwoJ/NgJPghQPegLIwnXuOXWEdAjjOvpE9uaBGeI05+auj0RjYVr86gtMaBJRKi8hWZVsrVe/Ug==" crossorigin="anonymous" />
    <link href="../style/writing.css" rel="stylesheet" type="text/css">
    <link href="../style/theme.css" rel="stylesheet" type="text/css">
</head>

<body>
    <header>
        <?php write_header(); ?>
    </header>
    <main>
        <div class="container-xl">
            <div class="row justify-content-around">
                <div class="col-12">
                    <form action="insert_contents.php" method="post" enctype="multipart/form-data" id="submitForm">
                        <div class="form-row">
                            <div class="col-12">
                                <input class="form-control" type="text" id="subject" name="subject" required />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <div class="btn-toolbar justify-content-between form-group" id="styles" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group" role="group" aria-label="First group">
                                        <input type="button" class="BOLD btn btn-light" value="B" onclick="document.execCommand('bold')" />
                                        <input type="button" class="ITALIC btn btn-light" value="Italic" onclick="document.execCommand('Italic')" />
                                        <input type="button" class="UNDERBAR btn btn-light" value="abc" onclick="document.execCommand('Underline')" />
                                        <input type="button" class="BAR btn btn-light" value="abc" onclick="document.execCommand('StrikeThrough')" />
                                        <input type="button" class="aignLeft btn btn-light" value="왼쪽 정렬" onclick="document.execCommand('justifyleft')" />
                                        <input type="button" class="aignCenter btn btn-light" value="가운데 정렬" onclick="document.execCommand('justifycenter')" />
                                        <input type="button" class="aignRight btn btn-light" value="오른쪽 정렬" onclick="document.execCommand('justifyright')" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <textarea id="contents_submit" name="contents"></textarea>
                                <div class="form-control" contenteditable="true" id="contents" required></div>
                            </div>
                        </div>
                        <!--drop drag-->
                        <div class="form-row">
                            <div class="col-12">
                                <div class="file_upload" id="drop-area">
                                    <p><label for="files">Choose a file or drag it here.</label></p>
                                    <input type="file" id="files" name="files" multiple="multiple">
                                    <div id="message"><label></label></div>
                                    <span id="upload_cancel"><img id="upload_cancel" src="https://img.icons8.com/material/48/000000/cancel--v1.png" /></span>
                                    <div id="file_info">
                                        <table class="table">
                                            <thead>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-around" id="buttons">
                            <div class="col-3">
                                <input class="btn btn-dark" type="button" id="btn_submit" name="submit" value="Submit">
                            </div>
                            <div class="col-3">
                                <input class="btn btn-dark" type="button" value="Cancel" onclick="window.history.back();">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <footer></footer>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/writing.js"></script>
</body>

</html>