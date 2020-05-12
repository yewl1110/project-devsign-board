<?php

class ErrorManager {
    const MESSAGES = array(
        "ACCOUNT_WRONG" => "ID 또는 비밀번호가 틀립니다.",
        "PASSWORD_WRONG" => "비밀번호가 틀립니다.",
        "LIMIT_NUMBER_FILES" => "파일은 최대 10개까지만 업로드 할 수 있습니다.",
        "LIMIT_FILE_SIZE" => "파일의 용량이 너무 큽니다.",
        "NO_AUTH" => "로그인이 필요한 기능입니다.",
        "ACCOUNT_CHANGE_SUCCESS" => "변경되었습니다."
    );

    public static function write_log($message){
        $logPath = $_SERVER['DOCUMENT_ROOT'].'/pi/log/error_log.txt';

        $cur_time = date("Y-m-d h:i:s", mktime());
        $result = '['.$cur_time.']'.$message."\n";
        error_log($result, 3, $logPath);
    }
        
    public static function alert($message){
        echo '<script type="text/javascript">
            alert("'.$message.'");
        </script>';
    } 

    public static function requestAlert($message){
        echo '<script type="text/javascript">
            alert("'.self::MESSAGES[$message].'");
        </script>';
    }
}
?>