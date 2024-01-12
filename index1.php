<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Interface</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>

<body>

    <div class="chat-container">
        <h3>Chat with a LLM</h3>

        <div id="chat" class="message-container"></div>

        <div id="input-container" class="input-group mb-3">
            <input type="text" id="userInput" class="form-control" placeholder="Type your question..." onkeydown="handleKeyPress(event)" aria-label="Type your question...">
            <button class="btn btn-primary" onclick="sendMessage()">Send</button>
        </div>
    </div>

<script src="script.js">
</script>
</body>
</html>
