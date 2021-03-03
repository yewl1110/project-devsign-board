module.exports = {
    page_room: {
        HTML: function (max_user) {
            return `
            <!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/css/bootstrap.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap-grid.min.css"
        integrity="sha512-QTQigm89ZvHzwoJ/NgJPghQPegLIwnXuOXWEdAjjOvpE9uaBGeI05+auj0RjYVr86gtMaBJRKi8hWZVsrVe/Ug=="
        crossorigin="anonymous" />
    <link rel="stylesheet" href="assets/style/theme.css" type="text/css">
    <style type="text/css">
        #room-list p{
            display: inline;
        }
        .container {
            padding-top: 10px;
            max-width: 768px;
        }
    </style>
</head>

<body>
        <div class="container">
            <div class="list-group" id="room-list">
                <a href="/client/1" class="list-group-item list-group-item-action">
                    <div>
                        <h4>Room-1</h4>
                        <div><p class="user-count">?</p> / <p>${max_user}</p></div>
                    </div>
                </a>
                <a href="/client/2" class="list-group-item list-group-item-action">
                    <div>
                        <h4>Room-2</h4>
                        <div><p class="user-count">?</p> / <p>${max_user}</p></div>
                    </div>
                </a>
                <a href="/client/3" class="list-group-item list-group-item-action">
                    <div>
                        <h4>Room-3</h4>
                        <div><p class="user-count">?</p> / <p>${max_user}</p></div>
                    </div>
                </a>
                <a href="/client/4" class="list-group-item list-group-item-action">
                    <div>
                        <h4>Room-4</h4>
                        <div><p class="user-count">?</p> / <p>${max_user}</p></div>
                    </div>
                </a>
                <a href="/client/5" class="list-group-item list-group-item-action">
                    <div>
                        <h4>Room-5</h4>
                        <div><p class="user-count">?</p> / <p>${max_user}</p></div>
                    </div>
                </a>
            </div>
        </div>
    
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/3.0.1/socket.io.js"
        integrity="sha512-vGcPDqyonHb0c11UofnOKdSAt5zYRpKI4ow+v6hat4i96b7nHSn8PQyk0sT5L9RECyksp+SztCPP6bqeeGaRKg=="
        crossorigin="anonymous"></script>
    <script src="//code.jquery.com/jquery-1.11.1.js"></script>
    <script src="assets/js/socket_list.js"></script>
</body>

</html>
            `;
        }
    },
    page_client: {
        HTML: function (list, room) {
            return `
            <!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/css/bootstrap.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap-grid.min.css"
        integrity="sha512-QTQigm89ZvHzwoJ/NgJPghQPegLIwnXuOXWEdAjjOvpE9uaBGeI05+auj0RjYVr86gtMaBJRKi8hWZVsrVe/Ug=="
        crossorigin="anonymous" />
    <base href=".."/>
    <link rel="stylesheet" href="/assets/style/theme.css" type="text/css">
</head>

<body>
    <div class="container-lg">
        <div class="row">
            <div class="col-md-5 d-md-block" id="table-wrapper">
                ${list}
            </div>
            <div class="col-md-7 col-12" id="chat-wrapper">
                <table class="table" id="padding">
                    <thead><th>a</th></thead>
                </table>
                <div class="col">
                    <div id="chatLog" class="chat-log"></div>
                </div>
                <div class="col">
                    <form id="chat">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span id="name" class="input-group-text"></span>
                            </div>
                            <input id="message" type="text" class="form-control" placeholder=""
                                aria-label="Example text with button addon" aria-describedby="button-addon1">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/3.0.1/socket.io.js"
        integrity="sha512-vGcPDqyonHb0c11UofnOKdSAt5zYRpKI4ow+v6hat4i96b7nHSn8PQyk0sT5L9RECyksp+SztCPP6bqeeGaRKg=="
        crossorigin="anonymous"></script>
    <!-- 1 -->
    <script src="//code.jquery.com/jquery-1.11.1.js"></script>
    <script type="text/javascript" defer>
    $(document).ready(function() {
        $(window).resize();
    });

    $(window).on('resize', function(){
        var wrapperHeight = $(window).outerHeight();
        $('#chat-wrapper').css("height", wrapperHeight).css("max-height", wrapperHeight);
        $('#table-wrapper').css("max-height", wrapperHeight);

        var chatLogHeight = $(window).outerHeight() - $('#chatLog').outerHeight(true) + $('#chatLog').outerHeight() - $('#chat .input-group').outerHeight(true);
        
        // user-list table 표시
        if(window.innerWidth >= 768){
            $('#user_list tbody').css("display", "table-row-group");
        }else{
            chatLogHeight -= $('#padding').outerHeight(true);
            $('#user_list tbody').css("display", "none");
        }
        $('#chatLog').css("height", chatLogHeight).css("max-height", chatLogHeight);
    });
    
    $('#user_list thead').on('click', function() {
        // 모바일일 때 테이블 숨김
        if(window.innerWidth <= 768){
            var tbody = $(this).siblings('tbody')[0];
            $(tbody).toggle();
        }
    });
    $('#room_name').html('${room}');
    var room_name = '${room}';
    </script>
    <script src="/assets/js/socket_client.js" defer></script>
</body>
</html>`;
        },
        list: function (userlist) {
            var table = `
            <table class="table table-striped table-hover" id="user_list">
                <thead>
                    <tr><th><p id="room_name"></p> - <p id="user_count">?</p> 명 접속중</th></tr>
                </thead>
                <tbody>
                    <tr style="display: none;"></tr>`;
            userlist.forEach(userid => {
                if (userid == '') 
                    return;
                table += `<tr><td>${userid}</td></tr>`
            });
            table += '</tbody></table>';
            return table;
        }
    }
}