<?php

$url = 'https://api.cohere.ai/v1/embed';
$api_key = 'WYjPrxGVZsqdXCiRsjnhGGtg3jcmHJqziCvx1Fby';

$headers = [
    'Authorization: BEARER ' . $api_key,
    'Content-Type: application/json',
];

$data = [
    'model' => 'embed-english-v3.0',
    'texts' => [
        "When are you open?", "When do you close?", "What are the hours?",
        "Are you open on weekends?", "Are you available on holidays?", "How much is a burger?",
        "What's the price of a meal?", "How much for a few burgers?", "Do you have a vegan option?",
        "Do you have vegetarian?", "Do you serve non-meat alternatives?", "Do you have milkshakes?",
        "Milkshake", "Do you have dessert?", "Can I bring my child?", "Are you kid-friendly?",
        "Do you have booster seats?", "Do you do delivery?", "Is there takeout?", "Do you deliver?",
        "Can I have it delivered?", "Can you bring it to me?", "Do you have space for a party?",
        "Can you accommodate large groups?", "Can I book a party here?",
    ],
    'input_type' => 'classification',
];

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

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
