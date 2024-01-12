<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
    <style>
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
            font-size: 14px;
        }

        th {
            background-color: #013289;
            color: white;
        }
    </style>
</head>

<body>

    <?php
    // Database connection
    $servername = "localhost";
    $username = "rgdhicgm_app";
    $password = "app123";
    $dbname = "rgdhicgm_app";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Handle role update
        if (isset($_POST['userId']) && isset($_POST['role'])) {
            $userId = $_POST['userId'];
            $role = $_POST['role'];

            // Update the user role in the database
            $updateSql = "UPDATE users SET role = '$role' WHERE id = $userId";
            $conn->query($updateSql);
            exit; // End the script to prevent rendering the HTML below
        }
    }

    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    ?>
    <div class="container mt-3">
        <h2 id="dg" style="color:#013289;margin-left:0px;text-align:center"> User Information </h2>
<hr>

        <table id="example" class="display responsive nowrap">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Picture</th>
                    <th>Created</th>
                    <th>Modified</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["first_name"] . "</td>";
                        echo "<td>" . $row["last_name"] . "</td>";
                        echo "<td><span class='email-mask' data-email='" . $row["email"] . "'>**********</span></td>";
                        echo "<td><img src='" . $row["picture"] . "' width=30px/></td>";
                        echo "<td>" . $row["created"] . "</td>";
                        echo "<td>" . $row["modified"] . "</td>";
                        echo "<td>
                        <select class='role-selector' data-userid='" . $row["id"] . "'>
                            <option value='user' " . ($row["role"] == 'user' ? 'selected' : '') . ">User</option>
                            <option value='influencer' " . ($row["role"] == 'influencer' ? 'selected' : '') . ">Influencer</option>
                            <option value='admin' " . ($row["role"] == 'admin' ? 'selected' : '') . ">Admin</option>
                        </select>
                      </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const emailMasks = document.querySelectorAll('.email-mask');
            emailMasks.forEach(emailMask => {
                emailMask.addEventListener('click', function () {
                    this.textContent = this.dataset.email;
                });
            });

            const roleSelectors = document.querySelectorAll('.role-selector');
            roleSelectors.forEach(roleSelector => {
                roleSelector.addEventListener('change', function () {
                    const userId = this.dataset.userid;
                    const selectedRole = this.value;

                    // Send data to the server using AJAX
                    $.ajax({
                        type: 'POST',
                        url: '',
                        data: { userId: userId, role: selectedRole },
                        success: function (response) {
                            alert("Record Saved Successfully"); // Log the response for debugging
                        },
                        error: function (xhr, status, error) {
                            console.error(error); // Log any errors in the console
                        }
                    });
                });
            });

            $('#example').DataTable({
                "paging": true,
                "searching": false,
                "info": false,
                "pageLength": 10
            });
        });
    </script>
</body>

</html>