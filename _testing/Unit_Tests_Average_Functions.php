<?php
include('Average_functions.php');
include('LL_functions.php');

/*
 * Unit tests for all functions related to calculating averages.
 *
 */




/*
 * Test that AverageEchoTimePerWeekByGrade returns data.
 */

function ReturnDataTestAvgEchoTimePerGrad(){


    return AverageEchoTimePerWeekByGrade(5);
}

echo "
    <!DOCTYPE html>
    <html>
    <body>
    
    <h1>Unit Test results</h1>";

echo "<h2>AverageEchoTimePerWeekByGrade(\$Grade (int 3, 4, 5, 6 or 7))</h2> <p>
 * Inputs: Grade integer (which determines percentile of students to take average from.) (int)<br>
 * Outputs: an array of average weekly times (int) for the specified grade.<br>
 *<br>
 * Example:<br>
 *  input: 6<br>
 *  output: [12, 34, 60, 36, 34, 67, 56, 45, 58]<br>
 *  (where each week is average time spent by students with distinction average.)<br>
 *<br>
 * Implementation Assumptions:<br>
 * Assume that the students who spent the most time got the highest grade.<br>
 * Grade correlates to time spent.<br>
 * Somewhat valid assumption for the lower grades but not high distinction students.<br></p>";


//echo "<h3>Test that Data is Returned: when calling function: AverageEchoTimePerWeekByGrade(5):<br></h3>";
//
//echo var_dump(ReturnDataTestAvgEchoTimePerGrad(5));

echo "<h3>Test that reasonable Data is Returned: when calling function: AverageEchoTimePerWeekByGrade(7): Note: dummy data is in DB<br></h3>";

//echo var_dump(AverageEchoTimePerWeekByGrade(3));

$result  = AverageEchoTimePerWeekByGrade(7);

$i=0;
foreach($result as $row){
    echo var_dump($row)."";
    $i++;
}

echo "<h3>Test that reasonable Data is Returned: when calling function: AverageEchoTimePerWeekByGrade(6): Note: dummy data is in DB<br></h3>";

//echo var_dump(AverageEchoTimePerWeekByGrade(3));

$result  = AverageEchoTimePerWeekByGrade(6);

$i=0;
foreach($result as $row){
    echo var_dump($row)."";
    $i++;
}

echo "<h3>Test that reasonable Data is Returned: when calling function: AverageEchoTimePerWeekByGrade(5): Note: dummy data is in DB<br></h3>";

//echo var_dump(AverageEchoTimePerWeekByGrade(3));

$result  = AverageEchoTimePerWeekByGrade(5);

$i=0;
foreach($result as $row){
    echo var_dump($row)."";
    $i++;
}

echo "<h3>Test that reasonable Data is Returned: when calling function: AverageEchoTimePerWeekByGrade(4): Note: dummy data is in DB<br></h3>";

//echo var_dump(AverageEchoTimePerWeekByGrade(3));

$result  = AverageEchoTimePerWeekByGrade(4);

$i=0;
foreach($result as $row){
    echo var_dump($row)."";
    $i++;
}

echo "<h3>Test that reasonable Data is Returned: when calling function: AverageEchoTimePerWeekByGrade(3): Note: dummy data is in DB<br></h3>";

//echo var_dump(AverageEchoTimePerWeekByGrade(3));

$result  = AverageEchoTimePerWeekByGrade(3);

$i=0;
foreach($result as $row){
    echo var_dump($row)."";
    $i++;
}

echo"
<br><br><br>/*<br>
 * ********************************************* ********************************************* *************************<br>
 */<br>";

echo "<h2>ComputeTotalTimeSingleStudent(\$ID (string), \$AllEchoData (array(array(strings, ints, times)))</h2> <p>
 * Input: Student ID (string), All echo data (array(array(strings)))<br>
 * Output: Total time (int)<br>
 * <br>
 * Sums all session times for particular student and returns result. <br>
 */<br>
 <br></p>";

echo "<h3>Test that correct total for single student is returned: ComputeTotalTimesSingleStudent(\"test14\", GetAllEchoData())<br></h3>";



echo var_dump(ComputeTotalTimeSingleStudent("fa4c74d424c83ab22c3d062d1efa2777", GetAllEchoData()));





echo"
<br><br><br>/*<br>
 * ********************************************* ********************************************* *************************<br>
 */<br>";

echo "<h2>ComputeTotalTimesEachStudent(\$AllEchoData (array(array(\"id\", duration(int), \"timestamp\", \"date\", \"title\", \"totalduration\"))</h2> <p>
 * Input: all echo data array(array(string))<br>
 * Output: array(student IDs(string), Total time (int))<br>
 *<br>
 * Computes the total echo times for each student.<br>
<br></p>";


echo "<h3>Test that Data is Returned as list with unique ids:ComputeTotalTimesEachStudent(GetAllEchoData())<br></h3>";

//echo var_dump(GetAllEchoData());

//echo "<br>";
echo var_dump(ComputeTotalTimesEachStudent(GetAllEchoData()));

//$result  = (ComputeTotalTimesEachStudent(GetAllEchoData()));
//
//$i=0;
//foreach($result as $row){
//    echo "<br><p>Row". (string)$i . ":  ". var_dump($row)."</p>";
//    $i++;
//}

echo"
<br><br><br>/*<br>
 * ********************************************* ********************************************* *************************<br>
 */<br>";


echo "<h2>SortStudentsByTotalTime(\$AllEchoData)</h2> <p>
 * Input: list of all students and their individual session times (array(array(strings)))<br>
 * Output: List of unique student IDs sorted in descending order of highest time spent watching echos over semester.<br>
<br></p>";


echo "<h3>Test that a sorted array of arrays is returned:SortStudentsByTotalTime(GetAllEchoData()))<br></h3>";

//echo var_dump(SortStudentsByTotalTime(GetAllEchoData()));

$result  = SortStudentsByTotalTime(GetAllEchoData());
$i=0;
foreach($result as $row){
    echo var_dump($row)."<br>";
    $i++;
}



echo"
<br><br><br>/*<br>
 * ********************************************* ********************************************* *************************<br>
 */<br>";


echo "<h2>GetPercentileOfIDs(\$percentile, \$SortedStudents)</h2> <p>
 * Input:Percentile (int), List of unique student IDs sorted in descending order of highest times to lowest (array(strings, int))<br>
 * Output: List of unique student IDs in the specified percentile.<br>
 *<br>
 * Notes: Percentiles measured in fifths<br>
 *  1st percentile = 19%<br>
 *  2nd percentile = 20%-39%<br>
 *  3rd percentile = 40% - 59%<br>
 *  4th percentile = 60% - 79%<br>
 *  5th percentile = 80% - 100%<br>
 */<br>
<br></p>";


echo "<h3>Test that the bottom percentage of students is returned:GetPercentileOfIDs(1, SortStudentsByTotalTime(GetAllEchoData())))<br></h3>";

echo  var_dump(GetPercentileOfIDs(1, SortStudentsByTotalTime(GetAllEchoData())));

echo "<h3>Test that the 2 percentile of students is returned:GetPercentileOfIDs(2, SortStudentsByTotalTime(GetAllEchoData())))<br></h3>";

echo  var_dump(GetPercentileOfIDs(2, SortStudentsByTotalTime(GetAllEchoData())));

echo "<h3>Test that the last percentile of students is returned:GetPercentileOfIDs(5, SortStudentsByTotalTime(GetAllEchoData())))<br></h3>";

echo  var_dump(GetPercentileOfIDs(5, SortStudentsByTotalTime(GetAllEchoData())));


echo"
<br><br><br>/*<br>
 * ********************************************* ********************************************* *************************<br>
 */<br>";


echo "<h2>GetCompleteEchoDataForStudentIDs(\$StudentIDs, \$AllEchoData)</h2> <p>
 * Input: List of student IDs (array(strings))<br>
 * Output: All corresponding echo data for students in single array<br>
 */<br>
<br></p>";


echo "<h3>Test that the complete data for the given list of students is concatenated.GetCompleteEchoDataForStudentIDs(GetPercentileOfIDs(1, SortStudentsByTotalTime(GetAllEchoData())), GetAllEchoData()) <br></h3>";

$result  = (GetCompleteEchoDataForStudentIDs(GetPercentileOfIDs(5, SortStudentsByTotalTime(GetAllEchoData())), GetAllEchoData()));

$i=0;
foreach($result as $row){
    echo var_dump($row)."<br>";
    $i++;
}



echo "
        
        </body>
        </html>
    ";