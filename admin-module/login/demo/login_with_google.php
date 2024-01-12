<?php
// Set the error reporting level to E_ALL
error_reporting(E_ALL);

// Set the display errors directive to On
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Include GP config file && User class
include_once 'gpConfig.php';
include_once 'User.php';

// Check if the 'code' parameter is set in the URL (after user authentication)
if(isset($_GET['code'])){
    $gClient->authenticate($_GET['code']);
    $_SESSION['token'] = $gClient->getAccessToken();
    header('Location: ' . filter_var($redirectURL, FILTER_SANITIZE_URL));
}

// If the session token is set, set it in the Google client
if (isset($_SESSION['token'])) {
    $gClient->setAccessToken($_SESSION['token']);
}

// If the Google client has access token
if ($gClient->getAccessToken()) {
    // Get user profile data from Google
    $gpUserProfile = $google_oauthV2->userinfo->get();

    // Initialize User class
    $user = new User();

    // Insert or update user data in the database
    $gpUserData = array(
        'oauth_provider'=> 'google',
        'oauth_uid'     => $gpUserProfile['id'],
        'first_name'    => $gpUserProfile['given_name'],
        'last_name'     => $gpUserProfile['family_name'],
        'email'         => $gpUserProfile['email'],
        'locale'        => $gpUserProfile['locale'],
        'picture'       => $gpUserProfile['picture'],
    );
    $userData = $user->checkUser($gpUserData);

    // Storing user data into the session
    $_SESSION['userData'] = $userData;

    // Redirect to the homepage or profile page after successful login
    header('Location: index.php');
} else {
    // If the Google client doesn't have access token, generate authentication URL
    $authUrl = $gClient->createAuthUrl();
    $output = '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'"><img src="images/glogin.png" alt=""/></a>';
}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Login with Google using PHP by CodexWorld</title>
    <style type="text/css">
        h1{font-family:Arial, Helvetica, sans-serif;color:#999999;}
    </style>
</head>
<body>
    <div><?php echo $output; ?></div>
</body>
</html>
