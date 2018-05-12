<?php
    include 'LLGET.php';
    $ID = InsertRiskStatement(rand(0, 100));
    $percentage = GetRiskPercentage($ID);
    
    $statuses = [
        ['class' => 'risk',     'txt' => 'You are at risk.'],
        ['class' => 'warning',  'txt' => 'You are borderline.'],
        ['class' => 'good',     'txt' => 'You are going well.']
    ];
    
    if ($percentage > 66) $status = 2;
    elseif ($percentage > 33) $status = 1;
    else $status = 0;
    
?>
<div class="status <?php echo $statuses[$status]['class']; ?>">
    <span class='txt'><?php echo $statuses[$status]['txt']; ?> (<?= $percentage ?>)</span>
</div>