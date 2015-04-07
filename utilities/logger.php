<?php     
/*  
 * All code in the following file was originally designed and implemented 
 * by Alex Connor Carrozzi for a Senior Project for the 2014-2015 academic year
 * The University of New Hampshire Computer Science Department owns and
 * is responsible for all functionality contained in the web application
 * ScheduleIt
 *
 * logger.php
 * This class is used to define an object that will log events to a standard
 * log file. The class contains a single static function to write to the
 * log.
 */
    
     $prod = 0;
     $sp = $prod==0?"Senior-Project/":"";    
    define('DEFAULT_LOG',$_SERVER['DOCUMENT_ROOT']."/{$sp}logs/phpweblog-".date('d\-m\-Y').'.log');
    
    //Log Codes:
    //101 - Standard logging
    //102 - Error
    define('DEFAULT_CODE','101');
    
    
    class Logger{
        
        public static function write($msg, $code = DEFAULT_CODE, $file = DEFAULT_LOG){
            $fh = fopen($file,'a+') or die("Fatal error in logger");
            
            fwrite($fh,date(\DateTime::ATOM)." -- Code: {$code}:".$msg."\r\n");
            
            fclose($fh);
        }
    }
?>