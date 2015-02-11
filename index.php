<?php
$type = 2;

/*ini_set('display_errors', 1);
session_start();
//unset($_SESSION);

//This is a test line

require_once 'google-api-php-client/src/Google/Client.php';
require_once 'google-api-php-client/src/Google/Service/Calendar.php';

const CLIENT_ID = '191668664245-h1t5dbipvmglh09mc27bo3ckdfjjojqk.apps.googleusercontent.com';
const SERVICE_ACCOUNT_NAME = '191668664245-h1t5dbipvmglh09mc27bo3ckdfjjojqk@developer.gserviceaccount.com';
const KEY_FILE = 'ScheduleIt-2b0035283339.p12';

if($type==1){
//SERVICE SET UP

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
//EXECUTION
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
}
//END SERVICE SET UP

}else{


//OTHER SET UP
require_once 'google-api-php-client/autoload.php';

$client_id = '191668664245-216ovjoman2vfe5g7e6fepnsscp0bj4q.apps.googleusercontent.com';
$client_secret = 'J6iNZeLn_iRxxYv1B07jCeTa';
$redirect_uri = 'http://localhost/Senior-Project/';
$client2 = new Google_Client();
$client2->setClientId($client_id);
$client2->setClientSecret($client_secret);
$client2->setRedirectUri($redirect_uri);
$client2->setScopes('https://www.googleapis.com/auth/calendar');

if (isset($_REQUEST['logout'])) {
  unset($_SESSION['access_token']);
}

if (isset($_GET['code'])) {
  $client2->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client2->getAccessToken();
  $redirect2 = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect2, FILTER_SANITIZE_URL));
}
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client2->setAccessToken($_SESSION['access_token']);
} else {
  $authUrl2 = $client2->createAuthUrl();
}

if ($client2->getAccessToken()) {
  $_SESSION['access_token'] = $client2->getAccessToken();
  $token_data = $client2->verifyIdToken()->getAttributes();
}
?>
<div class="box">
  <div class="request">
<?php
if (isset($authUrl2)) {
  echo "<a class='login' href='" . $authUrl2 . "'>Connect Me!</a>";
} else {
  echo "<a class='logout' href='?logout'>Logout</a>";
}

//EXECUTION
try{
    $service = new Google_Service_Calendar($client2);
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
}
//END OTHER
}
?>
}*/
echo "ScheduleIt"
?>