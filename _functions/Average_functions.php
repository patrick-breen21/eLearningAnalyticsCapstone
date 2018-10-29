<?php
/**
 * Created by PhpStorm.
 * User: George
 * Date: 15/08/2018
 * Time: 1:32 PM
 * This class of functions uses the LL_functions to retrieve information for learning locker.
 * Results of functions are parsed to graphing functions.
 * Unit tests for these functions can be found in Unit_tests_Averages.php
 */


/*
 * Inputs: Grade integer (which determines percentile of students to take average from.) (int)
 * Returns an array of average weekly times (minutes) for the specified grade.
 *
 * Example:
 *  input: 6
 *  output: [12, 34, 60, 36, 34, 67, 56, 45, 58]
 *  (where each week is average time spent by students with distinction average.)
 *
 * Implementation Assumptions:
 * Assume that the students who spent the most time got the highest grade.
 * Grade correlates to time spent.
 * Somewhat valid assumption for the lower grades but not high distinction students.
 */
function AverageEchoTimePerWeekByGrade($Grade, $AllEchoData = null){
    if ($AllEchoData == null) $AllEchoData = GetAllEchoData();
    $new_times= array();
    //Create dummy data
//    $dummydata = array(10, 15, 10, 30, 20, 30, 40, 40, 45, 47, 50, 60, 60);
//
//    foreach ($dummydata as $value) {
//
//        $new_times[] = $value * $Grade;
//
//    }
//
//    return $new_times;
//
//

    //order all students by total time they spent over the semester.
    //return a list of student IDs in order of total time.
    $Sortedstudents = SortStudentsByTotalTime($AllEchoData);

    //compute average from bottom 20% of students
    if ($Grade == 3){
        //get lowest percentile of students
        $StudentIDstoaverage = GetPercentileOfIDs(1, $Sortedstudents);
        //generate the complete list of students data in 1st percentile
        $AllGrade3AndLower = GetCompleteEchoDataForStudentIDs($StudentIDstoaverage, GetAllEchoData());
        //average the students in 1st percentile over each week.
        return AverageEchoTimes($AllGrade3AndLower);
    }
    else if($Grade == 4){
        $StudentIDstoaverage = GetPercentileOfIDs(2, $Sortedstudents);
        $AllGrade3AndLower = GetCompleteEchoDataForStudentIDs($StudentIDstoaverage, GetAllEchoData());
        return AverageEchoTimes($AllGrade3AndLower);
    }else if($Grade == 5){
        $StudentIDstoaverage = GetPercentileOfIDs(3, $Sortedstudents);
        $AllGrade3AndLower = GetCompleteEchoDataForStudentIDs($StudentIDstoaverage, GetAllEchoData());
        return AverageEchoTimes($AllGrade3AndLower);
    }else if($Grade == 6){
        $StudentIDstoaverage = GetPercentileOfIDs(4, $Sortedstudents);
        $AllGrade3AndLower = GetCompleteEchoDataForStudentIDs($StudentIDstoaverage, GetAllEchoData());
        return AverageEchoTimes($AllGrade3AndLower);
    }else if($Grade == 7){
        $StudentIDstoaverage = GetPercentileOfIDs(5, $Sortedstudents);
        $AllGrade3AndLower = GetCompleteEchoDataForStudentIDs($StudentIDstoaverage, GetAllEchoData());
        return AverageEchoTimes($AllGrade3AndLower);
    } else {
        return array("invalid input arguments");
    }
}

//sort total student times in order
function time_sort($a, $b) {
    return ($a[1]) - ($b[1]);
}

/*
 * Input: list of all students and their individual session times (array(array(strings)))
 * Output: List of unique student IDs sorted in decending order of highest time spent watching echos over semester.
 */
function SortStudentsByTotalTime($AllEchoData){

    $TotalTimesEachStudent = ComputeTotalTimesEachStudent($AllEchoData);
    //sort by total time
    usort($TotalTimesEachStudent, "time_sort");
    return $TotalTimesEachStudent;
}

/*
 * Input: all echo data array(array(string))
 * Output: array(student IDs(string), Total time (int))
 *
 * Computes the total echo times for each student.
 */

function ComputeTotalTimesEachStudent($AllEchoData){

    //generate list of student ids (not unique)
    $studentIds = array();
    foreach($AllEchoData as $row){
        array_push($studentIds, $row[0]);
    }
    //generate list of unique elements from all echo data

    $uniqueids = array_unique($studentIds);
    $results = array(array());

    foreach($uniqueids as $id){
        $total = ComputeTotalTimeSingleStudent($id, $AllEchoData);
        array_push($results, array($id, $total));
    }
    //return array(array("test14", 300), array("test15", 600));
    //deal with empty elements at start and finish due to init
    array_shift($results);
    array_pop($results);
    return $results;
}


/*
 * Input: Student ID (string), All echo data (array(array(strings)))
 * Output: Total time (int)
 *
 * Sums all session times for particular student and returns result.
 */

function ComputeTotalTimeSingleStudent($ID, $AllEchoData){

    $total=0;
    foreach($AllEchoData as $entry){
        if($entry[0] == $ID){
            $total+= (int)$entry[1];
        }
    }
    return $total;

}


/*
 * Input:Percentile (int), List of unique student IDs sorted in descending order of highest times to lowest (array(strings))
 * Output: List of unique student IDs in the specified percentile.
 *
 * Notes: Percentiles measured in fifths
 *  1st percentile = 19%
 *  2nd percentile = 20%-39%
 *  3rd percentile = 40% - 59%
 *  4th percentile = 60% - 79%
 *  5th percentile = 80% - 100%
 */
function GetPercentileOfIDs($percentile, $SortedStudents){

    //calculate range of indexes for 20%
    $total = count($SortedStudents);
    $range = (int)floor(0.2*$total);
    $NewList = array();

    if($percentile == 1){
        for($i=0; $i < $range;$i++){
            array_push($NewList, $SortedStudents[$i][0]);
        }
    } else if($percentile == 2){
        for($i=$range; $i < ($range*2) ;$i++){
            array_push($NewList, $SortedStudents[$i][0]);
        }
    } else if($percentile == 3){
        for($i=$range*2; $i < ($range*3) ;$i++){
            array_push($NewList, $SortedStudents[$i][0]);
        }
    } else if($percentile == 4){
        for($i=$range*3; $i < ($range*4) ;$i++){
            array_push($NewList, $SortedStudents[$i][0]);
        }
    } else if($percentile == 5){
        for($i=$range*4; $i < count($SortedStudents) ;$i++){
            array_push($NewList, $SortedStudents[$i][0]);
        }
    }
    return $NewList;
}

/*
 * Input: List of student IDs (array(strings))
 * Output: All corresponding echo data for students in single array
 */
function GetCompleteEchoDataForStudentIDs($StudentIDs, $AllEchoData){
    $NewList = array();
    foreach($StudentIDs as $id){
        foreach($AllEchoData as $row){
            if($row[0] == $id){
                array_push($NewList, $row);
            }
        }
    }
    return $NewList;
}