<?php

if (session_status() != PHP_SESSION_NONE) {
    header("Location:" . $_SERVER["HTTP_REFERER"]);
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/js/bootstrap.min.js"></script>
<script>
    function sendMail() {
        var params = new URLSearchParams(window.location.search);;

        $.ajax({
            url: "/auth/send_mail.php?id=" + params.get('id') + "&email=" + params.get('email'),
            type: "get",
            async: false,
            success: function(result) {
                if (!alert('재전송완료')) {
                    history.back();
                }
            }
        });
    }
</script>

</html>