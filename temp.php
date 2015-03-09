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
                        <input type="radio" id="timeslot_id" name="timeslot_id" value="<?="$i:$j:$event_id"?>"/>
                        Slot <?=($j+1).': '.date('D F j\, Y',$segment[0]).' <strong>'.date('g:i',$segment[0]).' &ndash; '.date('g:i',$segment[1])?></strong>
                        <?php $_SESSION['segments'][$i][$j] = $segment;?>
                        <br/>
                    <?php $j++; endforeach; ?>
                <hr/>
        <?php endif; ?>
  <?php $i++; endforeach; ?>