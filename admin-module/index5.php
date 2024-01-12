<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Interface</title>
    <!-- Bootstrap CSS link (you may need to adjust the path) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div id="chatBox" style="height: 300px; overflow-y: auto; border: 1px solid #ccc; padding: 10px;"></div>
                <input type="text" id="queryInput" class="form-control mt-3" placeholder="Type your question...">
                <button onclick="sendQuery()" class="btn btn-primary mt-2">Send</button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery (you may need to adjust the paths) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function sendQuery() {
            var query = $('#queryInput').val();

            // Make a request to the proxy
            $.ajax({
                url: 'metaphor.php',
                type: 'POST',
                data: {
                    query: query,
                    useAutoprompt: true
                },
                success: function(response) {
                    // Update the chat box with the result
                    $('#chatBox').append('<p><strong>You:</strong> ' + query + '</p>');
                    $('#chatBox').append('<p><strong>Response:</strong> ' + response + '</p>');
                    // Clear the input field
                    $('#queryInput').val('');
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }
    </script>
</body>
</html>
