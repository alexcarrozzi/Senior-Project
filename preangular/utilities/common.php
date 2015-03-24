<?php
ini_set('display_errors', 1);
require_once('logger.php');

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