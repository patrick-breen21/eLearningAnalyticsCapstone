<?php
    //$ID = InsertRiskStatement(rand(0, 100));
    $percentage = rand(10, 99);//GetRiskPercentage($ID);
    
    $statuses = [
        ['class' => 'risk',     'txt' => 'You are at risk.'],
        ['class' => 'warning',  'txt' => 'You are borderline.'],
        ['class' => 'good',     'txt' => 'You are going well.']
    ];
    
    if ($percentage > 66) $status = 2;
    elseif ($percentage > 33) $status = 1;
    else $status = 0;
    
?>
<div class="elstatus <?php echo $statuses[$status]['class']; ?>">
    <div class='heading'><h4>Risk Factor</h4></div>
    <div class='signal-chart'><?= $percentage ?></div>
    <div class='txt'><?php echo $statuses[$status]['txt']; ?></div>
    <!--div class='prm'>
      <div class='week-title'>In Week 6...</div>
      <div class='metric'>You spent 4.2 hours on CAB202 content. That's 41% more than last week!</div>
      <div class='metric'>You scored 9 out of 10 in CAB210 topic 6 weekly assessment. With this score you are on track to score 90% in this course.</div>
      <div class='metric'>As of this week you are on track to reach your goal of a 6 in CAB340, the next assessment is due this Friday and worth 20% of the grade</div>
    </div-->
</div>