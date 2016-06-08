var app     = require('express')();
var http    = require('http').Server(app);
var io      = require('socket.io')(http);
var Redis   = require('ioredis');
var redis   = new Redis();

var clients = {};

io.sockets.on('connection', function (socket) {
    socket.on('add-user', function (data) {
        clients[data.id_user] = {
            "socket" : socket.id
        };
    });

    redis.on('message', function (channel, message) {
        message = JSON.parse(message);
        
        var data = message.data.data;
        
        if (clients[data.id_user]) {
            io.sockets
              .connected[clients[data.id_user].socket]
              .emit(channel + ":" + message.event, data);
        }
    });
    
    socket.on('disconnect', function () {        
        for (var id_user in clients) {
            if (clients[id_user].socket === socket.id) {
                delete clients[id_user]; break;
            }
    }});
});

redis.subscribe('channel', function (err, count) { 
    return true;
});

http.listen(3000, function () {
    console.log('Socket active!');
});
