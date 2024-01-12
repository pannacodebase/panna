<?php

$apiKey = 'AIzaSyC3C2wv6Wl-87BuDlhRxDrgoE8L-3-KwYI';

// Make a search request
$searchQuery = 'rdi autism'; // Update the search query
$maxResults = 10;

// Encode the search query
$encodedQuery = urlencode($searchQuery);

$url = "https://www.googleapis.com/youtube/v3/search?key={$apiKey}&q={$encodedQuery}&maxResults={$maxResults}&part=id,snippet";
$response = file_get_contents($url);

// Check for errors in the response
if ($response === false) {
    die('Error fetching data from YouTube API');
}

// Decode the JSON response
$data = json_decode($response, true);

// Display search results in an HTML table
echo '<table border="1">';
echo '<tr><th>Title</th><th>Video ID</th><th>Thumbnail</th><th>Transcript</th></tr>';

foreach ($data['items'] as $item) {
    $title = $item['snippet']['title'];
    $videoId = $item['id']['videoId'];
    $thumbnailUrl = $item['snippet']['thumbnails']['default']['url'];

    // Fetch captions
    $captionsUrl = "https://www.googleapis.com/youtube/v3/captions?part=snippet&videoId={$videoId}&key={$apiKey}";
    $captionsResponse = file_get_contents($captionsUrl);
    $captionsData = json_decode($captionsResponse, true);

    $transcript = isset($captionsData['items'][0]['snippet']['title']) ? $captionsData['items'][0]['snippet']['title'] : 'Not available';

    echo "<tr>";
    echo "<td>{$title}</td>";
    echo "<td>{$videoId}</td>";
    echo "<td><img src='{$thumbnailUrl}' alt='Thumbnail'></td>";
    echo "<td>{$transcript}</td>";
    echo "</tr>";
}

echo '</table>';
?>
