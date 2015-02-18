<?php
session_start();

//My Libraries
require_once 'utilities/common.php';
require_once 'utilities/block.php';
require_once 'utilities/google_event_manager.php';
require_once 'utilities/google_api_init.php';

//Handle Form Submissions
if(isset($_REQUEST['fullname'])){
    $name = $_REQUEST['fullname'];
    $email = $_REQUEST['email'];
    $timeslot_id = $_REQUEST['timeslot_id'];
    
    if($name == ''){
        //TODO: Handle Errors
        echo '<p>Enter your full name</p>';
    }elseif($email==''){
        //TODO: Handle Errors
        echo '<p>Enter your email</p>';
    }else{
        $info = $manager->getSegmentById($timeslot_id);
        $target_segment = $info['segment'];
        $delete_event = $info['delete_event'];
        $manager->insert_segment('9oggohktmvu3ckuug6mlmmth28@group.calendar.google.com',$delete_event,$target_segment,$name,$email);
        header('Location: .');
    }
}

?>

<!DOCTYPE HTML>
<html>
<head>
    <title>ScheduleIt Home</title>
</head>
<body>
    <?php unset($_SESSION['segments']); ?>
    <form method="POST" action=".">
    <?php $i=0; ?>
    <?php foreach ($events->getItems() as $event):?>
        <?php if($event->getDescription() == ''):
                $block = new Block(fmt_gdate($event->getStart()),fmt_gdate($event->getEnd()));
        ?>
                <br/>
                <strong>Event            <?=$i+1?></strong>:                             <br/>
                Event Name:              <?=htmlspecialchars($event->getSummary())?>     <br/>
                Event Updated Time:      <?=htmlspecialchars($event->getUpdated())?>     <br/>
                Event Description:       <?=htmlspecialchars($event->getDescription())?> <br/>
                Event ID:                <?=htmlspecialchars($event->getId())?>          <br/>
                Block Time:              <?=htmlspecialchars(date('D F j\, Y',fmt_gdate($event->getStart()))).' '.
                                            htmlspecialchars(date('g:i',fmt_gdate($event->getStart()))).' &ndash; '.
                                            htmlspecialchars(date('g:i',fmt_gdate($event->getEnd())))?>
                                                                                         <br/><br/>
                    <?php
                    $segs = $block->getList();
                    $j=0;
                    ?>
                    <?php foreach($segs as $segment):?>
                        <?php $event_id = $event->getId(); ?>
                        <input type="radio" name="timeslot_id" value="<?="$i:$j:$event_id"?>"/>
                        Slot <?=($j+1).': '.date('D F j\, Y',$segment[0]).' <strong>'.date('g:i',$segment[0]).' &ndash; '.date('g:i',$segment[1])?></strong>
                        <?php $_SESSION['segments'][$i][$j] = $segment;?>
                        <br/>
                    <?php $j++; endforeach; ?>
                <hr/>
        <?php endif; ?>
  <?php $i++; endforeach; ?>
    Name: <input type="text" name="fullname" /><br/>
    Email: <input type="text" name="email" /><br/>
    <input type="submit" value="Sign Up!" />
  </form>
</body>
</html>
