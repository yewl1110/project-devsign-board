
<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/session_handler.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/errors.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/declared.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

DB::connect();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["contents"]) && isset($_SESSION["id"])){
        $time = date("Y-m-d H:i:s");
        $query = "INSERT INTO comment (board_id, user_id, contents, reg_date) VALUES (:board_id, :user_id, :contents, :reg_date)";
        $params = array(
            ":board_id" => $_POST["board_id"],
            ":user_id" => $_SESSION["id"],
            ":contents" => $_POST["contents"],
            ":reg_date" => $time
        );
        DB::query2($query, $params);

        $last_id = DB::lastInsertId();

        $query = "UPDATE board SET comment_count = comment_count + 1 WHERE board_id = " . $_POST['board_id'];
        DB::query1($query);

        // 게시글 정보 가져옴
        $result = DB::query1('SELECT * FROM board WHERE board_id = ' . $_POST['board_id']);
        $data = array(
            'board_id'      => $_POST['board_id'],
            'comment_id'    => $last_id, 
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
    }
    $result = array(
        'comment_id' => $last_id,
        'user_id' => $_SESSION["id"],
        'reg_date' => $time,
        'edit' => 1
    );
    print_r(json_encode($result));
}
?>
