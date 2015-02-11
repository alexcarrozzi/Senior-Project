<?php
/*ini_set('display_errors', 1);
session_start();
//unset($_SESSION);

//This is a test line

require_once 'google-api-php-client/src/Google/Client.php';
require_once 'google-api-php-client/src/Google/Service/Calendar.php';


const CLIENT_ID = '191668664245-h1t5dbipvmglh09mc27bo3ckdfjjojqk.apps.googleusercontent.com';
const SERVICE_ACCOUNT_NAME = '191668664245-h1t5dbipvmglh09mc27bo3ckdfjjojqk@developer.gserviceaccount.com';
const KEY_FILE = 'ScheduleIt-2b0035283339.p12';

$client = new Google_Client();
$client->setClientId(CLIENT_ID);
$client->setApplicationName("ScheduleIt");
$client->setAccessType('offline');
$client->setRedirectUri('http://localhost/Senior-Project/');
$client->setScopes('https://www.googleapis.com/auth/calendar');

if (isset($_SESSION['token'])) {
 $client->setAccessToken($_SESSION['token']);
}

$key = file_get_contents(KEY_FILE);

if (isset($_GET['code'])){
    $resp = $client->authenticate($_GET['code']);
    $_SESSION['upload_token'] = $client->getAccessToken();
    $array = get_object_vars(json_decode($resp));
    $refreshToken = $array['refreshToken'];
    if($client->isAccessTokenExpired()){
        $client->refreshToken($refreshToken);
    }
    $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}


if (isset($_SESSION['upload_token']) && $_SESSION['upload_token']){
  $client->setAccessToken($_SESSION['upload_token']);
  if ($client->isAccessTokenExpired()){
    $client->refreshToken($refreshToken);
    unset($_SESSION['upload_token']);
  }
}else{
  $authUrl = $client->createAuthUrl();
}


if (isset($_SESSION['token'])){
    $client->setAccessToken($_SESSION['token']);
    //echo $_SESSION['token']; 
} else {
    $client->setAssertionCredentials(new Google_Auth_AssertionCredentials(
        SERVICE_ACCOUNT_NAME,
        array('https://www.googleapis.com/auth/calendar'),
        $key,
        'notasecret',
        'http://oauth.net/grant_type/jwt/1.0/bearer')
    );  
}

try{
    $service = new Google_Service_Calendar($client);
    $calendarList = $service->calendarList->listCalendarList();
    echo "<pre>";
    print_r($calendarList);
    echo "</pre>";
    
    while(true) {
      foreach ($calendarList->getItems() as $calendarListEntry) {
        echo $calendarListEntry->getSummary();
      }
      $pageToken = $calendarList->getNextPageToken();
      if ($pageToken) {
        $optParams = array('pageToken' => $pageToken);
        $calendarList = $service->calendarList->listCalendarList($optParams);
      } else {
        break;
      }
    }
        
    
}catch(Exception $e){
    echo $e->getMessage();
}*/
echo "ScheduleIt"
?>
