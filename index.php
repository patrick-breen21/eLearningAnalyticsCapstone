<!DOCTYPE html>
<html>
<head>
<?php include '_includes/head.php' ?>
<title>Learning Analytics</title>
</head>

    <?php
    //Start the Session
    session_start();
    include('login.php');
    //require('connect.php');
    //3. If the form is submitted or not.
    //3.1 If the form is submitted
    ?>
    <?php if (isset($_SESSION['user'])): ?>
        <body class="home">
            <?php include '_includes/header.php' ?>
            <?php include '_includes/sidebar.php' ?>
            <div class="content">
        	<div class='title'><h1>General Analytics for <?= $_SESSION['user']['firstname'] ?> (<?= $_SESSION['user']['username'] ?>)</h1></div>
        	<iframe class='chart' src="http://ec2-13-210-217-192.ap-southeast-2.compute.amazonaws.com/dashboards/5af0a49794d16c055a580d97" scrolling="no"></iframe>
        	</div>
        </body>
    <?php else: ?>
        <body class='login'>
            <?include 'loginform.php' ?>
        </body>
	<?php endif; ?>
</body>
</html>
