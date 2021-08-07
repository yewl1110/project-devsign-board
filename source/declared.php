<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/session_handler.php';

function getRootURL()
{
    $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
    //return 'http://hotcat.ddns.net:40080/pi/project-devsign-board/source';
    return $root;
}

function getChatURL(){
    return (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://hotcat.ddns.net:10002/';
}

function write_header_manu()
{
    $home = getRootURL();
    if (isset($_SESSION["id"])) {
        echo '
        <li class="nav-item" id="">
            <div class="dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" id="notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="far fa-bell"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="notification">
                    <div class="noti-title">Notifications <a href="#">All clear</a></div>
                    <div class="noti-contents"></div>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="' . $home . 'member/member_info.php">마이페이지</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="' . $home . 'auth/logout.php">로그아웃</a>
        </li>';
    } else {
        echo '<li class="nav-item">
            <a class="nav-link" href="' . $home . 'auth/login.php">로그인</a>
        </li>';
    }
}

function write_notification() {
    if(isset($_SESSION['id'])) {
        return '
        <div class="dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" id="m-notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="far fa-bell"></i>
            </a>
            <div class="dropdown-menu" aria-labelledby="m-notification">
                <div class="noti-title">Notifications <a href="#">All clear</a></div>
                <div class="noti-contents"></div>
            </div>
        </div>';
    } else {
        return '';
    }
}

function write_header()
{
    $home = getRootURL();
    echo '
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand mb-0 h1" href="' . $home . '">Devsign-board</a>
    <div class="navbar" style="padding:0;">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">' . write_notification() . '</li>
        </ul>
    </div>
    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
    data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
    aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav mr-auto" id="header-menu">
    <li class="nav-item">
    <a class="nav-link" href="' . $home . 'index.php">Home<span class="sr-only">(current)</span></a>
    </li>
    <li class="nav-item">
    <a class="nav-link" href="' . $home . 'chat.php">Chatting<span class="sr-only">(current)</span></a>
    </li>
    </ul>
    <ul class="navbar-nav" id="login-menu">';
    write_header_manu();
    echo '</ul></div></nav>';
}

function write_sidebar_button()
{
    echo '
    <nav class="navbar d-lg-none navbar-light bg-transparent" id="sidebar_button">
        <button class="navbar-toggler d-lg-none collapsed" type="button"
            data-toggle="collapse" data-target="#side" aria-controls="side" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
    ';
}

function write_sidebar()
{
    echo '
    <nav class="col-lg-2 d-lg-block sidebar collapse" id="side">
        <ul class="nav flex-column" id="side-menu">
            <li class="nav-item">
                <a class="nav-link" href="' . getRootURL() . 'member/member_info.php">정보변경</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="' . getRootURL() . 'member/leave.php">회원탈퇴</a>
            </li>
        </ul>
    </nav>
    ';
}