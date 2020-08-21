<?php
require_once("declared.php");
require_once("db.class.php");
require_once('errors.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST["board_id"])) {
    DB::connect();
    $rows = DB::query2(
        "SELECT user_id FROM board WHERE board_id = :board_id",
        array(":board_id" => $_POST["board_id"])
    );

    if ($rows["0"]["user_id"] == $_SESSION["id"]) {
        DB::query2(
            "UPDATE board SET subject = :subject, contents = :contents WHERE board_id = :board_id",
            array(
                ":subject" => $_POST["subject"],
                ":contents" => htmlspecialchars($_POST['contents'], ENT_QUOTES),
                ":board_id" => $_POST["board_id"]
            )
        );

        // 파일 삭제
        if ($_POST["removeFiles"][0] != '') {
            $removeFileList = $_POST["removeFiles"]; // 삭제할 파일 ID들

            foreach ($removeFileList as $file) {
                $fileName = DB::query2(
                    "SELECT file_name_save FROM table_attach WHERE board_id = :board_id AND file_id = :file_id",
                    array(":board_id" => $_POST["board_id"],
                    ":file_id" => $file)
                );
                unlink(DB::getFilePath() . $fileName[0]["file_name_save"]);
                DB::query2(
                    "DELETE FROM table_attach WHERE board_id = :board_id AND file_id = :file_id",
                    array(":board_id" => $_POST["board_id"],
                    ":file_id" => $file)
                );
            }
        }

        // 파일 첨부했는지 확인
        if (is_uploaded_file($_FILES["files"]["tmp_name"][0])) {
            $allowDataType = array(
                'jpg', 'png', 'jpeg', 'txt'
            );
            $uploadOk = array_fill(0, 9, true);

            for ($i = 0; $i < count($_FILES["files"]["name"]); $i++) {
                //파일 크기 검사
                if ($_FILES["files"]["name"][$i] > 500000) {
                    $uploadOk[$i] = false;
                    continue;
                }

                //파일 확장자 검사
                $target_file = DB::getFilePath() . basename($_FILES["files"]["name"][$i]);
                $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                $isAllowType = false;
                foreach ($allowDataType as $type) {
                    if ($type == $fileType) {
                        $isAllowType = true;
                        break;
                    }
                }
                if ($isAllowType == false) {
                    $uploadOk[$i] = false;
                }
            }

            $query = "INSERT INTO table_attach (file_id, board_id, file_name_origin, file_name_save) 
        VALUES (:file_id, :board_id, :file_name_origin, :file_name_save)";

            //파일 업로드 및 db에 매핑
            for ($i = 0, $cnt = 0; $i < count($_FILES["files"]["name"]); $i++) {
                if ($cnt > 10) {
                    ErrorManager::alert("파일은 10개까지만 업로드 할 수 있습니다.");
                    break;
                }
                if ($uploadOk[$i] == true) {
                    $file_name_origin = $_FILES["files"]["name"][$i];
                    $file_name_save = md5(microtime()) . "." . $fileType;
                    $fileType = strtolower(pathinfo($file_name_origin, PATHINFO_EXTENSION));
                    $target_file = DB::getFilePath() . $file_name_save;

                    $params = array(
                        ":file_id" => md5(uniqid(rand(), true)),
                        ":board_id" => $_POST["board_id"],
                        ":file_name_origin" => $file_name_origin,
                        ":file_name_save" => $file_name_save
                    );

                    if (move_uploaded_file($_FILES["files"]["tmp_name"][$i], $target_file)) {
                        ErrorManager::write_log("The file " . basename($file_name_origin) . " has been uploaded.");
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
    header("Location: " . getRootURL());
}
