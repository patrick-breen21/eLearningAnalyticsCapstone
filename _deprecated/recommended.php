<?php include('_includes/head.php') ?>

<?php
////weekly average for students that week
//function AverageEchoTimes($AllEchoData){};

////weekly average for a single student
//function AverageEchoTimeUser($name, $AllEchoData){};
$checklist = [
  ['title'=>'CAB202 2017 Semester 2 Topic 11 ADC  PWM  Assignment Q+A', 'checked'=>0],
  ['title'=>'CAB202 Tutorial 10 - Introduction', 'checked'=>1],
];

$popular = [
  ['title'=>'CAB202 Tutorial 10 - Introduction', 'count'=>98],
  ['title'=>'CAB202 Semester 2 2017 - topic 7 -- Teensy', 'count'=>73],
  ['title'=>'CAB202: Intro to Teensy Tutorial', 'count'=>68],
  ['title'=>'CAB202 - Topic 10 Intro (take 2)', 'count'=>45],
  ['title'=>'CAb202 2017-02 Topic 3', 'count'=>42],
];
?>

<body class=" controls-visible private-page ${intranet-demo} student Current Student en group-id-16731135 page-id-16787600 portlet-type " id="student-theme" data-gr-c-s-loaded="true" cz-shortcut-listen="true">
        <div id="wrapper-container">
            <?php include('_includes/header.php'); ?>            
            <div id="wrapper">
                <?php include('_includes/nav.php'); ?>
                <div class="columns-2-r" id="content-wrapper">
                    <div class="lfr-grid" id="layout-grid">
                        <div id="qut-homePage">
                            <h1 class="layout-heading sr-only">Learning Analytics - Echo Data</h1>
                            <div class="column-container">
                                <div class='elcontent'>
                                    <div class='checklist'>
                                        <div class='title'>My Personal Checklist</div>
                                      <?php foreach ($checklist as $item): ?>
                                        <div class="item">
                                            <?php if ($item['checked']): ?><i class="fa fa-check-circle fa-larger"></i><?php endif;?>
                                            <?php if (!$item['checked']): ?><i class="fa fa-circle-o fa-larger"></i><?php endif;?>
                                            <?= $item['title'] ?>
                                            <?php if ($item['checked']): ?>
                                                <span>Attended</span>
                                            <?php else: ?>
                                                <button>Mark as attended</button>
                                            <?php endif; ?>
                                        </div>
                                      <?php endforeach; ?>
                                    </div>
                                    
                                    <div class='popular external'>
                                        <div class='title'>Popular this week</div>
                                      <?php foreach ($popular as $item): ?>
                                        <div class='item'><a><?= $item['title'] ?></a><span>(<?= $item['count'] ?> Views)</span></div>
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

</body>
</html>
