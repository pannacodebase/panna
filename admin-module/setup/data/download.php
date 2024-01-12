<?php
if (isset($_GET['file_path'])) {
    $file_path = $_GET['file_path'];

    // Set the appropriate headers for download
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');

    // Output the file content
    echo file_get_contents("https://api.telegram.org/file/bot" . $TOKEN . "/" . $file_path);
} else {
    // File path not provided, handle the error or redirect as needed
    echo "File path not provided.";
}
?>
