<?php
/*  
 * All code - unless expressly stated otherwise - in the following file was originally designed and implemented 
 * by Alex Connor Carrozzi for a Senior Project for the 2014-2015 academic year
 * The University of New Hampshire Computer Science Department owns and
 * is responsible for all functionality contained in the web application
 * ScheduleIt
 *
 * google_api_init.php
 * This file is responsible for initializing ScheduleIt's connection with
 * Google's Calendar API. A service account has been set up to act as and
 * intermediary to make and manage API calls between the user and Google.
 * It is imperative that advisors share their advising calendars with this
 * account in order for the application to function. 
 */
    
    
     $prod = 1;
     $sp = $prod==0?"Senior-Project/":"";     
//Google Libraries
require_once $_SERVER['DOCUMENT_ROOT']."/{$sp}google-api-php-client/src/Google/Client.php";
require_once $_SERVER['DOCUMENT_ROOT']."/{$sp}google-api-php-client/src/Google/Service/Calendar.php";
require_once $_SERVER['DOCUMENT_ROOT']."/{$sp}utilities/google_event_manager.php";
require_once $_SERVER['DOCUMENT_ROOT']."/{$sp}utilities/logger.php";

const CLIENT_ID = '191668664245-h1t5dbipvmglh09mc27bo3ckdfjjojqk.apps.googleusercontent.com';
const SERVICE_ACCOUNT_NAME = '191668664245-h1t5dbipvmglh09mc27bo3ckdfjjojqk@developer.gserviceaccount.com';

$KEY_FILE = $_SERVER['DOCUMENT_ROOT']."/{$sp}ScheduleIt-2b0035283339.p12";


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

$key = file_get_contents($KEY_FILE);

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

//Event Manager Set Up
$manager = new Google_Event_Manager($service);

?>