<?php 
require_once('declared.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!isset($_SESSION["id"])){
    header("Location:".getRootURL()."/index.php?message=NO_AUTH");
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/css/bootstrap.css">
    <link href="style/writing.css" rel="stylesheet" type="text/css">
    <style>
        body{
            background-color:#FAFAFA;
        }
        .container {
            padding: 50px 0 50px 0;
        }
    </style>
</head>
<body>
    <header>
        <?php write_header();?>
    </header>
    <main>
        <div class="container">
            <div class="row justify-content-around">
                <div class="col-8">
                    <form action="insert_contents.php" method="post" onsubmit="return submitContents();" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="col-12">
                                <input class="form-control" type="text" id="subject" name="subject" required/>
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
                        <!--drop drag 예제-->
                        <div class="form-row">
                            <div class="col-12">
                                <div class="file_upload" id="drop-area">
                                    <input type="file" id="files" name="files[]" multiple="multiple">
                                    <p><label for="files">Choose a file or drag it here.</label></p>
                                    <p><label></label></p>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-around" id="buttons">
                            <div class="col-3">
                                <input class="btn btn-dark" type="submit" id="btn_submit" name="submit" value="Submit">
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
    <script type="text/javascript" src="js/writing.js"></script>
</body>
</html>