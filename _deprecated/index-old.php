<?php include('_includes/head.php') ?>

<?php

//$timeData = GetStudentTimeUnit($_SESSION['user']['hash'], 'cab202');
// json_encode($timeData)

$timeData = [];

foreach($_SESSION['user']['units'] as $unitCode) {
  $timeData[$unitCode] = rand(0,100);
}

?>
<body class=" controls-visible private-page ${intranet-demo} student Current Student en group-id-16731135 page-id-16787600 portlet-type " id="student-theme" data-gr-c-s-loaded="true" cz-shortcut-listen="true">
        <div id="wrapper-container">
            <?php include('_includes/header.php'); ?>            
            <div id="wrapper">
                <?php include('_includes/nav.php'); ?>
                <?php include('_includes/status.php'); ?>                
                <div class="columns-2-r" id="content-wrapper">
                    <div class="lfr-grid" id="layout-grid">
                        <div id="qut-homePage">
                            <h1 class="layout-heading sr-only">Home</h1>
                            <div class="column-container">
                                <div class='elcontent dashboard grid' id='gridDrag'>
                                    <div class='cell chart'></div>
                                    <div class='cell legend'>
                                      <?php foreach ($timeData as $unitCode=>$time): ?>
                                        <?php
                                          $timepercent = 100*$time/array_sum($timeData);
                                          //pre_dump($timepercent);
                                        ?>
                                        <h3><a href="unit/<?=$unitCode?>"><?=$unitCode?> - <?=$units[$unitCode]['title']?> (<?=round($timepercent)?>%)</h3>
                                        <?php if ($time < 10 || $timepercent < 10): ?>
                                          <h3>Focus more on <?= $unitCode ?></h3>
                                        <?php endif; ?>
                                      <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        <?php include('_includes/footer.php'); ?> 
        </div>
<?php
  $times = [];
  foreach($timeData as $unit=>$time) {
    array_push($times, $time);
  }
?>
<script>
  pie(<?= json_encode($times) ?>, '.chart');
</script>

        
</body></html>