<?php
    class Email{
        private $_from;
        
        public function __construct($from='professor.jones567@gmail.com'){
            $this->_from = $from;
        }
        
        public function send($to,$subject,$msg){
            if(strlen($to)==0){
                throw new Exception("'To' field cannot be empty!");
            }
            if(strlen($msg)==0){
                throw new Exception("'Message' field cannot be empty!");
            }
            $mailto = $to;
            $body = wordwrap($msg,70);
            $headers = "From: ".$this->_from." \r\n".
                        "CC: [Advisor Email]";
            
            return mail($mailto,$subject,$body,$headers);
        }
    }
    
?>