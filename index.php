<?php
$type = 1;

ini_set('display_errors', 1);
session_start();
//unset($_SESSION);

//My Libraries
require_once 'utilities/segment_list.php';

//Google Libraries
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
    $calendarListEntry = $service->calendarList->get('9oggohktmvu3ckuug6mlmmth28@group.calendar.google.com');

    echo 'Calendar Summary: '.htmlspecialchars($calendarListEntry->getSummary()).'<br/><hr/>';
    
    $events = $service->events->listEvents('9oggohktmvu3ckuug6mlmmth28@group.calendar.google.com');

    $count =1;  
    while(true) {
      foreach ($events->getItems() as $event) {
        $my_segments = new segment_list(fmt_gdate($event->getStart()),fmt_gdate($event->getEnd()));  
        echo "<strong>Event {$count}</strong>:<br/>";
        echo 'Event Name: '.htmlspecialchars($event->getSummary()).'<br/>';
        echo 'Event Updated Time: '.htmlspecialchars($event->getUpdated()).'<br/>';
        echo 'Event Description: '.htmlspecialchars($event->getDescription()).'<br/>';
        echo 'Event ID: '.htmlspecialchars($event->getId()).'<br/>';
        echo 'Block Time: '.htmlspecialchars(date('D F n\, Y',fmt_gdate($event->getStart()))).' '.htmlspecialchars(date('g:i',fmt_gdate($event->getStart()))).' &ndash; '.htmlspecialchars(date('g:i',fmt_gdate($event->getEnd()))).'<br/>';
        $segs = $my_segments->getList();
        $i=0;
            foreach($segs as $segment){
                $i++;
                echo "Slot $i: ".date('D F n\, Y',$segment[0]).' <strong>'.date('g:i',$segment[0]).' &ndash; '.date('g:i',$segment[1]).'</strong><br/>';
            }
        $count++;
        echo '<hr/>';
      }
      $pageToken = $events->getNextPageToken();
      if ($pageToken) {
        $optParams = array('pageToken' => $pageToken);
        //$events = $service->events->listEvents('9oggohktmvu3ckuug6mlmmth28@group.calendar.google.com', $optParams);
        
      } else {
        break;
      }
    }
    
}catch(Exception $e){
    echo $e->getMessage();
}

if(isset($_REQUEST['fullname'])){
    $name = $_REQUEST['fullname'];
    $email = $_REQUEST['email'];
    $id = $_REQUEST['eventId'];
    if($name == ''){
        echo '<p>Enter your full name</p>';
    }elseif($email==''){
        echo '<p>Enter your email</p>';
    }else{
        $service = new Google_Service_Calendar($client);
        $event = $service->events->get('9oggohktmvu3ckuug6mlmmth28@group.calendar.google.com', $id);
        $event->setDescription("Student: {$name}\nEmail: {$email}");
        $updatedEvent = $service->events->update('9oggohktmvu3ckuug6mlmmth28@group.calendar.google.com',$id, $event);
        header('Location: .');
    }
}


//END SERVICE SET UP

}else{
/*

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
//END OTHER*/
}

function fmt_gdate($gdate) {
  if ($val = $gdate->getDateTime()) {
    $date = new DateTime($val);
    return ($date->format('U')); //'D\, F n Y g:i' 
  } else if ($val = $gdate->getDate()) {
    $date = new DateTime($val);
    return ($date->format( 'd/m/Y' )). ' (all day)';
  }
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>ScheduleIt Home</title>
</head>
<body>
    <?php
        $service = new Google_Service_Calendar($client);        
        $events = $service->events->listEvents('9oggohktmvu3ckuug6mlmmth28@group.calendar.google.com');
    ?>  

    <form action="." method="POST" name="UpdateEventForm">
        <?php foreach($events->getItems() as $event):?>
        Update Event &ndash; <?= $event->getId(); ?>
        <input type="radio" name="eventId" value="<?=$event->getId();?>"/><br/>
        <?php endforeach; ?>
        <br/>
        <strong>Signup for a time</strong><br/>
        Name: <input type="input" name="fullname"/><br/>
        Email: <input type="input" name="email"/><br/>
        <input type="submit" value="Update Event"/>
    </form>
</body>
</html>