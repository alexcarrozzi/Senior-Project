<?php
//Google Libraries
require_once 'google-api-php-client/src/Google/Client.php';
require_once 'google-api-php-client/src/Google/Service/Calendar.php';

const CLIENT_ID = '191668664245-h1t5dbipvmglh09mc27bo3ckdfjjojqk.apps.googleusercontent.com';
const SERVICE_ACCOUNT_NAME = '191668664245-h1t5dbipvmglh09mc27bo3ckdfjjojqk@developer.gserviceaccount.com';
const KEY_FILE = 'ScheduleIt-2b0035283339.p12';


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
$service = new Google_Service_Calendar($client);
$calendarListEntry = $service->calendarList->get('9oggohktmvu3ckuug6mlmmth28@group.calendar.google.com');
$events = $service->events->listEvents('9oggohktmvu3ckuug6mlmmth28@group.calendar.google.com');
echo 'Calendar Summary: '.htmlspecialchars($calendarListEntry->getSummary()).'<br/><hr/>';

//Event Manager Set Up
$manager = new Google_Event_Manager($service);


?>