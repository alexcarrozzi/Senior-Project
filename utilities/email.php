<?php    
/*  
 * All code - unless expressly stated otherwise - in the following file was originally designed and implemented 
 * by Alex Connor Carrozzi for a Senior Project for the 2014-2015 academic year
 *
 * email.php
 * A class used to define and emailing object that is used to send confirmation
 * and cancellation emails to students and advisors regarding the status of 
 * their meetings. This class module is dependant on the Pear mailing
 * installation. 
 */
    
    // Pear Mail Library
    require_once $_SERVER['DOCUMENT_ROOT']."/packages/pear/Mail.php";

    class Email{
        private $_from;
        
        public function __construct($from='professor.jones567@gmail.com'){
            $this->_from = $from;
        }
        
        public function send($argto,$argsubject,$msg){
            if(strlen($argto)==0){
                throw new Exception("'To' field cannot be empty!");
            }
            if(strlen($msg)==0){
                throw new Exception("'Message' field cannot be empty!");
            }
            $from = '<senior.project705@gmail.com>';
            $to = "<$argto>";
            $subject = $argsubject;
            $body = "$msg";
            
            $headers = array(
            'From' => $from,
            'To' => $to,
            'Subject' => $subject
            );
              
              
              $smtp = Mail::factory('smtp', array(
                    'host' => 'ssl://smtp.gmail.com',
                    'port' => '465',
                    'auth' => true,
                    'username' => 'senior.project705@gmail.com',
                    'password' => 'wildcats007'
                ));

            $mail = $smtp->send($to, $headers, $body);

            if (PEAR::isError($mail)) {
                //echo('<p>' . $mail->getMessage() . '</p>');
                return false;
            } else {
                //echo('<p>Message successfully sent!</p>');
                return true;
            }      
        }
    }
    
?>