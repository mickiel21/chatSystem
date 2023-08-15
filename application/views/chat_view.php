<!DOCTYPE html>
<html>
<head>
    <title>Chat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        #chat {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        #chat p {
            margin: 5px 0;
            padding: 5px 10px;
            border-radius: 5px;
            background-color: #f2f2f2;
        }

        #input-container {
            display: flex;
            margin-top: 10px;
        }

        #message-input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px 0 0 5px;
        }

        #send-button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
        }

        #send-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div id="chat">
        <!-- Chat messages will appear here... -->
    </div>
    <div id="input-container">
        <input type="text" id="message-input" placeholder="Enter your message">
        <button id="send-button">Send Message</button>
    </div>
    <script>
     
        var conn = new WebSocket('ws://chatsystem.com.ph:8080?access_token=<?= $this->session->userdata('userId'); ?>');
        conn.onopen = function(e) {
            console.log("Connected to WebSocket");
        };
        conn.onmessage = function(e) {
            var chatDiv = document.getElementById('chat');
            chatDiv.innerHTML += '<p>' + e.data + '</p>';
        };

        var sendButton = document.getElementById('send-button');
        var messageInput = document.getElementById('message-input');

        sendButton.addEventListener('click', function() {
            var message = messageInput.value.trim();
            if (message !== '') {
                conn.send(message);
                messageInput.value = ''; // Clear input field after sending
            }
        });
    </script>
</body>
</html>