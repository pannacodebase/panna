<style>
    .loading-spinner {
        border: 4px solid rgba(0, 0, 0, 0.3);
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'header.php';
include 'telegramapi/Telegram.php';

$TOKEN = '5664649711:AAGYh69g5bvzIFErXyJxGPXIx-2n4ZKn75o';
$chat_id = '5094418997';
$uploadMessage = '';
$showFiles = false;

// Function to download file from Telegram based on file_id
function downloadTelegramFile($file_id, $TOKEN)
{
    $url = "https://api.telegram.org/bot$TOKEN/getFile?file_id=$file_id";
    $response = file_get_contents($url);
    $json = json_decode($response, true);

    if ($json['ok'] && isset($json['result']['file_path'])) {
        $file_path = $json['result']['file_path'];
        $download_url = "https://api.telegram.org/file/bot$TOKEN/$file_path";

        // Redirect to the download URL
        header("Location: $download_url");
        exit;
    } else {
        // Handle error, file not found, or other issues
        echo 'Error downloading the file from Telegram.';
        exit;
    }
}
function isFileNameExists($fileName)
{
    global $dbConn;

    $sql = "SELECT COUNT(*) as count FROM tbl_files WHERE file_name = '$fileName'";
    $result = mysqli_query($dbConn, $sql);
    $row = mysqli_fetch_assoc($result);

    return $row['count'] > 0;
}

// Function to get file type based on the file extension
function getFileType($fileName)
{
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    switch ($fileExtension) {
        case 'pdf':
            return 'Document (PDF)';
        case 'doc':
        case 'docx':
            return 'Document (Word)';
        case 'ppt':
        case 'pptx':
            return 'Document (PowerPoint)';
        case 'csv':
        case 'xls':
        case 'xlsx':
            return 'Excel File';
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif':
            return 'Image';
        case 'mp3':
            return 'Audio';
        case 'mp4':
        case 'avi':
        case 'mov':
        case 'mkv':
            return 'Video';
        default:
            return 'Unknown';
    }
}

// Function to store file details in the database
function insertFileDetails($cid, $file_id, $authorName, $fileType, $fileSize, $fileDescription, $fileName)
{
    global $dbConn;
    $sql = "INSERT INTO tbl_files (cid, file_id, author_name, content_type, file_size, file_description, file_name) 
            VALUES ('$cid', '$file_id', '$authorName', '$fileType', '$fileSize', '$fileDescription', '$fileName')";

    if (mysqli_query($dbConn, $sql)) {
        return true;
    } else {
        return false;
    }
}
// Handle file deletion
if (isset($_POST['delete']) && isset($_POST['delete_file_id'])) {
    $delete_file_id = $_POST['delete_file_id'];

    // Delete the record from the database
    $sql = "DELETE FROM tbl_files WHERE id = '$delete_file_id'";
    if (mysqli_query($dbConn, $sql)) {
        // Success: Refresh the page to show the updated file list
        header("Location: {$_SERVER['PHP_SELF']}");
        exit;
    } else {
        // Error handling if delete operation fails
        echo '<div class="alert alert-danger">Error deleting the file.</div>';
    }
}

if (isset($_GET['file_id']) && isset($_GET['download'])) {
    $file_id = $_GET['file_id'];
    downloadTelegramFile($file_id, $TOKEN);
}

if (isset($_FILES['document']) && isset($_POST['authorName'])) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);


    $name = $_FILES['document']['name'];
    $authorName = $_POST['authorName'];
    $fileDescription = $_POST['fileDescription'];
    $cid = $_SESSION['user_id'];

    if (isFileNameExists($name)) {
        $uploadMessage = 'Error: File with the same name already exists.';
        echo '<div class="alert alert-danger">' . $uploadMessage . '</div>';

    }

    // Check for file upload errors
    if ($_FILES['document']['error'] !== UPLOAD_ERR_OK) {
        $uploadMessage = 'Error uploading the file: ' . $_FILES['document']['error'];
        echo '<div class="alert alert-danger">' . $uploadMessage . '</div>';

    }

    // Check for allowed file size
    $fileSize = $_FILES['document']['size'];
    if ($fileSize > 49900000) {
        $uploadMessage = 'Error: File size must be less than 49.9 MB.';
        echo '<div class="alert alert-danger">' . $uploadMessage . '</div>';

    }


    $content_type = $_FILES['document']['type'];
    $fileType = getFileType($name);
    $telegram = new Telegram($TOKEN);
    $uploaddir = 'upload/';
    $uploadfile = $uploaddir . basename($name);

    // Move the uploaded file to the upload directory
    if (move_uploaded_file($_FILES['document']['tmp_name'], $uploadfile)) {
        $img = curl_file_create($uploadfile, $content_type);
        $content = array(
            'chat_id' => $chat_id,
            'document' => $img,
            'caption' => 'Uploaded by: ' . $authorName . "\nDescription: " . $fileDescription,
        );

        $val = $telegram->sendDocument($content);

        $json = json_decode(json_encode($val), true);
        $file_id = $json['result']['document']['file_id'];

        // Store the file details in the database
        if (insertFileDetails($cid, $file_id, $authorName, $fileType, $fileSize, $fileDescription, $name)) {
            $uploadMessage = 'File uploaded and sent to Telegram successfully:<br>';
        } else {
            $uploadMessage = 'Error uploading the file: ' . mysqli_error($dbConn);
            echo '<div class="alert alert-danger">' . $uploadMessage . '</div>';

        }

        $dir = "upload/";
        foreach (glob($dir . "*") as $file) {
            if (time() - filectime($file) > 80) {
                unlink($file);
            }
        }
    } else {
        $uploadMessage = 'Error uploading the file.';
    }
}

// Retrieve files from the database
$cid = $_SESSION['user_id'];
$sql = "SELECT id, file_id, author_name, content_type, file_size, file_description, file_name from tbl_files;";
$result = mysqli_query($dbConn, $sql);
$fileData = array();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $fileData[] = $row;
    }
    $showFiles = true;
}

mysqli_close($dbConn);
?>

<body>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>File Uploads</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Files</li>
                </ol>
            </nav>

            <section class="section">
                <div class="container">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-upload-tab" data-toggle="pill" href="#pills-upload"
                                role="tab" aria-controls="pills-upload" aria-selected="true">Upload File</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-view-tab" data-toggle="pill" href="#pills-view" role="tab"
                                aria-controls="pills-view" aria-selected="false">View Files</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-upload" role="tabpanel"
                            aria-labelledby="pills-upload-tab">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        </br>
                                        <div class="card-body">
                                            <h1>Upload File to Telegram</h1>
                                            <form enctype="multipart/form-data" method="post"
                                                action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                                <div class="form-group">
                                                    <label for="file">Select File:</label>
                                                    <input type="file" class="form-control" id="file" name="document"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="authorName">Author Name:</label>
                                                    <input type="text" class="form-control" id="authorName"
                                                        name="authorName" required>
                                                </div>

                                                <!-- Add the loading spinner -->
                                                <div class="loading-spinner" id="uploadSpinner" style="display: none;">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Upload and Send to
                                                    Telegram</button>
                                            </form>
                                            <?php if ($uploadMessage): ?>
                                                <div class="alert alert-danger">
                                                    <?php echo $uploadMessage; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-view" role="tabpanel" aria-labelledby="pills-view-tab">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        </br>
                                        <div class="card-body">
                                            <?php if ($showFiles): ?>
                                                <h1>File View</h1>
                                                <table id="fileTable" class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>File Name</th>

                                                            <th>Author Name</th>
                                                            <th>File Type</th>
                                                            <th>File Size</th>
                                                            <th>File Description</th>
                                                            <th>File Share</th>

                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($fileData as $fileRow): ?>
                                                            <tr>
                                                                <td>
                                                                    <?php echo $fileRow['id']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $fileRow['file_name']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $fileRow['author_name']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $fileRow['content_type']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $fileRow['file_size']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php echo $fileRow['file_description']; ?>
                                                                </td>

                                                                <td>
                                                                <button type="button" class="btn btn-success btn-sm share-btn" data-toggle="modal" data-target="#shareModal" data-file-id="<?php echo $fileRow['file_id']; ?>">Share</button>
                                                                </td>
                                                                <td>
                                                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>"
                                                                        method="get">
                                                                        <input type="hidden" name="file_id"
                                                                            value="<?php echo $fileRow['file_id']; ?>">
                                                                        <button type="submit" name="download"
                                                                            class="btn btn-primary btn-sm">Download</button>
                                                                    </form>
                                                                    <form onsubmit="return confirmDelete();" method="post">
                                                                        <input type="hidden" name="delete_file_id"
                                                                            value="<?php echo $fileRow['id']; ?>">
                                                                        <button type="submit" name="delete"
                                                                            class="btn btn-danger btn-sm">Delete</button>
                                                                    </form>


                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                                <div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareModalLabel">Share File URL</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Copy and share the file URL:</p>
                <input type="text" id="fileUrlInput" class="form-control" readonly>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

                                            <?php else: ?>
                                                <h1>File View</h1>
                                                <p>No files uploaded yet.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

    <script>
        $(document).ready(function () {
            $('#fileTable').DataTable();
                    // Handle the Share button click
        $('.share-btn').click(function () {
            var fileId = $(this).data('file-id');
            var fileUrl = "<?php echo 'https://api.telegram.org/file/bot5664649711:' . $_SERVER['PHP_SELF']; ?>?file_id=" + fileId + "&download=true";
            
            // Set the file URL in the input field
            $('#fileUrlInput').val(fileUrl);
        });

        // Clear the input field when the modal is closed
        $('#shareModal').on('hidden.bs.modal', function () {
            $('#fileUrlInput').val('');
        });

        });
    </script>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this file?");
        }

        // AJAX delete function
        $(document).ready(function () {
            $('form[action=""]').on('submit', function (event) {
                event.preventDefault();
                var formData = $(this).serialize();
                var formAction = $(this).attr('action');

                // Show the loading spinner during file upload
                $('#uploadSpinner').show();

                $.ajax({
                    url: formAction,
                    method: 'POST',
                    data: formData,
                    success: function (response) {
                        // Hide the loading spinner after successful upload
                        $('#uploadSpinner').hide();
                        // Refresh the table after successful deletion
                        window.location.reload();
                    },
                    error: function () {
                        // Hide the loading spinner if an error occurs
                        $('#uploadSpinner').hide();
                        alert('Error deleting the file.');
                    }
                });
            });
        });
    </script>

</body>

</html>