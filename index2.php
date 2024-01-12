<?php
$url = 'https://test-bzpatrm.svc.gcp-starter.pinecone.io/describe_index_stats';
$apiKey = '285afab3-a625-4da1-8271-dd544cf23e87';

$headers = [
    'Api-Key: ' . $apiKey,
    'accept: application/json',
    'content-type: application/json',
];

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($httpCode === 200) {
    echo 'Successful request!';
    echo $response; // If you want to print the response
    
} else {
    echo 'Error making request. HTTP Code: ' . $httpCode;
}

curl_close($ch);
?>
