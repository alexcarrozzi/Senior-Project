<?php
    // Pear Mail Library
    require_once "Mail.php";

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
            $body = wordwrap($msg,70);
            $headers = "From: ".$this->_from."\r\n".
                        "CC: [Advisor Email]";
            
            $from = '<senior.project705@gmail.com>';
            $to = "<$argto>";
            $subject = $argsubject;
            $body = "$body";
            
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
                echo('<p>' . $mail->getMessage() . '</p>');
                return false;
            } else {
                echo('<p>Message successfully sent!</p>');
                return true;
            }      
            
          
            //return mail($mailto,$subject,$body,$headers);
        }
    }
    
?>