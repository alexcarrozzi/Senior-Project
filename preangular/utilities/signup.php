<?php
    session_start();

    //My Libraries
    require_once 'utilities/common.php';
    require_once 'utilities/block.php';
    require_once 'utilities/google_event_manager.php';
    require_once 'utilities/google_api_init.php';

    //Handle Form Submissions
    if(isset($_REQUEST['fullname'])){
        $name = $_REQUEST['fullname'];
        $email = $_REQUEST['email'];
        $timeslot_id = $_REQUEST['timeslot_id'];
        
        if($name == ''){
            //TODO: Handle Errors
            echo '<p>Enter your full name</p>';
        }elseif($email==''){
            //TODO: Handle Errors
            echo '<p>Enter your email</p>';
        }else{
            $info = $manager->getSegmentById($timeslot_id);
            $target_segment = $info['segment'];
            $delete_event = $info['delete_event'];
            $manager->insert_segment('9oggohktmvu3ckuug6mlmmth28@group.calendar.google.com',$delete_event,$target_segment,$name,$email);
            header('Location: .');
        }
    }

?>