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
    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
    data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
    aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav mr-auto">
    <li class="nav-item active">
    <a class="nav-link" href="'.$home.'index.php">Home <span class="sr-only">(current)</span></a>
    </li>
    </ul>
    <ul class="navbar-nav" id="small-menu">';
    write_header_manu();
    echo '</ul></div></nav>';
}

function write_sidebar_button(){
    echo '
    <nav class="navbar d-lg-none navbar-light bg-transparent" id="sidebar_button">
        <button class="navbar-toggler d-lg-none collapsed" type="button"
            data-toggle="collapse" data-target="#side" aria-controls="side" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
    ';
}

function write_sidebar(){
    echo '
    <nav class="col-lg-2 d-lg-block sidebar collapse" id="side">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="member_info.php">정보변경</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="leave.php">회원탈퇴</a>
            </li>
        </ul>
    </nav>
    ';
}
