<?php
require_once('errors.php');

function write_list($row){
    printf('<tr onclick="getNum(%s)"><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%d</td><td>%s</td></tr>',$row['board_id'], $row['board_id'], $row['user_id'], $row['user_name'], $row['subject'], $row['hits'], $row['reg_date']);
}

function makeURI(){
    $defaultPath = 'http://hotcat.ddns.net:40080/pi/project-devsign-board/source/'.'index.php';
    $value = array();
    if(!empty($_GET['keyword'])){
        $value['keyword'] = $_GET['keyword'];
    }
    if(!empty($_GET['search_mode'])){
        $value['search_mode'] = $_GET['search_mode'];
    }
    if(!empty($_GET['page'])){
        $value['page'] = $_GET['page'];
    }
    return $defaultPath.'?'.http_build_query($value);
}

function write_index(){
    $cur_page = $_GET['cur_page'];
    $full_pages = $_GET['full_pages'];

    if($cur_page % 10 == 0){
        $start_page = $cur_page - 9;
        $end_page = $cur_page;
    }else{
        $start_page = intval($cur_page / 10) * 10 + 1;
        $end_page = (intval($cur_page / 10) + 1) * 10;    
    }
    if($end_page > $full_pages)
        $end_page = $full_pages;
        
    echo '<table id="pages"><tr>';
    if($start_page > 10){
        if($cur_page % 10 == 1){
            $des_page = $cur_page - 10;
        }else{
            $des_page = intval($cur_page / 10) * 10 + 1;
            if($cur_page % 10 == 0)
                $des_page -= 10;
        }
        $_GET['page'] = $des_page;
        echo '<tr><a href="'.makeURI().'"/>◀◀ </a></tr>';
    }
    if($cur_page > 1){
        $_GET['page'] = $cur_page - 1;
        echo '<tr><a href="'.makeURI().'"/>◀ </a></tr>';
    }
    for($i = $start_page; $i <= $end_page; $i++){
        $_GET['page'] = $i;
        if($i == $cur_page){
            echo '<tr><b><a href="'.makeURI().'">'.$i.' </a></b></tr> ';
        }else{
            echo '<tr><a href="'.makeURI().'">'.$i.' </a></tr> ';
        }
    }
    if($cur_page < $full_pages){
        $_GET['page'] = $cur_page + 1;
        echo '<tr><a href="'.makeURI().'">▶ </a></tr>';
    }
    if($cur_page != $full_pages && intval($cur_page / 10) <= intval($end_page / 10)){
        if(intval($cur_page / 10) == intval($end_page / 10)){
            $des_page = $end_page;
            if($des_page != $full_pages)
                $des_page += 10;
        }
        else{
            $des_page = (intval($cur_page / 10) + 1) * 10 + 1;
        }
        $_GET['page'] = $des_page;
        echo '<tr><a href="'.makeURI().'">▶▶</a></tr>';
    }
    echo '</tr></table>';
}

?>
