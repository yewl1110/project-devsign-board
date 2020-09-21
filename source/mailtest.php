<?php
$to = 'yewl1110@naver.com';
$subject = 'subejct';
$msg = 'testtest';

$check = mail($to, $subject, $msg);

if($check){
    echo 'success';
}else{
    echo 'fail';
}
?>