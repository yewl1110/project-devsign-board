// server.js와 통신
// socket client
var socket = io(`http://hotcat.ddns.net:10002?room_name=${room_name}`); //1
// var socket = io();

$('#chat').on('submit', function (e) { //2
    if($('#message').val().trim().length > 0){
        socket.emit('send message', $('#name').html(), $('#message').val().trim());
    }
    $('#message').val('');
    $('#message').focus();
    e.preventDefault();
});
socket.on('receive message', function (msg) { //3
    var division = msg.indexOf(':');
    $('#chatLog').append(`<div class="message"><span>${msg.slice(0, division)}</span><span>${msg.slice(division + 1, msg.length)}</span></div>`);
    $('#chatLog').scrollTop($('#chatLog')[0].scrollHeight);
});

// 이름 설정
socket.on('change name', function (name) { //4
    $('#name').html(name);
    $('#user_list').append(`<tr><td>${name}</td></tr>`);
    $('#user_count').html($('#user_list > tbody > tr').length - 1);
});

// 서버 측에서 강제 종료
socket.on('server disconnect', function(){
    socket.close();
    $('#chat *').attr('disabled', true);
    alert('연결이 종료되었습니다.');
});

socket.on('join', function(user_id) {
    $('#chatLog').append(`<div><span class="system-message"><p>${user_id}</p>님이 접속했습니다.</span><div>`);
    $('#chatLog').scrollTop($('#chatLog')[0].scrollHeight);
    $('#user_list').append(`<tr><td>${user_id}</td></tr>`);
    $('#user_count').html($('#user_list > tbody > tr').length - 1);
});

socket.on('leave', function(user_id) {
    $('#chatLog').append(`<div><span class="system-message"><p>${user_id}</p>님이 나갔습니다.</span><div>`);
    $("#user_list tr").filter(function() {
        return $(this).text() === user_id;
    })[0].closest('tr').remove();
    $('#chatLog').scrollTop($('#chatLog')[0].scrollHeight);
    $('#user_count').html($('#user_list > tbody > tr').length - 1);
});