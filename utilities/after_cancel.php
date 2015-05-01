<?php
/*  
 * All code - unless expressly stated otherwise - in the following file was originally designed and implemented 
 * by Alex Connor Carrozzi for a Senior Project for the 2014-2015 academic year
 *
 * 
 */
?>
<p>You have successfully cancelled your meeting on <?= date('l, F j, Y \a\t g:i a',$canceled_time) ?><br/> 
    If you wish to sign&ndash;up for a new time, please go to <a href="http://scheduleit.cs.unh.edu:8080/?cid=<?= base64_encode($cal_id) ?>">http://scheduleit.cs.unh.edu:8080/?cid=<?= base64_encode($cal_id)?></a>
</p>
