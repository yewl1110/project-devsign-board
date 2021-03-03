<?php
if($_GET['message']){
    header("Location: contents/index.php?message=" . $_GET['message']);
}
else{
    header("Location: contents/");
}
exit;
?>