<?php include('_includes/head.php') ?>

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
                            <div id='chart'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('_includes/footer.php'); ?>
</div>
<?php
////weekly average for students that week
//function AverageEchoTimes($AllEchoData){};
////weekly average for a single student
$AllEchoData = GetAllEchoData();
$FailGradeData = AverageEchoTimePerWeekByGrade(3);
$PassGradeData = AverageEchoTimePerWeekByGrade(4);
$CreditGradeData = AverageEchoTimePerWeekByGrade(5);
$DistGradeData = AverageEchoTimePerWeekByGrade(6);
$HDistGradeData = AverageEchoTimePerWeekByGrade(7);
$UnitAverage = AverageEchoTimes($AllEchoData);

$studentData = AverageEchoTimeUser($_SESSION['user']['hash'], $AllEchoData);
//pre_dump($studentData);
$studentData = [10, 13, 20, 11, 30, 40, 70, 90];
?>
<script src="http://d3js.org/d3.v3.js"></script>
<script>
    var studentArray = <?php echo json_encode($studentData)?>;
    var FailArr = <?php echo json_encode($FailGradeData)?>;
    var PassArr = <?php echo json_encode($PassGradeData)?>;
    var CredArr = <?php echo json_encode($CreditGradeData)?>;
    var DisArr = <?php echo json_encode($DistGradeData)?>;
    var HDisArr = <?php echo json_encode($HDistGradeData)?>;
    var averages = <?php echo json_encode($UnitAverage)?>;
    var data = [];
   var startDate = new Date('February 12, 2017 00:00:00 GMT+1000');
    for (index in studentArray) {
        var dummydata = {};
        //dummydata.date = '2011100'+index;
        dummydata.date = new Date(
            startDate.getFullYear(),
            startDate.getMonth(),
            startDate.getDate()+index*7,
            startDate.getHours(),
            startDate.getMinutes(),
            startDate.getSeconds());
        dummydata['Student'] = studentArray[index];
        dummydata['High Distinction'] = HDisArr[index];
        dummydata['Distinction'] = DisArr[index];
        dummydata['Credit'] = CredArr[index];
        dummydata['Pass'] = PassArr[index];
        dummydata['Fail'] = FailArr[index];
        dummydata['Avg. Unit Time'] = averages[index];
        data.push(dummydata);
    }

optionalLines(data, '#chart');
</script>
</body>
</html>
