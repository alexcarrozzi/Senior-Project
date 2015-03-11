<?php
    define('DEFAULT_LOG','../logs/phpweblog'.date('d\-m\-Y').'.log');
    
    //Log Codes:
    //101 - Standard logging
    //102 - Error
    define('DEFAULT_CODE','101');
    
    
    class Logger{
        
        public static function write($msg, $code = DEFAULT_CODE, $file = DEFAULT_LOG){
            try{
                $fh = fopen($file,'a');
            }catch(Exception $e){
                echo "Fatal error in logger";
                exit;
            }
            
            fwrite($fh,date(\DateTime::ATOM)." -- Code: {$code}:".$msg."\r\n");
            
            fclose($fh);
        }
    }
?>