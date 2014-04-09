var app = require('express')(),
    server = require('http').createServer(app),
    io = require('socket.io').listen(server),
    ent = require('ent'), // équivalent de htmlEntities de PHP
    fs = require('fs'),
    mysql = require('mysql'),
    connection = mysql.createConnection({
        host: 'localhost',
        user: 'root',
        password: '',
        database: 'symfony'
    });

io.sockets.on('connection', function(socket) {

    // if user disconnect
    socket.on('disconnect', function() {
        //setTimeout(function() {
        console.log("Tricheur !!!");
        //}, 10000);

    });
});

server.listen(8080);