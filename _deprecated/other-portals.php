<?php include('_includes/head.php') ?>

<?php
////weekly average for students that week
//function AverageEchoTimes($AllEchoData){};

////weekly average for a single student
//function AverageEchoTimeUser($name, $AllEchoData){};

$popular = [
  ['title'=>'C Training and Tutorials', 'source'=>'Lynda', 'up'=>98, 'down'=>0, 'academic-approved'=>true, 'tags'=>['C'], 'link'=>'https://www.lynda.com/C-training-tutorials/1249-0.html'],
  ['title'=>'C Programming Pointers', 'source'=>'Programiz', 'down'=>1, 'up'=>73, 'academic-approved'=>true, 'tags'=>['C', 'Pointers'], 'link'=>'https://www.programiz.com/c-programming/c-pointers'],
  ['title'=>'C Programming Language', 'source'=>'Geeks for Geeks',  'up'=>68, 'down'=>2, 'academic-approved'=>false, 'tags'=>['C'], 'link'=>'https://www.geeksforgeeks.org/c-programming-language/'],
  ['title'=>'C Programming: Language Foundations', 'source'=>'EDX',  'up'=>45, 'down'=>2, 'academic-approved'=>false, 'tags'=>['C'], 'link'=>'https://www.edx.org/course/c-programming-language-foundations'],
  ['title'=>'C Language - Overview', 'source'=>'Tutorials Point',  'up'=>42, 'down'=>3, 'academic-approved'=>false, 'tags'=>['C'], 'link'=>'https://www.tutorialspoint.com/cprogramming/c_overview.htm'],
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
                                    <div class='popular external'>
                                        <div class='title'>CAB202 - Popular External Resources</div>
                                      <?php foreach ($popular as $item): ?>
                                        <div class='item'>
                                          <div>
                                            <a href="<?= $item['link'] ?>"><?= $item['title'] ?></a>
                                            <span><i class='fa fa-arrow-up'></i><?= $item['up'] ?></span>
                                            <span><i class='fa fa-arrow-down'></i><?= $item['down'] ?></span>
                                            <?php if ($item['academic-approved']): ?>
                                              <span><i class='fa fa-star'></i>Academic Approved</span>
                                            <?php endif; ?>
                                          </div>
                                          <div>
                                            <a><?= $item['source'] ?></a>
                                            <?php foreach ($item['tags'] as $tag): ?>
                                              <span><?= $tag ?></span>
                                            <?php endforeach; ?>
                                          </div>
                                          <div>
                                            <button><i class='fa fa-flag'></i>Report</button>
                                            <button><i class='fa fa-arrow-up'></i>Upvote</button>
                                            <button><i class='fa fa-arrow-down'></i>Downvote</button>
                                          </div>
                                        </div>
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
