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
<head></head>
<body>
<link href="./writing.css" rel="stylesheet" type="text/css">
<div class="main">
    <?php write_header();?>
    <div class="contents">
        <form action="contents_insert.php" method="post" onsubmit="return submitContents();" enctype="multipart/form-data">
            <input type="text" id="subject" name="subject" required/><br>
            <div class="styles">
                <input type="button" class="BOLD" value="B" onclick="document.execCommand('bold')" />
                <input type="button" class="ITALIC" value="Italic" onclick="document.execCommand('Italic')" />
                <input type="button" class="UNDERBAR" value="abc" onclick="document.execCommand('Underline')" />
                <input type="button" class="BAR" value="abc" onclick="document.execCommand('StrikeThrough')" />
                <input type="button" class="aignLeft" value="왼쪽 정렬" onclick="document.execCommand('justifyleft')" />
                <input type="button" class="aignCenter" value="가운데 정렬" onclick="document.execCommand('justifycenter')" />
                <input type="button" class="aignRight" value="오른쪽 정렬" onclick="document.execCommand('justifyright')" />
            </div>
            <textarea id="contents_submit" name="contents"></textarea>
            <div contenteditable="true" id="contents" required></div></br>
            <div class="file_upload">
                <input type="file" id="files" name="files[]" multiple="multiple">
            </div><br>
            <div class="buttons">
                <input type="submit" id="btn_submit" name="submit" value="Submit" disabled>
                <input type="button" value="Cancel" onclick="window.history.back();">
            </div>
        </form>
    </div>
</div>
    <script type="text/javascript" src="js/a.js"></script>
</body>
</html>