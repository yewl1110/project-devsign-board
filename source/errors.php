<?php
function write_log($messages){
    $logPath = $_SERVER['DOCUMENT_ROOT'].'/pi/log/error_log.txt';

    $cur_time = date("Y-m-d h:i:s", mktime());
    $result = '['.$cur_time.']'.$messages."\n";
    error_log($result, 3, $logPath);
}
?>