<?php
  
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

<h2 class="">Internal Recommended Resources</h2>
<div class="column-container">
    <div class='elcontent grid'>
        <div class='checklist cell'>
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
        
        <div class='popular external cell'>
            <div class='title'>Popular this week</div>
          <?php foreach ($popular as $item): ?>
            <div class='item'><a><?= $item['title'] ?></a><span>(<?= $item['count'] ?> Views)</span></div>
          <?php endforeach; ?>
        </div>
    </div>
</div>

<h3>Videos</h3>
<?php if ($unit['code'] == 'cab202'): ?>
    <div class='elcontent grid'>
        <div class='cell'>
            <h4>Pointers Analogy</h4>
            <div class="qut-mw-embed" data-did="42923" data-ddocname="QMW_034998"></div>
        </div>
        <div class='cell'>
            <h4>Pointers Implementation</h4>
            <div class="qut-mw-embed" data-did="42924" data-ddocname="QMW_034999"></div>
        </div>
        <div class='cell'>
            <h4>Structures Analogy</h4>
            <div class="qut-mw-embed" data-did="42728" data-ddocname="QMW_034803"></div>
        </div>
        <div class='cell'>
            <h4>Structures Implementation</h4>
            <div class="qut-mw-embed" data-did="42925" data-ddocname="QMW_035000"></div>
        </div>
    </div>
    <script src="https://mediawarehouse.qut.edu.au/QMW/js/embed/load.js"></script>
<?php endif; ?>

