<?php include '_includes/head.php' ?>
<title>Add Data</title>

    <?php
    //require('connect.php');
    ?>
    <body class="home">
        <?php include '_includes/header.php' ?>
        <?php include '_includes/sidebar.php' ?>
        <div class="main">
            <?php include '_includes/status.php' ?>
            <div class='content'>
            	<div class='title'><h1>Add Data for <?= $_SESSION['user']['firstname'] ?> (<?= $_SESSION['user']['username'] ?>)</h1></div>
            	<iframe class='chart' src="http://ec2-13-210-217-192.ap-southeast-2.compute.amazonaws.com/dashboards/5af0a49794d16c055a580d97" scrolling="no"></iframe>
            </div>
        </div>
    </body>
</body>
</html>
