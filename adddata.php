<html class="no-js webkit safari safari0 js gr__smallprojects_info" dir="ltr" lang="en"><!--<![endif]-->
<?php include('_includes/head.php') ?>
<?php
    $data = null;
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
                            <h1 class="layout-heading sr-only">Add Data</h1>
                            <div class="column-container">
                                <div class='elcontent'>
                                    <div><?php csv_import_form(); ?></div>
                                    <br>
                                    <div class='upload-msg'>
                                    <?php
                                        if ($_FILES[csv]) {
                                            $data = parseCSV($_FILES[csv]);
                                            if ($data[0]['Echo Date']) {
                                                $hashes = array_unique(array_column($data, 'hash'));
                                                foreach ($hashes as $hash) {
                                                    echo('<pre>');
                                                    //echo $hash;
                                                    loadSingleUserData($hash, 'Echo Duration (Minutes)', $data);
                                                    echo('</pre>');
                                                }
                                            }
                                        }
                                    ?>
                                    </div>
                                    <div>
                                        <?php displayData($data); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        <?php include('_includes/footer.php'); ?> 
        </div>
</body></html>
