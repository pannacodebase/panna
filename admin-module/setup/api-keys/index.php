<?php
$host = "localhost";
$username = "rgdhicgm_app";
$password = "app123";
$database = "rgdhicgm_app";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["save"])) {
        // Save new record
        $type = $_POST["type"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $apiKey = $_POST["apiKey"];
        $userName = $_POST["userName"];
        $userId = $_POST["userId"];
        $domain = $_POST["domain"];
        $usageCount = $_POST["usageCount"];
        $limit = $_POST["limit"];
        $comments = $_POST["comments"];

        $sql = "INSERT INTO api_keys_config (type, email, password, apiKey, userName, userId, domain, usage_count, `limit`, comments) VALUES ('$type', '$email', '$password', '$apiKey', '$userName', '$userId', '$domain', $usageCount, $limit, '$comments')";

        if (mysqli_query($conn, $sql)) {
            echo "Record added successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } elseif (isset($_POST["delete"])) {
        // Delete a record
        $idToDelete = $_POST["delete"];

        $deleteSql = "DELETE FROM api_keys_config WHERE id = $idToDelete";

        if (mysqli_query($conn, $deleteSql)) {
            echo "Record deleted successfully.";
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Keys Configuration</title>
    <style>
        /* Add the provided styles for table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 14px; /* Smaller font size */
        }

        th {
            background-color: #013289; /* Header background color */
            color: white; /* Header foreground color */
        }

        /* Improve form layout */
        form {
            max-width: 400px;
            margin: auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #013289;
            color: white;
            cursor: pointer;
        }

        /* Make the table scrollable */
        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        /* Set a fixed height for the table */
        #apiKeysTable {
            min-width: 100%; /* Ensure the table takes up the full width */
            max-width: 100%;
            overflow-y: auto; /* Enable vertical scrolling */
            height: 300px; /* Set your desired height */
        }
    </style>

    <!-- Include DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
</head>

<body>
    <main id="main">
        <h2 id="dg" style="color:#013289;margin-left:0px;text-align:center"> Enter API Keys </h2>
        <hr>

        <section class="inner-page">
            <div class="container">
                <!-- Step 1: Data Gathering Form -->
                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                    <label for="type">Type:</label>
                    <select id="type" name="type" required>
                        <option value="llm">LLM</option>
                        <option value="url_gen_service">URL Gen Service</option>
                        <option value="vector_database">Vector Database</option>
                        <option value="website">Website</option> <!-- Changed value to 'website' -->
                    </select><br>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required><br>

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required><br>

                    <label for="apiKey">API Key:</label>
                    <input type="text" id="apiKey" name="apiKey" required><br>

                    <label for="userName">Application Name:</label> <!-- Changed label to "Application Name" -->
                    <input type="text" id="userName" name="userName" required><br>

                    <label for="userId">User ID:</label>
                    <input type="text" id="userId" name="userId" required><br>

                    <label for="domain">Domain:</label>
                    <input type="text" id="domain" name="domain" required><br>

                    <label for="usageCount">Usage Count:</label>
                    <input type="number" id="usageCount" name="usageCount" required><br>

                    <label for="limit">Limit:</label>
                    <input type="number" id="limit" name="limit" required><br>

                    <label for="comments">Comments:</label>
                    <textarea id="comments" name="comments" rows="4" cols="50"></textarea><br>

                    <input type="submit" name="save" value="Save">
                </form>

                <!-- Step 2: DataTable for Displaying Saved Records -->
                <h2>Saved API Keys Configuration</h2>
                <table id="apiKeysTable">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>API Key</th>
                            <th>Application Name</th>
                            <th>User ID</th>
                            <th>Domain</th>
                            <th>Usage Count</th>
                            <th>Limit</th>
                            <th>Comments</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = mysqli_query($conn, "SELECT * FROM api_keys_config");
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['type'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['password'] . "</td>";
                            echo "<td>" . $row['apiKey'] . "</td>";
                            echo "<td>" . $row['userName'] . "</td>";
                            echo "<td>" . $row['userId'] . "</td>";
                            echo "<td>" . $row['domain'] . "</td>";
                            echo "<td>" . $row['usage_count'] . "</td>";
                            echo "<td>" . $row['limit'] . "</td>";
                            echo "<td>" . $row['comments'] . "</td>";
                            echo "<td><form method='post' action='" . $_SERVER["PHP_SELF"] . "'><button type='submit' name='delete' value='" . $row['id'] . "'>Delete</button></form></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>

    </main>
    <!-- Include jQuery and DataTables script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <!-- Initialize DataTable for the table -->
    <script>
        $(document).ready(function () {
            $('#apiKeysTable').DataTable();
        });
    </script>

</body>

</html>