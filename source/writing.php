<?php 

?>

<!DOCTYPE html>
<html>
    <head></head>
    <body>
        <div class="contents">
            <form action="./contents_insert.php" method="POST" id="write">
                subject: <input type="text" name="subject" required/><br>
                contents: <textarea type="textarea" name="contents" required></textarea><br>
                id: <input type="text" name="user_id" required/><br>
                name: <input type="text" name="user_name"/><br>
                password: <input type="password" id="passwd" name="passwd" required/>
                confirm: <input type="password" id="confirm" name="confirm" required/><br>
                <p id="passwd_message"></p>
                <button type="button" id="submit">Submit</button>
                <button type="button" id="cancel">Cancel</button>
            </form>
        </div>

        <script type="text/javascript" src="a.js"></script>
    </body>
</html>