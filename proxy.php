<?php

// API endpoint
$url = 'https://api.metaphor.systems/search';

// Read the query from the request
$query = isset($_POST['query']) ? $_POST['query'] : '';

// Data to be sent
$data = [
    'query' => $query,
    'useAutoprompt' => true
];

// Set up the HTTP headers
$options = [
    'http' => [
        'header' => "Content-type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "X-API-Key: 096b1fdb-8ea2-4694-b714-5c0a6c6d2189",
        'method' => 'POST',
        'content' => json_encode($data)
    ]
];

// Create a stream context
$context = stream_context_create($options);

// Make the request
$result = file_get_contents($url, false, $context);

// Output the result
echo $result;
?>
