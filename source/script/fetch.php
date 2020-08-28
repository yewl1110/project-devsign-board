<?php
require_once('../db.class.php');
require_once('../errors.php');

if($_SERVER["REQUEST_METHOD"] == "POST"){
    DB::connect();
    
    $query = "SELECT * FROM board ";
    $condition = '';
    
    if($_POST["length"] != -1){
        $limit = " LIMIT ".$_POST["length"]." OFFSET ".$_POST["start"];
    }
    if($_POST["keyword"] != ''){
        $condition = " WHERE";
        $subject = " subject LIKE '%".$_POST["keyword"]."%'";
        $contents = " contents LIKE '%".$_POST["keyword"]."%'";
        if($_POST["mode"] == "1"){
            $condition = $condition.$subject." OR".$contents;
        }else if($_POST["mode"] == "2"){
            $condition = $condition.$subject;
        }else{
            $condition = $condition.$contents;
        }
    }
    $query2 = $condition." ORDER BY board_id DESC".$limit;
    $rows = DB::query1($query.$query2);
    $number_row = strval(count($rows));
    $data = array();
    
    foreach($rows as $row){
        $sub_array = array();
        $sub_array[] = $row['board_id'];
        $sub_array[] = $row['subject'] . ' <a href="view.php?board_id=' . $row['board_id']. '#disqus_thread"></a>';
        $sub_array[] = $row['user_name'];
        $sub_array[] = $row['hits'];
        $sub_array[] = $row['reg_date'];
        $data[] = $sub_array;
    }
    
    function get_all_data($query){
        $result = DB::query1($query);
        return strval($result[0]["count(*)"]);
    }
    
    $output = array(
        "draw" => intval($_POST["draw"]),
        "recordsTotal" => get_all_data("select count(*) from board"),
        "recordsFiltered" => get_all_data("select count(*) from board ".$condition),
        "data" => $data
    );
    
    echo json_encode($output);
}
?>