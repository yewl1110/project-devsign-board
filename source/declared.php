<?php

function getRootURL(){
    return 'http://hotcat.ddns.net:40080/pi/project-devsign-board/source';
}

function write_header_manu(){
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $home = getRootURL();
    if(isset($_SESSION["id"])){
        echo '<a href="'.$home.'/logout.php">로그아웃</a>';
    }else{
        echo '<a href="'.$home.'/login.php">로그인</a>';
    }
    echo `<a href="{$home}">home</a>`;
}

function write_header(){
    echo '<div id="header_wrap" role="heading">
            <div class="header_group">
                <a href="http://hotcat.ddns.net:40080/">
                    <img src="resource/devsign.jpg" width="280"></a>
                <span id="header_menu">
                    <a href="http://hotcat.ddns.net:40080/">home</a> ';
    write_header_manu();
    echo '</span>
            </div>
        </div>';
}

?>