<?php
// contents_insert.php랑 합칠거임
require_once('errors.php');

// Check if image file is a actual image or fake image
//동적 배열로 바꾸기????
//if(isset($_POST["submit"])) {
if(isset($_POST["submit"]) && count($_FILES["files"]["name"]) <= 10){
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

    for($i = 0; $i < count($_FILES["files"]["name"]); $i++){
        if($uploadOk[$i] == true){
            $file_name_origin = $_FILES["files"]["name"][$i];
            //$target_file = $target_dir . basename($file_name_origin);
            //$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $fileType = strtolower(pathinfo($file_name_origin,PATHINFO_EXTENSION));
            
            //파일 이름 바꾸기 db 매핑할거임
            $file_id = md5(uniqid(rand(), true));
            //$type = substr($file_name_origin, strpos($file_name_origin, "."));
            $file_name_save = md5(microtime()).".".$fileType;
            $target_file = $target_dir.$file_name_save;

            write_log("file_id : $file_id // file_name_save : $file_name_save // file_name_origin : $file_name_origin");
            
            if (move_uploaded_file($_FILES["files"]["tmp_name"][$i], $target_file)) {
                write_log("The file ". basename($file_name_origin). " has been uploaded.");
            } else {
                write_log("Sorry, there was an error uploading your file.");
            }
        }
    }
}

// insert into table_attach values ((select board_id from board where LAST_INSERT_ID() = $id), $file_name);
// 파일 첨부했을 때 게시글 올리면서 그 게시글 id 가져와서 첨부파일 테이블에 값 넣기
?>


