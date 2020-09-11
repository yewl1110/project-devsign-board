<?php
require_once('../errors.php');
require_once('../declared.php');
require_once('../db.class.php');

function makeURI(){
    $defaultPath = getRootURL().'/index.php';
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
    $cur_page = $GLOBALS['cur_page'];
    $full_pages = $GLOBALS['full_pages'];
    
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
    if($cur_page < $full_pages && intval($cur_page / 10) <= intval($end_page / 10)){
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

function write_table(){
    DB::connect();
    $amt_contents = 20; //한 페이지에 표시할 게시글 수
    if(isset($_COOKIE["amt_contents"])){
        $amt_contents = $_COOKIE["amt_contents"];
    }
    
    $paging_query = "SELECT count(*) FROM board ";
    $rows = $GLOBALS["rows"] = DB::query1($paging_query);
    // 전체 게시글 수 가져옴 (페이징할거임)
    $GLOBALS['full_pages'] = ceil($rows['0']['count(*)'] / $amt_contents);
    $GLOBALS['cur_page'] = 1;
    
    $query = "SELECT * FROM board ";
    //페이징
    if(empty($_GET['page']) || $_GET['page'] == '1'){ //1페이지
        $paging = "ORDER BY board_id DESC LIMIT {$amt_contents}";
    }else{
        $GLOBALS['cur_page'] = $_GET['page'];
        if($GLOBALS['cur_page'] > $GLOBALS['full_pages']){
            $GLOBALS['cur_page'] = $GLOBALS['full_pages'];
        }
        
        $offset = ($GLOBALS['cur_page'] - 1) * $amt_contents;
        $paging = "ORDER BY board_id DESC LIMIT {$offset}, {$amt_contents}";
    }
    
    //검색 구현
    if(!empty($_GET['keyword'])){
        $params = array();
        
        if($_GET['search_mode'] == "1"){
            $condition = "WHERE subject LIKE :subject OR contents LIKE :contents ";
            $params[":subject"] = "%{$_GET['keyword']}%";
            $params[":contents"] = "%{$_GET['keyword']}%";
            
        } else if($_GET['search_mode'] == "2"){
            $condition = "WHERE subject LIKE :subject ";
            $params[":subject"] = "%{$_GET['keyword']}%";
        }else{
            $condition = "WHERE contents LIKE :contents ";
            $params[":contents"] = "%{$_GET['keyword']}%";
        }
        
        $rows = DB::query2($paging_query.$condition, $params);
        $GLOBALS['full_pages'] = ceil($rows['0']['count(*)'] / $amt_contents);
        
        $GLOBALS["rows"] = DB::query2($query.$condition.$paging, $params);
    }
    else{
        $query = $query.$paging;
        $GLOBALS["rows"] = DB::query1($query);
    }
}

function write_list(){
    if(isset($GLOBALS["rows"])){
        foreach($GLOBALS["rows"] as $row){
            printf('<tr onclick="getNum(%s)"><td><label>%s</label></td><td><label>%s</label></td><td><label>%s</label></td><td><label>%d</label></td><td><label>%s</label></td></tr>',$row['board_id'], $row['board_id'], $row['subject'], $row['user_name'], $row['hits'], $row['reg_date']);
        }
    }
}
?>
