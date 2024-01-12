<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract user input
    $userInput = $_POST["userInput"];

    // Make the Cohere API request
    $url = 'https://api.cohere.ai/v1/chat';

    $headers = array(
        'Authorization: Bearer WYjPrxGVZsqdXCiRsjnhGGtg3jcmHJqziCvx1Fby',
        'Content-Type: application/json',
    );

    $data = array(
        "model" => "command-light",
        "message" => $userInput,
        "temperature" => 0.3,
        "prompt_truncation" => "AUTO",
        "stream" => true,
        "citation_quality" => "accurate",
//        "connectors" => array(
//            array(
//              "id" => "web-search"
//            )
//          ),
      
        "documents" => array(),
    );

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);
    }

    curl_close($ch);

    // Output the last response text
    echo $response;
}

?>
