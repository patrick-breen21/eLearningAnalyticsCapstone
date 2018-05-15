<?php include '_includes/head.php' ?>
<title>Charts</title>

    <?php
    //require('connect.php');
    ?>
    <body class="home">
        <?php include '_includes/header.php' ?>
        <?php include '_includes/sidebar.php' ?>
        <div class="main">
            <div class='content'>
            	<div class='title'><h1>Charts</h1></div>
            	<?php
                	$charts = ['animatedpath.php', 'arctween.php', 'circlesegment.php', 'dial.php', 'donuts.php', 'gauge.php', 'pie.php', 'progress.php', 'progresstable.php'];
                ?>
                    <?php foreach ($charts as $chart): ?>
                    	<a href="charts/<?=$chart?>"><?=$chart?></a>
                	<?php endforeach; ?>
            </div>
        </div>
    </body>
</body>
</html>
