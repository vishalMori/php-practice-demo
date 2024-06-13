<?php
require "../vendor/autoload.php";

//Client ID and Secret
$clientId = " "; // Client ID
$clientSecret = " "; // ClintSecret

$client = new Google\Client();
$client->setClientId($clientId);
$client->setClientSecret($clientSecret);

$redirectURI = "http://localhost/mywork/demoWebsite/Middleware/googleLogin.php";
$client->setRedirectUri($redirectURI);
$client->addScope("email");
$client->addScope("profile");
