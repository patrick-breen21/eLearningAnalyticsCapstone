
<?php
////weekly average for students that week
//function AverageEchoTimes($AllEchoData){};
////weekly average for a single student
$AllEchoData = GetAllEchoData();
$FailGradeData = AverageEchoTimePerWeekByGrade(3, $AllEchoData);
$PassGradeData = AverageEchoTimePerWeekByGrade(4, $AllEchoData);
$CreditGradeData = AverageEchoTimePerWeekByGrade(5, $AllEchoData);
$DistGradeData = AverageEchoTimePerWeekByGrade(6, $AllEchoData);
$HDistGradeData = AverageEchoTimePerWeekByGrade(7, $AllEchoData);
$UnitAverage = AverageEchoTimes($AllEchoData);

$studentData = AverageEchoTimeUser($_SESSION['user']['hash'], $AllEchoData);
//pre_dump($studentData);
$studentData = [10, 13, 20, 11, 30, 40, 70, 90];
?>
<section>
<h3>My Logged Time vs Other Student Grade Averages</h3>
<div class='grade-chart chart'></div>
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
        //dummydata.date = 'Week '+(index+1);
        
        dummydata.date = new Date(
            startDate.getFullYear(),
            startDate.getMonth(),
            startDate.getDate()+index*7,
            startDate.getHours(),
            startDate.getMinutes(),
            startDate.getSeconds());
        
        dummydata['My Time'] = studentArray[index];
        dummydata['High Distinction'] = HDisArr[index];
        dummydata['Distinction'] = DisArr[index];
        dummydata['Credit'] = CredArr[index];
        dummydata['Pass'] = PassArr[index];
        dummydata['Fail'] = FailArr[index];
        dummydata['Avg. Unit Time'] = averages[index];
        data.push(dummydata);
    }

optionalLines(data, '.grade-chart');
</script>
</section>
