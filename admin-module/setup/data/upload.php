<?php
$uploadMessage = '';
$topicId = isset($_GET['topic_id']) ? (int)$_GET['topic_id'] : 0;

// Database connection
$servername = "localhost";
$username = "rgdhicgm_app";
$password = "app123";
$dbname = "rgdhicgm_app";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete record if delete button is clicked
if (isset($_GET['delete_id'])) {
    $deleteId = (int)$_GET['delete_id'];
    $deleteSql = "DELETE FROM files WHERE id = $deleteId";
    if ($conn->query($deleteSql) === TRUE) {
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

if (isset($_FILES['document']) && isset($_POST['authorName'])) {
    include '../../telegramapi/Telegram.php';
    include 'telegramapi/Telegram.php';
    $TOKEN = '5664649711:AAGYh69g5bvzIFErXyJxGPXIx-2n4ZKn75o';

    $chat_id = '5094418997';

    $name = $_FILES['document']['name'];
    $authorName = $_POST['authorName'];
    $fullName = $_SESSION['userData']['first_name'] . ' ' . $_SESSION['userData']['last_name'];

    if (isset($name) && !empty($name)) {
        $telegram = new Telegram($TOKEN);
        $uploaddir = 'upload/';
        $uploadfile = $uploaddir . basename($name);

        move_uploaded_file($_FILES['document']['tmp_name'], $uploadfile);
        $img = curl_file_create($uploadfile, mime_content_type($uploadfile));
        $content = array(
            'chat_id' => $chat_id,
            'document' => $img,
            'caption' => 'Uploaded by: ' . $authorName,
        );

        $val = $telegram->sendDocument($content);

        $json = json_decode(json_encode($val), true);
        $fileId = $json['result']['document']['file_id'];
        $fileName = $json['result']['document']['file_name'];

        // Get the file path on Telegram servers
        $fileInfo = $telegram->getFile(['file_id' => $fileId]);
        $telegramFilePath = $fileInfo['result']['file_path'];
        $telegramFileUrl = 'https://api.telegram.org/file/bot' . $TOKEN . '/' . $telegramFilePath;

        $uploadMessage = 'File uploaded and sent to Telegram successfully:<br>';
        $uploadMessage .= 'File ID: ' . $fileId . '<br>';
        $uploadMessage .= 'File Name: ' . $fileName . '<br>';
        $uploadMessage .= 'Telegram File URL: <a href="' . $telegramFileUrl . '">Download File from Telegram</a><br>';
        $uploadMessage .= '<a href="' . $uploadfile . '">Download Local File</a>';

        // Insert file details into the database
        $fileSize = filesize($uploadfile);
        $fileType = mime_content_type($uploadfile);

        $sql = "INSERT INTO files (file_name, author_name, file_size, file_type, topic_id, full_name) 
                VALUES ('$fileName', '$authorName', $fileSize, '$fileType', $topicId, '$fullName')";

        if ($conn->query($sql) === TRUE) {
            // File details inserted into the database successfully
            $dir = "upload/";
            foreach (glob($dir . "*") as $file) {
                if (time() - filectime($file) > 1) {
                    unlink($file);
                }
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $uploadMessage = 'Error uploading the file.';
    }
}

// Fetch files from the database based on topic_id
$sql = "SELECT * FROM files WHERE topic_id = $topicId";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>File Upload and Telegram Integration</title>

</head>

<body>

<main class="container mt-3" >
    <div style="text-align:center; color:#012970"><br>
    <h3> Upload Files </h3><hr>            <div class="text-right mt-2">
                <a href="index.php" class="btn btn-primary">Back to Homepage</a>
            </div>
 </div>
    <div class="row">
        <div class="col-md-12 col-lg-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Upload</h5>

                    <!-- Form -->
                    <form enctype="multipart/form-data" method="post"
                        action="main.php?q=UploadFile&topic_id=<?php echo $topicId; ?>">
                        <div class="form-group">
                            <label for="file">Select File:</label>
                            <input type="file" class="form-control" id="file" name="document" required>
                        </div>
                        <div class="form-group">
                            <label for="authorName">Author Name:</label>
                            <input type="text" class="form-control" id="authorName" name="authorName" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload File</button>
                    </form><!-- End Form -->

                    <?php echo $uploadMessage; ?>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-8">

            <div class="table-responsive mt-3">
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>File Name</th>
                            <th>Author Name</th>
                            <th>Uploaded By</th>
                            <th>File Size</th>
                            <th>File Type</th>
                        
                            <th>Delete</th> <!-- New column for delete button -->
                        </tr>
                    </thead>
                    <tbody>
<?php
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row["id"] . "</td>";
    echo "<td>" . $row["file_name"] . "</td>";
    echo "<td>" . $row["author_name"] . "</td>";
    echo "<td>" . $row["full_name"] . "</td>";
    echo "<td>" . $row["file_size"] . " bytes</td>";
    echo "<td>" . $row["file_type"] . "</td>";


    // Download button
    echo "<td><a href='download.php?file_path=";
    echo "<td><a href='main.php?q=UploadFile&topic_id=$topicId&delete_id=" . $row["id"] . "' class='btn btn-danger'>Delete</a></td>"; // Delete button
    echo "</tr>";
}
?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

</body>

</html>
