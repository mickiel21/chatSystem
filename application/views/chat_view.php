<!DOCTYPE html>
<html>
<head>
    <title>Chat</title>
</head>
<body>
<div id="chat"></div>
    <input type="button" value="Send Message" onclick="sendMessage()">
    <script>
        var conn = new WebSocket('ws://chatsystem.com.ph:8080');
        conn.onopen = function(e) {
            console.log("Connected to WebSocket");
        };
        conn.onmessage = function(e) {
            var chatDiv = document.getElementById('chat');
            chatDiv.innerHTML += '<p>' + e.data + '</p>';
        };
        function sendMessage() {
            var message = prompt('Enter your message:');
            conn.send(message);
        }
    </script>
</body>
</html>