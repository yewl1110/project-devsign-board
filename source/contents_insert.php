<?php 
require_once('./errors.php');
// 분리
$dsn = "mysql:host=localhost;port=3306;dbname=devsign_board;charset=utf8";

try{
    $db = new PDO($dsn, "pi", "980809");
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "연결 성공<br>";
}catch(PDOException $e){
    write_log($e->getMessage());
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
        write_log($e->getMessage());
        exit();
    }
}catch(PDOException $e){
    write_log($e->getMessage());
    exit();
}
*/
// db삽입부분
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["submit"])){
        $name = $_POST['user_name'];
        $id = null;
        $attr_values = array($_POST['user_id'], $_POST['user_name'], $_POST['subject'], htmlspecialchars($_POST['contents'], ENT_QUOTES), password_hash($_POST['passwd'], PASSWORD_DEFAULT), date("Y-m-d H:i:s"));
    
        try{
            $query = "INSERT INTO `board` (`user_id`, `user_name`, `subject`, `contents`, `tmp_passwd`, `reg_date`) 
            VALUES (?, COALESCE(DEFAULT(user_name), ?), ?, ?, ?, ?)";
            $stmt = $db->prepare($query);
            try{
                $stmt->execute($attr_values);
                // 마지막으로 INSERT 한 PK 값
                $id = $db->lastInsertId();
                write_log($id);
            }catch(PDOException $e){
                write_log($e->getMessage());
                exit();
            }
        }catch(PDOException $e){
            write_log($e->getMessage());
            exit();
        }

        // 파일 첨부했는지 확인
        if(is_uploaded_file($_FILES["files"]["tmp_name"][0])){
            $allowDataType = array(
                'jpg', 'png', 'jpeg', 'txt'
            );
            $target_dir = "../../files/";
            $uploadOk = array_fill(0, 9, true);
        
            for($i = 0; $i < count($_FILES["files"]["name"]); $i++){
                //파일 크기 검사
                if($_FILES["files"]["name"][$i] > 500000){
                    $uploadOk[$i] = false;
                    continue;
                }
                
                //파일 확장자 검사
                $target_file = $target_dir . basename($_FILES["files"]["name"][$i]);
                $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                
                $isAllowType = false;
                foreach($allowDataType as $type){
                    if($type == $fileType){
                        $isAllowType = true;
                        break;
                    }
                }
                if($isAllowType == false){
                    $uploadOk[$i] = false;
                }
            }
        
            try{
                $query = "INSERT INTO `table_attach` (`file_id`, `board_id`, `file_name_origin`, `file_name_save`) 
                VALUES (?, ?, ?, ?)";
                $stmt = $db->prepare($query);
                
                //파일 업로드 및 db에 매핑
                for($i = 0, $cnt = 0; $i < count($_FILES["files"]["name"]); $i++){
                    if($cnt > 10){
                        alert("파일은 10개까지만 업로드 할 수 있습니다.");
                        break;
                    }
                    if($uploadOk[$i] == true){
                        $file_name_origin = $_FILES["files"]["name"][$i];
                        $fileType = strtolower(pathinfo($file_name_origin,PATHINFO_EXTENSION));

                        $file_id = md5(uniqid(rand(), true));
                        $file_name_save = md5(microtime()).".".$fileType;
                        $target_file = $target_dir.$file_name_save;
                        $attr_values = array($file_id, $id, $file_name_origin, $file_name_save);
                        try{
                            $stmt->execute($attr_values);
                            write_log("file_id : $file_id // file_name_save : $file_name_save // file_name_origin : $file_name_origin");
                            if (move_uploaded_file($_FILES["files"]["tmp_name"][$i], $target_file)) {
                                write_log("The file ". basename($file_name_origin). " has been uploaded.");
                                $cnt++;
                            } else {
                                alert("파일 업로드 에러");
                                write_log("Sorry, there was an error uploading your file.");
                            }
                        }catch(PDOException $e){
                            write_log($e->getMessage());
                            exit();
                        }
                    }
                }
            }catch(PDOException $e){
                write_log($e->getMessage());
                exit();
            }
        }
    }
}
header("Location: http://hotcat.ddns.net:40080/pi");
?>
