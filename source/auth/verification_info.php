<?php
require_once('../auth.class.php');

//email정보 POST로받아서 메일 보내기
function sendMail()
{
}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.0/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
</head>

<body>
    <header></header>
    <main>
        <h1>
            메일을 확인해주세요</br>
        </h1>
        <h1>
            home</br>
        </h1>
        <button onclick="sendMail()">다시 전송</button>
    </main>
</body>

</html>