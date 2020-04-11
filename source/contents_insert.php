<?php 
// db연결부분 나중에 분리
/*$servername = "localhost";
$username = "pi";
$password = "980809";

$conn = new mysqli($servername, $username, $password);

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
*/
$dsn = "mysql:host=localhost;port=3306;dbname=devsign_board;charset=utf8";

try{
    $db = new PDO($dsn, "pi", "980809");
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "연결 성공<br>";
}catch(PDOException $e){
    assert($e->getMessage());
    echo $e->getMessage();
}
// db삽입부분
if(!empty($_POST['user_id'])){
    /*$sql = "Insert into board ( user_id, subject, contents, tmp_passwd, user_name) values ";
    $sql += "(`".$_POST['user_id'].trim()."`, `".$_POST['subject'].trim()."`, `".$_POST['contents'];
    $sql += "`, `".$_POST['tmp_passwd'].trim()."`";
    if($_POST['user_name']){
        $sql += ",`".$_POST['user_name']."`";
    }
    $sql += ");";
    echo $sql."<br>";*/
    //$attr_names = array("user_id", "user_name", "subject", "contents", "tmp_passwd");
    $name = $_POST['user_name'];
    if($name == null){
        $name = "DE";
    }
    $attr_values = array($_POST['user_id'], $_POST['user_name'], $_POST['subject'], $_POST['contents'], $_POST['passwd'], date("Y-m-d H:i:s"));
    foreach($attr_values as $v){
        echo $v.'<br>';
    }
    try{
        $query = "INSERT INTO `board` (`user_id`, `user_name`, `subject`, `contents`, `tmp_passwd`, `reg_date`) VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $db->prepare($query); //?
        
        try{
            $stmt->execute($attr_values);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}
?>