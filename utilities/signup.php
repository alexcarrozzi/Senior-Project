<?php     
/*  
 * All code - unless expressly stated otherwise - in the following file was originally designed and implemented 
 * by Alex Connor Carrozzi for a Senior Project for the 2014-2015 academic year
 *
 * 
 */
     require_once 'email.php';

    //My Libraries
    require_once 'common.php';
    require_once 'block.php';
    
    $ret_msg['status'] = 'success';
    $ret_msg['msg'] = '';
    
    //Handle Form Submissions
    if(isset($_REQUEST['fullname'])){
        $name = $_REQUEST['fullname'];
        $email = $_REQUEST['email'];
        $timeslot_id = $_REQUEST['timeslot_id'];
        $cal_id = $_REQUEST['cal_id'];
        
        
        $GLOBALS['g_calid'] = $cal_id;
        require_once $_SERVER['DOCUMENT_ROOT']."/utilities/google_api_init.php";
            
        if($name == ''){
            $ret_msg['status'] = 'error';
            $ret_msg['msg'] = 'Enter your full name';
        }elseif($email==''){
            $ret_msg['status'] = 'error';
            $ret_msg['msg'] = 'Enter your Email';
        }else{
              $info = $manager->getSegmentById($timeslot_id);
              $target_segment = $info['segment'];
              $delete_event = $info['delete_event'];
              $data = $manager->insert_segment($g_calid,$delete_event,$target_segment,$name,$email);
              
              $new_id = $data[0];
              $new_event = $data[1];
              //Set a random string cookie to deter spammers
              //This cookie should be deleted upon cancellation
              if(isset($new_event)){
                setcookie('ofn3793filnf49842kc3ji972inr');
              }
              
            //Unix timestamp of meeting start time
            $link_s = $new_id;
            
            //Basic Obfuscation (Easily cracked)
            
            //Before flag sequence
            $before = "9JflMdf3s";
            
            //After flag sequence
            $after = "5jk49sDFd";
            
            $obfuscated_url = substr($g_calid,0,7).$before.$link_s.$after.substr($g_calid,7);
            $obfuscated_url = base64_encode($obfuscated_url);
            
            $link = "http://scheduleit.cs.unh.edu:8080?action=cancel&s=$obfuscated_url";

            //Construct Email information
            $student_email = $email;
            $subject  = "ScheduleIt Appointment Confirmation";
            $message  = "Dear {$name},\r\n\r\n";
            $message .= "Your advising meetings has been scheduled ";
            $message .= "for ".date('l, F j, Y \a\t g:i a',$new_event).".\r\n\r\n";
            $message .= "If you did not sign up for this meeting please follow this link: ";
            $message .= $link;
            
            try{
                $_email = new Email('professor.jones567@gmail.com');
                $_email->send($student_email,$subject,$message);
                //Logger::write("STATUS: Email successfully sent to: $student_email with message: $message");
            }catch(Exception $e){
               //Logger::write("Email::send failed - ".$e->getMessage());
            }
        }
        header("Content-Type: application/json");
        echo json_encode($ret_msg);
    }

?>