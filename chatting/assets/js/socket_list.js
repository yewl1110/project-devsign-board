var socket = io(`http://hotcat-chatting.ddns.net:43000?room_name=room_list`);

socket.on('join', function(msg) {
    var users = JSON.parse(msg);
    var rooms = $('#room-list').children();
    for(var i=0;i<$(rooms).length;i++){
        var a = $(rooms)[i];
        $(a).find('.user-count').text(users['room'+(i+1)]);
    }
});

socket.on('update', function(msg) {
    var users = JSON.parse(msg);
    var room = Object.keys(users)[0];
    var rooms = $('#room-list').children();
    var idx = parseInt(room.substr(room.length - 1, 1));
    var a = $(rooms)[idx - 1];
    $(a).find('.user-count').text(users[room]);
});