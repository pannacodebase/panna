<?php
// upload.php

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . basename($_FILES['file']['name']);

    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
        echo json_encode(['status' => 'success', 'message' => 'File uploaded successfully']);
        exit;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error uploading file']);
        exit;
    }
}

echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
?>
