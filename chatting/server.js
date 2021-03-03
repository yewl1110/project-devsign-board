// server.js
var express = require('express');
var session = require('express-session');
var app = express();
var http = require('http').Server(app); //1
var io = require('socket.io')(http); //1
var url = require('url');

var RedisStore = require('connect-redis')(session);
var redis = require('redis');
var client = redis.createClient(6379, '127.0.0.1');
var fs = require('fs');

var tem = require('./template');
var db = require('./db');

var user_id = null,
    sessid = null;
const max_user = 50;

app.use('/assets', express.static(__dirname + '/assets'));

app.use(session({
    secret: 'hooooootcat',
    resave: false,
    saveUninitialized: true,
    store: new RedisStore({
        client: client,
        ttl: 60 * 60 * 24
    })
}))

app.get('/', function (req, res) { //2
    var _url = req.url;
    sessid = url
        .parse(_url, true)
        .query['sessid'];
    if (sessid !== undefined) {
        // db에 저장된 PHP세션 값이 유효할 때 express 세션 생성 동기 실행 코드
        var result;
        (async function () {
            result = await db.run(sessid);
        })()
            .then(function () {
                if (result !== '') { // PHP세션 값 살아있으면
                    var sess = req.session;
                    // php session value 파싱 후 express 세션 값에 추가
                    result
                        .split(';')
                        .forEach(fields => {
                            if (fields == '') 
                                return;
                            var col = fields.split(':');
                            var key = '_' + col[0].split('|')[0];
                            var is_null = col[0].split('|')[1];

                            sess[key] = (is_null == 'N') ? '' : col[2].split('"')[1];
                        });

                    user_id = sess['_id'];
                    sess.save();

                    client.hset(req.sessionID, 'id', user_id);
                    global.sessionID = req.sessionID;

                    res.redirect('/chat-list');

                } else { // 존재하지 않는 php session 일 때
                    res
                        .status(401)
                        .send('<script type="text/javascript">alert("잘못된 세션입니다.");</script>');
                    res.end();
                }
            })
            .catch(function () { // 에러 발생했을 때
                console.log(result);
                res
                    .status(401)
                    .send('<script type="text/javascript">alert("Error!");</script>');
                res.end();
            });
    } else { // 세션 안넘어왔을 때
        res
            .status(401)
            .send('<script type="text/javascript">alert("잘못된 접근입니다.");</script>');
        res.end();
    }
});

// 채팅방 리스트 출력
app.get('/chat-list', function (req, res) {
    res.send(tem.page_room.HTML(max_user));
});

// 채팅방 번호 인수로 받는 코드 추가 세션 확인하는 코드 추가
app.get('/client/:room', function (req, res) {
    var regExp = /^[1-5]{1}$/;
    if (regExp.test(req.params['room'])) {
        var room_name = 'room' + req.params['room'];
        (async function () {
            return new Promise(function (res, rej) {
                client.hlen(room_name, function (err, user_cnt) {
                    res(user_cnt);
                });
            })
        })().then(function (user_cnt) {
                // 채팅방 꽉찼을 때
                if (user_cnt >= max_user) {
                    res.send(
                        `<script type="text/javascript">alert("더이상 입장할 수 없습니다. ${user_cnt}");</script>`
                    );
                    res.end();
                } else {
                    client.hgetall(room_name, function (err, result) {
                        if (err) {
                            res.send('<script type="text/javascript">alert("에러 발생");</script>');
                            return;
                        }
                        if (result == null) {
                            client.hset(room_name, '', '');
                            client.hdel(room_name, '');
                            result = {
                                '': ''
                            };
                        }
                        res.send(
                            tem.page_client.HTML(tem.page_client.list(Object.keys(result)), room_name)
                        );
                    });
                }
            })
            .catch();
    } else {
        res
            .status(401)
            .send('<script type="text/javascript">alert("잘못된 접근입니다.");</script>');
    }
});

app.get('/destroy', function (req, res) {
    if (req.session != undefined) {
        client.del(req.sessionID);
        req
            .session
            .destroy();
    }
    res.end();
});

app.get('/test', function (req, res) {
    res.writeHead(200, {'Content-Type': 'text/html'}); 
    fs.readFile(__dirname + '/chat-list.html', 
        function (err, result) {     
            res.end(result, 'utf-8'); 
        }
    );
    // res.send(tem.page_room.HTML(max_user));
});

io.on('connection', function (socket) {
    // 세션 없으면 socket 통신 못함 테스트용으로 주석처리
    if (global.sessionID == undefined) 
        return;
    
    var room_name = socket
        .handshake
        .query['room_name'];
    console.log(`socket.handshake.query = ${socket.handshake.query['room_name']}`);

    var name = (user_id != null && user_id != '')
        ? user_id
        : socket.id;

    // 중복 로그인일 때 (socket.id가 이미 존재할 때) 기존 socketid 삭제 동기 실행 코드
    (async function () {
        return new Promise(function (res, rej) {
            if (!client.exists(room_name)) {
                client.hset(room_name, '', '');
            }
            for(var i = 1; i<=5; i++) {
                client.hget('room' + i, name, function (err, id) {
                    if(id == null) return;
                    io
                        .to(id)
                        .emit('server disconnect', '');
                    if (io.sockets.sockets[id]) {
                        io
                            .sockets
                            .sockets[id]
                            .disconnect();
                    }
                    res();
                });
            }
        });
    })();

    socket.join(room_name); // 선택한 채팅방에 입장
    client.hset(room_name, name, socket.id);

    // 채팅방 목록에 인원 표시 동기 코드
    if (room_name == 'room_list') {
        (async function () {
            var rooms = {};
            return new Promise(function (res, rej) {
                client.hlen('room1', function (err, val) {
                    rooms.room1 = val;
                    res();
                })
            })
                .then(function () {
                    client.hlen('room2', function (err, val) {
                        rooms.room2 = val;
                        return;
                    })
                })
                .then(function () {
                    client.hlen('room3', function (err, val) {
                        rooms.room3 = val;
                        return;
                    })
                })
                .then(function () {
                    client.hlen('room4', function (err, val) {
                        rooms.room4 = val;
                        return;
                    })
                })
                .then(function () {
                    client.hlen('room5', function (err, val) {
                        rooms.room5 = val;
                        io
                            .to(socket.id)
                            .emit('join', JSON.stringify(rooms));
                        return;
                    })
                })
                .catch();
        })();

        socket.on('disconnect', function () {
            console.log('user disconnected: ', socket.id);
            client.hdel(room_name, name);
        });
        return;
    }

    socket
        .broadcast
        .to(room_name)
        .emit('join', name); // 방 인원에게 접속 알림
        

    client.hlen(room_name, function (err, val) {
        var obj = {};
        obj[room_name] = val;
        socket
            .to('room_list')
            .emit('update', JSON.stringify(obj));
    });
    console.log('user connected: ', socket.id);

    io
        .to(socket.id)
        .emit('change name', name);

    socket.on('disconnect', function () {
        console.log('user disconnected: ', socket.id);
        socket
            .broadcast
            .to(room_name)
            .emit('leave', name); // 방 인원에게 연결 종료 알림
        client.hdel(room_name, name);
        client.hlen(room_name, function (err, val) {
            var obj = {};
            obj[room_name] = val;
            socket
                .to('room_list')
                .emit('update', JSON.stringify(obj));
        });
    });

    socket.on('send message', function (name, text) {
        var msg = name + ':' + text;
        console.log(msg);
        io
            .sockets
            . in (room_name)
            .emit('receive message', msg);
    });
});

http.listen(3000, function () {
    console.log('server on!');
});