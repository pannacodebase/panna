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
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Keys Configuration</title>
</head>
<body>
<main id="main">

<!-- ======= Breadcrumbs ======= -->
<section class="breadcrumbs">
  <div class="container">

    <ol>
      <li><a href="index.html">Home</a></li>
      <li>Inner Page</li>
    </ol>
    <h2>Inner Page</h2>

  </div>
</section><!-- End Breadcrumbs -->

<section class="inner-page">
  <div class="container">

<h2>Enter API Keys Configuration</h2>

<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
    <label for="type">Type:</label>
    <select id="type" name="type" required>
        <option value="llm">LLM</option>
        <option value="url_gen_service">URL Gen Service</option>
        <option value="vector_database">Vector Database</option>
        <option value="vector_database">Website</option>
    </select><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>

    <label for="apiKey">API Key:</label>
    <input type="text" id="apiKey" name="apiKey" required><br>

    <label for="userName">User Name:</label>
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

<h2>Saved API Keys Configuration</h2>

<?php
$result = mysqli_query($conn, "SELECT * FROM api_keys_config");
echo "<table border='1'>
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
</tr>";

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

echo "</table>";

mysqli_close($conn);
?>
      </div>
    </section>

  </main><!-- End #main -->

</body>
</html>
