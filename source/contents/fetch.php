<?php
require_once('../db.class.php');
require_once('../errors.php');

// datatables
// 게시글 목록 가져와 전송
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    DB::connect();

    $query = "SELECT * FROM board ";
    $condition = '';

    // 한 페이지에 보여줄 게시글 갯수
    if ($_POST["length"] != -1) {
        $limit = " LIMIT " . $_POST["length"] . " OFFSET " . $_POST["start"];
    }

    // 키워드 검색했을 때
    if ($_POST["keyword"] != '') {
        $condition = " WHERE";
        $subject = " subject LIKE '%" . $_POST["keyword"] . "%'";
        $contents = " contents LIKE '%" . $_POST["keyword"] . "%'";
        if ($_POST["mode"] == "1") {
            $condition = $condition . $subject . " OR" . $contents;
        } else if ($_POST["mode"] == "2") {
            $condition = $condition . $subject;
        } else {
            $condition = $condition . $contents;
        }
    }
    $query2 = $condition . " ORDER BY board_id DESC" . $limit;
    $rows = DB::query1($query . $query2);
    $data = array();

    // 표시할 글 목록 array에 넣기
    foreach ($rows as $row) {
        $sub_array = array();
        $sub_array[] = '<label>' . $row['board_id'] . '</label>';
        $sub_array[] = '<label>' . $row['subject'] . ' <a href="/contents/view.php?board_id=' . $row['board_id'] . '#comment-wrapper"><span class="comment-count">' . $row['comment_count'] . '</span></a></label>';
        $sub_array[] = '<label>' . $row['user_name'] . '</label>';
        $sub_array[] = '<label>' . $row['hits'] . '</label>';
        $sub_array[] = '<label>' . $row['reg_date'] . '</label>';
        $data[] = $sub_array;
    }

    // 전체 게시글 갯수
    function get_all_data($query)
    {
        $result = DB::query1($query);
        return strval($result[0]["count(*)"]);
    }

    /* 리턴되는 파라미터
    - draw
    요청하는 draw와 같은 의미입니다. count
    - recordsTotal
    필터링 전 전체 레코드 수
    - recordsFiltered
    필터링 후 전체 레코드 수
    - data
    테이블에 그릴 데이터 (array)
    */
    $output = array(
        "draw" => intval($_POST["draw"]),
        "recordsTotal" => get_all_data("select count(*) from board"),
        "recordsFiltered" => get_all_data("select count(*) from board " . $condition),
        "data" => $data
    );

    echo json_encode($output);
}
