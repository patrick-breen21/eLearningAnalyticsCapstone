<?php include '_includes/head.php' ?>
<title>Add Data</title>

    <?php
    $data = null;
    // ID Number,Unique Views,Cumulative Views,Average Completion,Last Echo Viewed,Last Date Viewed,Bookmarks,Discussion Threads Started,Echoes Downloaded,Live Events Attended
    $headings = ['ID Number','Unique Views','Cumulative Views','Average Completion','Last Echo Viewed','Last Date Viewed','Bookmarks','Discussion Threads Started','Echoes Downloaded','Live Events Attended'];
    if ($_FILES[csv]) $data = parseCSV($_FILES[csv]);
    ?>
    <body class="home">
        <?php include '_includes/header.php' ?>
        <?php include '_includes/sidebar.php' ?>
        <div class="main">
            <?php// include '_includes/status.php' ?>
            <div class='content'>
            	<div class='title'><h1>Add Data for <?= $_SESSION['user']['firstname'] ?> (<?= $_SESSION['user']['username'] ?>)</h1></div>
            	<div><?php csv_import_form(); ?></div>
                <div><pre>
                    <?php var_dump($data); ?>
                </pre></div>
            </div>
        </div>
    </body>
</body>
</html>
