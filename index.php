<?php
ini_set('display_errors', 1);
session_start();
//unset($_SESSION);

require_once 'google-api-php-client/src/Google/Client.php';
require_once 'google-api-php-client/src/Google/Service/Calendar.php';


const CLIENT_ID = '191668664245-h1t5dbipvmglh09mc27bo3ckdfjjojqk.apps.googleusercontent.com';
const SERVICE_ACCOUNT_NAME = '191668664245-h1t5dbipvmglh09mc27bo3ckdfjjojqk@developer.gserviceaccount.com';
const MY_EMAIL  = 'senior.project705@gmail.com';
const KEY_FILE = 'ScheduleIt-2b0035283339.p12';

$client = new Google_Client();
$client->setClientId(CLIENT_ID);
$client->setApplicationName("ScheduleIt");
$client->setAccessType('offline');
//$client->setRedirectUri('http://localhost/Senior-Project/');
//$client->setScopes('https://www.googleapis.com/auth/calendar');

if (isset($_SESSION['token'])) {
 $client->setAccessToken($_SESSION['token']);
}

$key = file_get_contents(KEY_FILE);

if (isset($_SESSION['token'])){
    $client->setAccessToken($_SESSION['token']);
    echo $_SESSION['token']; 
} else {
    $client->setAssertionCredentials(new Google_AssertionCredentials(
        SERVICE_ACCOUNT_NAME,
        array('https://www.googleapis.com/auth/calendar'),
        $key,
        'notasecret',
        'http://oauth.net/grant_type/jwt/1.0/bearer',
        MY_EMAIL)
    );  
}

    $calendar = new Google_Service_Calendar($client);
    //OAuth error here
    echo $calendar->calendarList->listCalendarList();
    //echo $service->calendarList->listCalendarList($optParams);

?>

<?php /*
/*
 * Copyright 2011 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.

include_once "google-api-php-client/examples/templates/base.php";
session_start();

//unset($_SESSION);
require_once 'google-api-php-client/autoload.php';



$client_id = '191668664245-2elcebkqrt3bve8eoj0jq7vfqn1istkt.apps.googleusercontent.com';
$client_secret = 'zei3HaZw1grmgYRRj_LGTDSj';
$redirect_uri = 'http://localhost/Senior-Project/';

$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->setScopes('https://www.googleapis.com/auth/calendar');


if (isset($_REQUEST['logout'])) {
  unset($_SESSION['access_token']);
}


if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}


if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
} else {
  $authUrl = $client->createAuthUrl();
}


if ($client->getAccessToken()) {
  $_SESSION['access_token'] = $client->getAccessToken();
  $token_data = $client->verifyIdToken()->getAttributes();
}

echo pageHeader("Authenticate");
?>
<div class="box">
  <div class="request">
<?php
if (isset($authUrl)) {
  echo "<a class='login' href='" . $authUrl . "'>Connect Me!</a>";
} else {
  echo "<a class='logout' href='?logout'>Logout</a>";
}
?>
  </div>

  <div class="data">
<?php 
if (isset($token_data)) {
  var_dump($token_data);
}
?>gdsggdseges*/