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
    <div class='signal-chart'><?= $percentage ?></div>
    <!--div class='txt'><?php echo $statuses[$status]['txt']; ?></div-->
</div>