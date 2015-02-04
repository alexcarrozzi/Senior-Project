<?php
// If you've used composer to include the library, remove the following line
// and make sure to follow the standard composer autoloading.
// https://getcomposer.org/doc/01-basic-usage.md#autoloading
require_once 'google-api-php-client/autoload.php';

$client = new Google_Client();
// OAuth2 client ID and secret can be found in the Google Developers Console.
$client->setClientId('191668664245-2elcebkqrt3bve8eoj0jq7vfqn1istkt.apps.googleusercontent.com');
$client->setClientSecret('2jGQmUbYVHbZyAeS-l0gbb10');
$client->setRedirectUri('https://127.0.0.1/oauth2callback');
$client->addScope('https://www.googleapis.com/auth/calendar');

$service = new Google_Service_Calendar($client);

$authUrl = $client->createAuthUrl();

//Request authorization
echo "Please visit:\n$authUrl\n\n";
echo "Please enter the auth code:\n";
$authCode = trim(fgets(STDIN));

// Exchange authorization code for access token
$accessToken = $client->authenticate($authCode);
$client->setAccessToken($accessToken);

?>