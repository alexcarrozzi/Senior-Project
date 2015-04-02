<?php

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

    header("Content-Type:application/json");
    header("Location:http://http://scheduleit.cs.unh.edu:8080/d2098f349foijn49uginer/");
    echo json_encode(link);
}
?>