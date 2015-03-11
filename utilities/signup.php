<?php
    session_start();
    require_once 'email.php';


    //My Libraries
    require_once 'common.php';
    //require_once 'block.php';
    //require_once 'google_api_init.php';
    //require_once 'google_event_manager.php';
    
    $ret_msg = 'Fail';

    //Handle Form Submissions
    if(isset($_REQUEST['fullname'])){
        $name = $_REQUEST['fullname'];
        $email = $_REQUEST['email'];
       // $timeslot_id = $_REQUEST['timeslot_id'];
        
        if($name == ''){
            //TODO: Handle Errors
            echo '<p>Enter your full name</p>';
        }elseif($email==''){
            //TODO: Handle Errors
            echo '<p>Enter your email</p>';
        }else{
           // $info = $manager->getSegmentById($timeslot_id);
           // $target_segment = $info['segment'];
           // $delete_event = $info['delete_event'];
           // $manager->insert_segment('9oggohktmvu3ckuug6mlmmth28@group.calendar.google.com',$delete_event,$target_segment,$name,$email);
           
            //Construct Email information
            $student_email = "{$name}@wildcats.unh.edu";
            //$student_email = $email."@wildcats.unh.edu";
            $subject = "ScheduleIt Appointment Confirmation";
            $message = "This is a test email from ScheduleIt";
            
            try{
                $_email = new Email('professor.jones567@gmail.com');
                $ret_msg = $_email->send($student_email,$subject,$message);
                Logger::write("STATUS: Email successfully sent to: $student_email with message: $message");
            }catch(Exception $e){
                Logger::write("Email::send failed - ".$e->getMessage());
            }
        }
        echo json_encode($ret_msg);
    }

?>