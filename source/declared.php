<?php

function getRootURL(){
    $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
    //return 'http://hotcat.ddns.net:40080/pi/project-devsign-board/source';
    return $root;
}

function write_header_manu(){
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    $home = getRootURL();
    if(isset($_SESSION["id"])){
        $id = $_SESSION["id"];
        /*echo '<a href="'.$home.'/member_info.php">마이페이지</a> <a href="'.$home.'/logout.php">로그아웃</a><br>
        <label>'.$id.' 님 환영합니다</label>';*/ 
        echo '<li class="nav-item">
        <a class="nav-link" href="'.$home.'member/member_info.php">마이페이지</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="'.$home.'auth/logout.php">로그아웃</a>
        </li>';
    }else{
        //echo '<a href="'.$home.'/login.php">로그인</a>';
        echo '<li class="nav-item">
        <a class="nav-link" href="'.$home.'auth/login.php">로그인</a>
        </li>';
    }
}

function write_header(){
    $home = getRootURL();
    /*echo '<div id="header_wrap" role="heading">
    <div class="header_group">
    <a href="'.$home.'">
    <img src="resource/devsign.jpg" width="280"></a>
    <span id="header_menu">
    <a href="'.$home.'">home</a> '; 
    write_header_manu();
    echo '</span>
    </div>
    </div>';*/
    echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand mb-0 h1" href="'.$home.'">Devsign-board</a>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
    <li class="nav-item active">
    <a class="nav-link" href="'.$home.'index.php">Home <span class="sr-only">(current)</span></a>
    </li>
    </ul>
    </div>
    <ul class="navbar-nav">';
    write_header_manu();
    echo '</ul>
    </nav>';
}
?>