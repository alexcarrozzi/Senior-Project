<?php
/*  
 * All code - unless expressly stated otherwise - in the following file was originally designed and implemented 
 * by Alex Connor Carrozzi for a Senior Project for the 2014-2015 academic year
 *
 * common.php
 * This file is used to include common functions and includes that are to
 * be used often
 */
    
ini_set('display_errors', 1);
//require_once('logger.php');

function fmt_gdate($gdate) {
  if ($val = $gdate->getDateTime()) {
    $date = new DateTime($val);
    return ($date->format('U')); //'D\, F n Y g:i' 
  } else if ($val = $gdate->getDate()) {
    $date = new DateTime($val);
    return ($date->format( 'd/m/Y' )). ' (all day)';
  }
}

?>