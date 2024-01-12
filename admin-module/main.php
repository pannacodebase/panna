<?php

// Include GP config file && User class
include_once 'login/demo/gpConfig.php';
include_once 'login/demo/User.php';

if (isset($_GET['code'])) {
    $gClient->authenticate($_GET['code']);
    $_SESSION['token'] = $gClient->getAccessToken();
    header('Location: ' . filter_var($redirectURL, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) {
    $gClient->setAccessToken($_SESSION['token']);
}

if ($gClient->getAccessToken()) {
    // Get user profile data from Google
    $gpUserProfile = $google_oauthV2->userinfo->get();

    // Initialize User class
    $user = new User();

    // Insert or update user data to the database
    $gpUserData = array(
        'oauth_provider' => 'google',
        'oauth_uid' => $gpUserProfile['id'],
        'first_name' => $gpUserProfile['given_name'],
        'last_name' => $gpUserProfile['family_name'],
        'email' => $gpUserProfile['email'],
        'locale' => $gpUserProfile['locale'],
        'picture' => $gpUserProfile['picture'],
    );
    $userData = $user->checkUser($gpUserData);

    $_SESSION['userData'] = $userData;
}

// Retrieve user data from the session
$userData = isset($_SESSION['userData']) ? $_SESSION['userData'] : array();

// Check if the user is logged in
if (!empty($userData)) {
    $userName = $userData['first_name'] . ' ' . $userData['last_name'];
    $userPhoto = $userData['picture'];
    $oauthUid = $userData['id'];
    $servername = "localhost";
    $username = "rgdhicgm_app";
    $password = "app123";
    $dbname = "rgdhicgm_app";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT role FROM users WHERE id = '$oauthUid'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userRole = $row['role'];
        $_SESSION['userRole'] = $userRole;
        $userRole = $_SESSION['userRole'];
    }

    $logoutUrl = 'login/demo/logout.php';
} else {
    $userName = 'Not Logged In';
    $userPhoto = 'Not Logged In';
    $logoutUrl = 'index.php'; // You can customize the logout URL if needed
    header('Location: index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Paññā</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top">
        <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

            <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="logo d-flex align-items-center">
                <img src="assets/img/logo.png" alt="">
                <span>Paññā</span>
            </a>
            <?php include('left_card.php'); ?>

        </div>
    </header><!-- End Header -->


    <main id="main">

        <!-- ======= Breadcrumbs ======= -->
        <section class="breadcrumbs">

            <div class="container" style="text-color:white">
                <h2 id="h2h" style="font-weight: normal;">Welcome
                    <?= $userName ?>
                </h2>
            </div>
        </section><!-- End Breadcrumbs -->

        <section class="inner-page">
            <div class="container" style="margin-top: -5%;">
                <p>
                    <?php
                    // Check if the "q" parameter is set in the URL
                    if (isset($_GET['q'])) {
                        $q = $_GET['q'];

                        // Determine the file to include based on the "q" parameter
                        switch ($q) {
                            case 'EditData':
                                include 'setup/data/edit.php';
                                break;
                            case 'UploadFile':
                                include 'setup/data/upload.php';
                                break;
                            case 'setup-data':
                                include 'setup/data/index.php';
                                break;
                                case 'api-keys':
                                    include 'setup/api-keys/index.php';
                                    break;
                                case 'admin-users':
                                include 'admin/users/index.php';
                                break;
                                case 'user-info':
                                    include 'user-info/index.php';
                                    break;
                            default:
                                include 'setup/data/index.php';
                                break;
                        }
                    } else {
                        // "q" parameter not set, include the default file
                        include 'setup/data/index.php';
                    }
                    ?>
                </p>
            </div>
        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">

        <div class="footer-top">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-5 col-md-12 footer-info">
               
                            <span>Paññā</span>
                        </a>
                        <p>Paññā revolutionizes support for Autistic individuals and caregivers with an innovative
                            chatbot. Our mission is to create a secure space for Autistic voices, parents, and
                            caregivers to exchange information, learn, and engage. Paññā aims to be the premier
                            platform, fostering safety, empowerment, and a new world of expression for Autistic
                            individuals. Our chatbot addresses queries, providing a supportive environment for
                            caregivers and the entire autism community.
                        </p>
                    </div>


                </div>
            </div>
        </div>

        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span>Paññā</span></strong>. All Rights Reserved
            </div>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>



</html>