const app = require('express')();
const http = require('http').Server(app);
const io = require('socket.io')(http);
const Redis = require('ioredis');
const redis = new Redis();

app.get('/', function(req, res) {
  res.sendFile(__dirname + '/index.html');
});

redis.subscribe('core', function(err, count) {
});

redis.on('message', function(channel, message) {
  message = JSON.parse(message);
  var parts = message.event.split("\\");
  var result = parts[parts.length - 1]
  io.emit(result, message.data);
});

http.listen(8081, function() {
  console.log('Listening on Port 8081');
});
