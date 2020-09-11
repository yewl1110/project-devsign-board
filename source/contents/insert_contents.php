<?php 
require_once('../errors.php');
require_once('../db.class.php');
require_once('../declared.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

DB::connect();

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
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["subject"]) && isset($_SESSION["id"])){
        $id = null;
        
        $query = "INSERT INTO board (user_id, user_name, subject, contents, reg_date, hits) 
        VALUES (:user_id, COALESCE(DEFAULT(user_name), :user_name), :subject, :contents, :reg_date, DEFAULT(hits))";
        $params = array(
            ":user_id" => $_SESSION["id"],
            ":user_name" => $_SESSION["nickname"],
            ":subject" => $_POST["subject"],
            ":contents" => htmlspecialchars($_POST['contents'], ENT_QUOTES),
            ":reg_date" => date("Y-m-d H:i:s")
        );
        DB::query2($query, $params);
        $id = DB::lastInsertId();
        
        // 파일 첨부했는지 확인
        if(is_uploaded_file($_FILES["files"]["tmp_name"][0])){
            $allowDataType = array(
                'jpg', 'png', 'jpeg', 'txt'
            );
            $uploadOk = array_fill(0, 9, true);
            
            for($i = 0; $i < count($_FILES["files"]["name"]); $i++){
                //파일 크기 검사
                if($_FILES["files"]["name"][$i] > 500000){
                    $uploadOk[$i] = false;
                    continue;
                }
                
                //파일 확장자 검사
                $target_file = DB::getFilePath() . basename($_FILES["files"]["name"][$i]);
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
            
            $query = "INSERT INTO table_attach (file_id, board_id, file_name_origin, file_name_save) 
            VALUES (:file_id, :board_id, :file_name_origin, :file_name_save)";
            
            //파일 업로드 및 db에 매핑
            for($i = 0, $cnt = 0; $i < count($_FILES["files"]["name"]); $i++){
                if($cnt > 10){
                    ErrorManager::alert("파일은 10개까지만 업로드 할 수 있습니다.");
                    break;
                }
                if($uploadOk[$i] == true){
                    $file_name_origin = $_FILES["files"]["name"][$i];
                    $file_name_save = md5(microtime()).".".$fileType;
                    $fileType = strtolower(pathinfo($file_name_origin,PATHINFO_EXTENSION));
                    $target_file = DB::getFilePath() . $file_name_save;
                    
                    $params = array(
                        ":file_id" => md5(uniqid(rand(), true)),
                        ":board_id" => $id,
                        ":file_name_origin" => $file_name_origin,
                        ":file_name_save" => $file_name_save
                    );
                    
                    if (move_uploaded_file($_FILES["files"]["tmp_name"][$i], $target_file)) {                            
                        ErrorManager::write_log("The file ". basename($file_name_origin). " has been uploaded.");
                        DB::query2($query, $params);
                        $cnt++;
                    } else {
                        ErrorManager::alert("파일 업로드 실패 {$file_name_origin}");
                        ErrorManager::write_log("Sorry, there was an ErrorManager uploading your file.");
                    }
                }
            }
        }
    }
}
header("Location:".getRootURL());
?>
