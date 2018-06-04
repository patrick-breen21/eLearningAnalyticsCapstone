<?php include '_includes/head.php'?>
<body class=" controls-visible private-page ${intranet-demo} student Current Student en group-id-16731135 page-id-16787600 portlet-type " id="student-theme" data-gr-c-s-loaded="true" cz-shortcut-listen="true">
        <div id="wrapper-container">
            <?php include '_includes/header.php';?>
            <div id="wrapper">
                <?php include '_includes/nav.php';?>
                <?php include '_includes/status.php';?>
                <div class="columns-2-r" id="content-wrapper">
                    <div class="lfr-grid" id="layout-grid">
                        <div id="qut-homePage">
                            <h1 class="layout-heading sr-only">Charts</h1>
                            <div class="column-container">
                                <div class='elcontent'>
                                    <?php
                                    $charts = ['animatedpath.php', 'arctween.php', 'circlesegment.php', 'dial.php', 'donuts.php', 'gauge.php', 'pie.php', 'progress.php', 'progresstable.php'];
                                    ?>
                                    <?php foreach ($charts as $chart): ?>
                                        <a href="charts/<?=$chart?>"><?=$chart?></a>
                                    <?php endforeach;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        <?php include '_includes/footer.php';?>
        </div>
</body></html>