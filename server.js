var app = require('express')();
var fs = require('fs');
var privateKey = fs.readFileSync('/etc/letsencrypt/live/'+window.location.hostname+'/privkey.pem', 'utf8');
var certificate = fs.readFileSync('/etc/letsencrypt/live/'+window.location.hostname+'/fullchain.pem', 'utf8');
var credentials = {
  key: privateKey,
  cert: certificate
};
var http = require('https').Server(credentials, app);
var io = require('socket.io')(http);

app.get('/', function(req, res) {
  res.sendFile(__dirname + '/index.html');
});

redis.subscribe('site', function(err, count) {
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