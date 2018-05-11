<?php
    $statuses = [
        ['class' => 'risk', 'txt' => 'You are currently at risk.'],
        ['class' => 'warning', 'txt' => 'You are currently borderline.'],
        ['class' => 'good', 'txt' => 'You are currently going well.']
    ];
    
    $status = rand(0,count($statuses)-1);
    
?>
<div class="status <?php echo $statuses[$status]['class']; ?>">
    <span class='txt'><?php echo $statuses[$status]['txt']; ?></span>
</div>