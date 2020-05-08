<?php 
require_once("declared.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/css/bootstrap.css">
    <style>
        .contents{ 
            margin-top: 100px;
        }
        #container-header{
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <header>
        <?php write_header();?>
    </header>
    <main class="flex-shrink-0">
        <div class="container">
            <div class="contents">
                <div class="row justify-content-md-center" id="container-header">
                    <div class="col-8">
                        <h1>마이페이지</h1>
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-8" id="form-box">
                        <form action="update_member.php" id="account" method="post" name="account">
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
                                <div class="form-group col-6">
                                    <label>New Password</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password">
                                </div>
                                <div class="form-group col-6">
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
                            <!--<button type="submit" class="btn btn-primary">Edit</button>-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer></footer>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/member_info.js"></script>
    <script type="text/javascript">
        var id = '<?php echo $_SESSION["id"];?>';
        var email = '<?php echo $_SESSION["email"];?>';
        var name = '<?php echo $_SESSION["name"];?>';
        var nickname = '<?php echo $_SESSION["nickname"];?>';
        $("#id").val(id);
        $("#email").val(email);
        $("#name").val(name);
        $("#nickname").val(nickname);
    </script>
</body>
</html>
