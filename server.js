var app     = require('express')();
var http    = require('http').Server(app);
var io      = require('socket.io')(http);
var Redis   = require('ioredis');
var redis   = new Redis();

var clients = {};

io.sockets.on('connection', function (socket) {
    socket.on('add-user', function (data) {        
        clients[data.user_id] = {
            "socket" : socket.id
        };
    });

    redis.on('message', function (channel, message) {
        message = JSON.parse(message);
        
        console.log(message);
        var data = message.data.data;
        
        if (clients[data.user_id]) {
            io.sockets
              .connected[clients[data.user_id].socket]
              .emit(channel + ":" + message.event, data);
        }
    });
    
    socket.on('disconnect', function () {        
        for (var user_id in clients) {
            if (clients[user_id].socket === socket.id) {
                delete clients[user_id].socket; break;
            }
    }});
});

redis.subscribe('channel', function (err, count) { 
    return true;
});

http.listen(3000, function () {
    console.log('Socket active!');
});
