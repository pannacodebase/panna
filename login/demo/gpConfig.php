<?php
session_start();

//Include Google client library 
include_once 'src/Google_Client.php';
include_once 'src/contrib/Google_Oauth2Service.php';

/*
 * Configuration and setup Google API
 */
$clientId = '718306979027-ope39ju08l8sv04mhq3r815d73pci0sn.apps.googleusercontent.com'; //Google client ID
$clientSecret = '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'; //Google client secret
$redirectURL = 'https://autism.x10.mx/main.php'; //Callback URL

//Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('testapp');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectURL);

$google_oauthV2 = new Google_Oauth2Service($gClient);
?>
