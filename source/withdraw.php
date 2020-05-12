<?php
require_once("declared.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(!isset($_SESSION["id"])){
    header("Location: index.php?message=NO_AUTH");
}
?>
<!DOCTYPE html>
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
        #side{
            height: 100vh;
        }
        #side ul{
            margin-top: 50px;
        }
        #side ul a{
            color:black;
        }
    </style>
</head>
<body>
    <header>
        <?php write_header();?>
    </header>
    
    <main>
        <div class="container-fluid">
            <div class="row">
                <nav class="col-2 d-none d-md-block bg-light sidebar" id="side">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <h5><a class="nav-link active" href="member_info.php">정보변경</a></h5>
                        </li>
                        <li class="nav-item">
                            <h5><a class="nav-link" href=".">회원탈퇴</a></h5>
                        </li>
                    </ul>
                </nav>
                <div class="col-6 offset-md-1 contents">
                    <div class="row justify-content-md-center" id="container-header">
                        <div class="col">
                            <h1>회원탈퇴</h1>
                        </div>
                    </div>
                    <div class="row justify-content-md-center">
                        <div class="col" id="form-box">
                            <form action="delete_member.php" method="post">
                                <div class="form-group">
                                    <label>비밀번호 입력</label>
                                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                                </div>
                                <input type="submit" class="btn btn-danger" value="회원탈퇴">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer></footer>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/js/bootstrap.min.js"></script>
</body>
</html>
