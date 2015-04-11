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
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
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
    $cals = [];
    $i=-1;
      foreach ($calendarList->getItems() as $calendarListEntry) {
        $cals[++$i]['sum'] =  $calendarListEntry->getSummary();
        $cals[$i]['id']  = $calendarListEntry->getId();
      }
 
  // The access token may have been updated lazily.
  $_SESSION['access_token'] = $client->getAccessToken();
} else {
  $authUrl = $client->createAuthUrl();
}

if(isset($_REQUEST['calendar'])){
    $calId = $_REQUEST['calendar'];
    //share calendar with service account
    $rule = new Google_Service_Calendar_AclRule();
    $scope = new Google_Service_Calendar_AclRuleScope();

    $scope->setType("user");
    $scope->setValue("191668664245-h1t5dbipvmglh09mc27bo3ckdfjjojqk@developer.gserviceaccount.com");
    $rule->setScope($scope);
    $rule->setRole("owner");

    $createdRule = $service->acl->insert($calId, $rule);
    //generate link
    $link = "http://scheduleit.cs.unh.edu:8080/?cid=".base64_encode($calId);
    
    //revoke access by default
    unset($_SESSION['access_token']); 
}
?>
<!doctype html>
<html>
<head>
<link rel='stylesheet' href='style.css' />
<script src="../js/jquery-1.11.2.min.js"></script>
<script src="../js/jadmin.js"></script>
</head>
<body>
        <?php if(isset($authUrl)): ?>
             <a class='login' href="<?= $authUrl; ?>">Connect Me!</a>
        <?php else: ?>
            <form method="POST" action=".">
                <select name="calendar">
                    <?php foreach($cals as $cal):?>
                    <option value="<?= $cal['id'] ?>"><?=$cal['sum']?></option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" value="Generate Link"/>
            </form>
            <?php if(isset($link)): ?>
                <div id="yourLink">
                    <a href="<?=$link?>"><?=$link?></a>
                </div>
            <?php endif; ?>
            <a href="?logout"/>Logout</a>
        <?php endif; ?>
</body>
</html>