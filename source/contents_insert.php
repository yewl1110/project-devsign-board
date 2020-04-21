<?php 
// 분리
$dsn = "mysql:host=localhost;port=3306;dbname=devsign_board;charset=utf8";

try{
    $db = new PDO($dsn, "pi", "980809");
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "연결 성공<br>";
}catch(PDOException $e){
    alert($e->getMessage());
}
// 테스트 데이터 삽입
/*
try{
    $query = "INSERT INTO `board` (`user_id`, `user_name`, `subject`, `contents`, `tmp_passwd`, `reg_date`) 
    VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    
    try{
        for($i = 1001; $i<=1100; $i++){
            $attr_values = array($i, $i, $i, $i, $i, date("Y-m-d H:i:s"));
            $stmt->execute($attr_values);
        }
    }catch(PDOException $e){
        alert($e->getMessage());
        exit();
    }
}catch(PDOException $e){
    alert($e->getMessage());
    exit();
}
*/
// db삽입부분
if(!empty($_POST['user_id'])){
    $name = $_POST['user_name'];
    if($name == null){
        $name = "DE";
    }
    $attr_values = array($_POST['user_id'], $_POST['user_name'], $_POST['subject'], htmlspecialchars($_POST['contents'], ENT_QUOTES), password_hash($_POST['passwd'], PASSWORD_DEFAULT), date("Y-m-d H:i:s"));
    /// 삭제할거
    foreach($attr_values as $v){
        echo $v.'<br>';
    }
    ///
    try{
        $query = "INSERT INTO `board` (`user_id`, `user_name`, `subject`, `contents`, `tmp_passwd`, `reg_date`) 
        VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        
        try{
            $stmt->execute($attr_values);
        }catch(PDOException $e){
            alert($e->getMessage());
            exit();
        }
    }catch(PDOException $e){
        alert($e->getMessage());
        exit();
    }
}


?>