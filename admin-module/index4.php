<?php

$filename = 'uploads/autism0.txt';
$chunks = [];
$sentences = [];

if (!file_exists($filename)) {
    echo "Error: File does not exist.\n";
    exit;
}

$file = fopen($filename, 'r');

while (($line = fgets($file)) !== false) {
    $line = preg_replace('/\s+/', ' ', $line); // Remove extra spaces
    $line = trim($line);                       // Remove leading and trailing spaces

    if (empty($line)) {
        if (!empty($sentences)) {
            $chunk = implode(' ', $sentences);
            $chunks[] = $chunk;
            $sentences = [];
        }
        continue;
    }

    $sentences[] = $line;                       // Add individual sentences to array
}

fclose($file);

if (!empty($sentences)) {
    $chunk = implode(' ', $sentences);
    $chunks[] = $chunk;
}

// Cohere API Request
$url = 'https://api.cohere.ai/v1/embed';
$api_key = 'WYjPrxGVZsqdXCiRsjnhGGtg3jcmHJqziCvx1Fby';

$headers = [
    'Authorization: BEARER ' . $api_key,
    'Content-Type: application/json',
];

$data = [
    'model' => 'embed-english-v3.0',
    'texts' => $chunks,             // Use chunks generated from the previous code
    'input_type' => 'classification',
];

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
echo $response;

if ($httpCode === 200) {
    $embedding_data = json_decode($response, true);

    // Display the results in a table
    echo '<table border="1">';
    echo '<tr><th>Sentence</th><th>Vector</th></tr>';
    foreach ($embedding_data['results'] as $index => $result) {
        echo '<tr>';
        echo '<td>' . $result['text'] . '</td>';
        echo '<td>' . implode(',', $result['embedding']) . '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo 'Error making request. HTTP Code: ' . $httpCode;
}

curl_close($ch);
?>
