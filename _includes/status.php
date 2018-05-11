<?php
    $statuses = [
        ['class' => 'risk',     'txt' => 'You are at risk.'],
        ['class' => 'warning',  'txt' => 'You are borderline.'],
        ['class' => 'good',     'txt' => 'You are going well.']
    ];
    
    $status = rand(0,count($statuses)-1);
    
?>
<div class="status <?php echo $statuses[$status]['class']; ?>">
    <span class='txt'><?php echo $statuses[$status]['txt']; ?></span>
</div>