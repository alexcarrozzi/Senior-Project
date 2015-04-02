<?php
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
 */
require_once '../google-api-php-client/src/Google/Client.php';
require_once '../google-api-php-client/src/Google/Service/Calendar.php';
session_start();
$client = new Google_Client();
$client->setAccessType('offline'); 
$client->setApprovalPrompt('force');
$client->setApplicationName('ScheduleIt');
$client->setClientId('191668664245-k6apjlo3hojik7rphq9aet58hiu4pc26.apps.googleusercontent.com');
$client->setClientSecret('t86-1-Msaw9C7wuPKZ-dvLYK');
$client->setRedirectUri('http://scheduleit.cs.unh.edu:8080/d2098f349foijn49uginer');
$client->setScopes('https://www.googleapis.com/auth/calendar'); 
$plus = new Google_Service_Plus($client);
if (isset($_REQUEST['logout'])) {
  unset($_SESSION['access_token']);
}
if (isset($GET['code'])) {
  $client->authenticate($GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  //$_SESSION['refresh_token'] = $client()->getRefreshToken();
  header('Location: http://scheduleit.cs.unh.edu:8080/d2098f349foijn49uginer');
}
if (isset($_SESSION['access_token'])) {
  $client->setAccessToken($_SESSION['access_token']);
}

//$client->refreshToken($theRefreshTokenYouHadStored);

if ($client->getAccessToken()) {
    $service = new Google_Service_Calendar($client);
    
    $calendarList = $service->calendarList->listCalendarList();

      foreach ($calendarList->getItems() as $calendarListEntry) {
        echo $calendarListEntry->getSummary()." id=";
        echo $calendarListEntry->getId()."<br/>";
      }
      
        $acl = $service->acl->listAcl('d62u8j2ik3dhlu5slu4hka3dfk@group.calendar.google.com');

        foreach ($acl->getItems() as $rule) {
          echo $rule->getId() . ': ' . $rule->getRole();
        }
              
      //share this calendar with the service account
 
  // The access token may have been updated lazily.
  $_SESSION['access_token'] = $client->getAccessToken();
} else {
  $authUrl = $client->createAuthUrl();
}

if(isset($_REQUEST['setCalendar'])){
    $calId = base64_decode($_REQUEST['setCalendar']);
    //share calendar with service account
    $rule = new Google_Service_Calendar_AclRule();
    $scope = new Google_Service_Calendar_AclRuleScope();

    $scope->setType("default");
    $scope->setValue("191668664245-h1t5dbipvmglh09mc27bo3ckdfjjojqk@developer.gserviceaccount.com");
    $rule->setScope($scope);
    $rule->setRole("owner");

    $createdRule = $service->acl->insert($calId, $rule);
    echo $createdRule->getId();
    //generate link
    
    //revoke access by default
    unset($_SESSION['access_token']);
}
?>
<!doctype html>
<html>
<head><link rel='stylesheet' href='style.css' /></head>
<body>
<div class="box">

<?php
  if(isset($authUrl)) {
    print "<a class='login' href='$authUrl'>Connect Me!</a>";
  } else {
   print "<a class='logout' href='?logout'>Logout</a>";
  }
?>
</div>
</body>
</html>