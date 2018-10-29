<?php

$studentArray = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13];
$averages = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13];
include 'LL_functions.php';
////weekly average for students that week
//function AverageEchoTimes($AllEchoData){};

////weekly average for a single student
//function AverageEchoTimeUser($name, $AllEchoData){};
$AllEchoData = GetAllEchoData();
$studentArray = AverageEchoTimeUser($_SESSION['user']['hash'], $AllEchoData);
$averages = AverageEchoTimes($AllEchoData);
//pre_dump($studentData);
//$studentData = [124, 10, 20, 11, 250, 40, 70, 34];


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
        dummydata['Fail'] = FailArr[index];
        dummydata['Pass'] = PassArr[index];
        dummydata['Credit'] = CredArr[index];
        dummydata['Distinction'] = DisArr[index];
        dummydata['High Distinction'] = HDisArr[index];
        dummydata['Avg. Unit Time'] = averages[index];
        data.push(dummydata);
    }

console.log(json);
</script>