<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/session_handler.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/errors.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/declared.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

DB::connect();

if(isset($_SESSION["id"])) {
    $query = "UPDATE comment SET contents = :contents WHERE user_id = :user_id AND comment_id = :comment_id";
    $params = array(
        ":contents"     => $_POST["contents"],
        ":user_id"      => $_SESSION["id"],
        ":comment_id"   => $_POST["comment_id"]
    );
    DB::query2($query, $params);

    // 게시글 정보 가져옴
    $result = DB::query1('SELECT * FROM board WHERE board_id = ' . $_POST['board_id']);
    $data = array(
        'board_id'      => $_POST['board_id'],
        'comment_id'    => $_POST['comment_id'],
        'subject'       => $result[0]['subject'],
        'contents'      => $_POST['contents']
    );

    if($result[0]['user_id'] != $_SESSION['id']) {
        // notification 테이블에 insert
        $query = "INSERT INTO notification (user_id, data, reg_date) VALUES (:user_id, :data, NOW())";
        DB::query2($query, array(
            ':user_id'  => $result[0]['user_id'],
            ':data'     => json_encode($data)
        ));
    }

    echo '0';
    exit();
}
?>
