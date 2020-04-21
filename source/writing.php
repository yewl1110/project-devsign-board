<?php 
?>

<!DOCTYPE html>
<html>
    <head></head>
    <body>
    <link href="writing.css" rel="stylesheet" type="text/css">
        <div id="header_wrap" role="heading">
            <div class="header_group">
                <a href="http://hotcat.ddns.net:40080/pi">
                    <img src="resource/devsign.jpg" width="280"></a>
                <a class="home" href="http://hotcat.ddns.net:40080/pi">home</a>
            </div>
        </div>
        <div class="contents">
            <form action="./contents_insert.php" method="POST" onsubmit="return submitContents();">
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
                <div class="account"> <!-- 임시로쓰는거임 -->
                    id: <input type="text" name="user_id" required/>
                    name: <input type="text" name="user_name"/><br>
                    <div class="passwd">
                    password: <input type="password" id="passwd" name="passwd" required/>
                    confirm: <input type="password" id="confirm" name="confirm" required/><br>
                    </div>
                    <p id="passwd_message"></p>
                </div>
                <div class="buttons">
                    <button type="submit" id="btn_submit" disabled>Submit</button>
                    <button type="button" id="cancel">Cancel</button>
                </div>
            </form>
        </div>
        <script type="text/javascript" src="js/a.js"></script>
    </body>
</html>