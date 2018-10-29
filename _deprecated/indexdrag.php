<?php include('_includes/head.php') ?>
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
                                    <div class='cell cell-0'></div>
                                    <div class='cell cell-1'></div>
                                    <div class='cell cell-2'></div>
                                    <div class='cell cell-3'></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        <?php include('_includes/footer.php'); ?> 
        </div>


<?php
$timeData = GetStudentTimeUnit($_SESSION['user']['hash'], 'cab202');
?>
<script>
  pie(<?= json_encode($timeData)?>, '.cell-0');
  pie([100, 80, 30, 50], '.cell-1');
  pie([90, 85, 20, 15], '.cell-2');
  pie([95, 100, 90, 95], '.cell-3');
  

dragula([document.getElementById('gridDrag')]);
</script>

        
</body></html>