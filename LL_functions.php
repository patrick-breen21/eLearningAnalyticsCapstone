<?php

/*
These functions provide an interface with learning locker.
Functionality includes inserting and querying the learning locker db.
 */

function InsertEchoTimeStatement($name, $duration, $timestamp, $date){

    $curl = curl_init();
//    $name = "test";
//    $duration = "50";
//    $timestamp = "11:30AM";
//    $date = "21/2/18";
    $date = str_replace('/', '-', $date);


    //string of name, time, timestamp and date - comma separated & semicolon ended.
    $data_string = $name . "," . $duration . "," . $timestamp . ", " . $date . ";";
    //$data_string = $name ",". $duration . $timestamp  . $date ;

    //add time and name into body of insert
    $PB1 = "{\n    \"actor\": {\n\t    \"name\": \"".$name."\",\n\t    \"account\": {\n\t      \"homePage\": \"http://www.example.org\",\n\t      \"name\": \"example_user_id\"\n\t    }\n    },\n    ";
    $PB2 = "\"verb\": {\n        \"id\": \"http://adlnet.gov/expapi/verbs/watchedecho".$name;
    $PB3 = "\",\n        \"display\": {\n            \"en-US\": \"watchedecho\"\n        }\n    },\n    \"object\": {\n        \"id\": \"http://adlnet.gov/xapi/samples/xapi-jqm/course/03-steps\",\n        \"definition\": {\n            \"name\": {\n                \"en-US\": \"echo\"\n            },\n            \"description\": {\n";
    $PB4 = "\"en-US\": \"" .$data_string. "\"\n            }\n        },\n        \"objectType\": \"Activity\"\n    },\n    \"result\": {\n        \"score\": {\n";
    $PB5 = "\"raw\": ".$duration."\n        }\n    }\n\n}";

    $PostBody = $PB1 . $PB2 . $PB3 . $PB4 . $PB5;

    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://ec2-52-63-215-203.ap-southeast-2.compute.amazonaws.com/data/xAPI/statements",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
//        CURLOPT_POSTFIELDS => "{\n    \"actor\": {\n\t    \"name\": \"Kiara\",\n\t    \"account\": {\n\t      \"homePage\": \"http://www.example.org\",\n\t      \"name\": \"example_user_id\"\n\t    }\n    },\n    \"verb\": {\n        \"id\": \"http://adlnet.gov/expapi/verbs/watchedechokiara\",\n        \"display\": {\n            \"en-US\": \"watchedecho\"\n        }\n    },\n    \"object\": {\n        \"id\": \"http://adlnet.gov/xapi/samples/xapi-jqm/course/03-steps\",\n        \"definition\": {\n            \"name\": {\n                \"en-US\": \"echo\"\n            },\n            \"description\": {\n                \"en-US\": \"echo\"\n            }\n        },\n        \"objectType\": \"Activity\"\n    },\n    \"result\": {\n        \"score\": {\n            \"raw\": 70\n        }\n    }\n\n}",
        CURLOPT_POSTFIELDS => $PostBody,

        CURLOPT_HTTPHEADER => array(
            "Authorization: Basic ZTg0ODAzNjIxMTI5MzE3MTlmNTY3NDZmYWE1MWQ1Y2NjNzI5MjdiNzpiNTY0NmVmYTY5MGU1ODc3MDgzOGRhNzcxMjExNTllNjBhMmVhYTYx",
            "Cache-Control: no-cache",
            "Content-Type: application/json",
            "Postman-Token: f4c50643-b6ff-4b04-a285-048d08270248",
            "X-Experience-API-Version: 1.0.3"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        return "cURL Error #:" . $err;
    } else {
        return $response;
    }
}

function StaticGetEchoTimeUser(){

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "http://ec2-52-63-215-203.ap-southeast-2.compute.amazonaws.com/data/xAPI/statements?verb=http://adlnet.gov/expapi/verbs/watchedechotest",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "Authorization: Basic ZTg0ODAzNjIxMTI5MzE3MTlmNTY3NDZmYWE1MWQ1Y2NjNzI5MjdiNzpiNTY0NmVmYTY5MGU1ODc3MDgzOGRhNzcxMjExNTllNjBhMmVhYTYx",
        "Cache-Control: no-cache",
        "Postman-Token: 7ab1c317-911a-4ecc-a184-637ac48352c2",
        "X-Experience-API-Version: 1.0.1"
    ),
));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        return "cURL Error #:" . $err;
    } else {
        return $response;
    }
}

//Insert an xAPI statement into learning locker and return the statement ID
//dirty implementation of timestamp and date -> appending to the time and inserting single string into learning locker
function StaticInsert($name, $duration, $timestamp, $date, $title){

    $curl = curl_init();

    //string of name, time, timestamp and date - comma separated & semicolon ended.
    $data_string = $name . "," . $duration . "," . $timestamp . ", " . $date . ";";
    //$data_string = $name ",". $duration . $timestamp  . $date ;

    //add time and name into body of insert
    $PB1 = "{\n    \"actor\": {\n\t    \"name\": \"".$name."\",\n\t    \"account\": {\n\t      \"homePage\": \"http://www.example.org\",\n\t      \"name\": \"example_user_id\"\n\t    }\n    },\n    ";
    $PB2 = "\"verb\": {\n        \"id\": \"http://adlnet.gov/expapi/verbs/watchedecho".$name;
    $PB3 = "\",\n        \"display\": {\n            \"en-US\": \"watchedecho\"\n        }\n    },\n    \"object\": {\n        \"id\": \"http://adlnet.gov/xapi/samples/xapi-jqm/course/03-steps\",\n        \"definition\": {\n            \"name\": {\n                \"en-US\": \"echo\"\n            },\n            \"description\": {\n";
    $PB4 = "\"en-US\": \"" .$data_string. "\"\n            }\n        },\n        \"objectType\": \"Activity\"\n    },\n    \"result\": {\n        \"score\": {\n";
    $PB5 = "\"raw\": ".$duration."\n        }\n    }\n\n}";

    $PostBody = $PB1 . $PB2 . $PB3 . $PB4 . $PB5;

    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://ec2-52-63-215-203.ap-southeast-2.compute.amazonaws.com/data/xAPI/statements",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
//        CURLOPT_POSTFIELDS => "{\n    \"actor\": {\n\t    \"name\": \"Kiara\",\n\t    \"account\": {\n\t      \"homePage\": \"http://www.example.org\",\n\t      \"name\": \"example_user_id\"\n\t    }\n    },\n    \"verb\": {\n        \"id\": \"http://adlnet.gov/expapi/verbs/watchedechokiara\",\n        \"display\": {\n            \"en-US\": \"watchedecho\"\n        }\n    },\n    \"object\": {\n        \"id\": \"http://adlnet.gov/xapi/samples/xapi-jqm/course/03-steps\",\n        \"definition\": {\n            \"name\": {\n                \"en-US\": \"echo\"\n            },\n            \"description\": {\n                \"en-US\": \"echo\"\n            }\n        },\n        \"objectType\": \"Activity\"\n    },\n    \"result\": {\n        \"score\": {\n            \"raw\": 70\n        }\n    }\n\n}",
        CURLOPT_POSTFIELDS => $PostBody,

        CURLOPT_HTTPHEADER => array(
            "Authorization: Basic ZTg0ODAzNjIxMTI5MzE3MTlmNTY3NDZmYWE1MWQ1Y2NjNzI5MjdiNzpiNTY0NmVmYTY5MGU1ODc3MDgzOGRhNzcxMjExNTllNjBhMmVhYTYx",
            "Cache-Control: no-cache",
            "Content-Type: application/json",
            "Postman-Token: f4c50643-b6ff-4b04-a285-048d08270248",
            "X-Experience-API-Version: 1.0.3"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        return "cURL Error #:" . $err;
    } else {
        return $response;
    }
}
//this should still just return the times




function GetEchoTimeUser($name)
{

    $curl = curl_init();

    $URL = "http://ec2-52-63-215-203.ap-southeast-2.compute.amazonaws.com/data/xAPI/statements?verb=http://adlnet.gov/expapi/verbs/watchedecho".$name;


    curl_setopt_array($curl, array(
        CURLOPT_URL => $URL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Basic ZTg0ODAzNjIxMTI5MzE3MTlmNTY3NDZmYWE1MWQ1Y2NjNzI5MjdiNzpiNTY0NmVmYTY5MGU1ODc3MDgzOGRhNzcxMjExNTllNjBhMmVhYTYx",
            "Cache-Control: no-cache",
            "Postman-Token: 22de8806-70b4-4425-ac6f-24a32934eabf",
            "X-Experience-API-Version: 1.0.1"
        ),
    ));

    //Send query and save reply
    $response = curl_exec($curl);
    $err      = curl_error($curl);
    //Close Connection
    curl_close($curl);

    //Check if response worked
    if ($err) {
        echo "cURL Error #:" . $err;
    } else if ($response){
        //Extract percentage as integer from response
        $string = (string) $response;
        //Retrieve string after the string "raw" up to 50 characters long
        preg_match_all('/(?<=description":{"en-US":")[^;}]{1,50}/m', $string, $matches, PREG_SET_ORDER, 0);

        $echo_times = array();
        $echo_session_strings = array();
        //for each result pop to an array.
        foreach ($matches as $match) {
            //echo var_dump($match);
            //echo "<br>";
            array_push($echo_session_strings, $match[0]);
        }

        //process echo_session string into array of times
        //index variable
        $i = 0;
        foreach ($echo_session_strings as $string){
            //parse string on commas
            $session_Array = explode(',', $string);
            //change all durations to integer amount
            $echo_times[$i] = (int)$session_Array[1];
            $i++;
        }


        return $echo_times;
    } else {

            //dummy data
            return "no response";

            //$array = array([0] => 60, [1] => 0, [2] => 17, [3] => 20, [4] => 94, [5] => 33, [6] => 10, [7] => 85, [8] => 53, [9] => 40);
            //return $array;
    }
}

//returns an array of sessions info
// format: each element in array: [duration, timestamp, date] (strings)
//modified to expect the time returned from learning locker as a string of time, timestamp, date.
//retrieves strings of maximum 50 characters long
function GetEchoDataUser($name)
{

    $curl = curl_init();

    $URL = "http://ec2-52-63-215-203.ap-southeast-2.compute.amazonaws.com/data/xAPI/statements?verb=http://adlnet.gov/expapi/verbs/watchedecho".$name;


    curl_setopt_array($curl, array(
        CURLOPT_URL => $URL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Basic ZTg0ODAzNjIxMTI5MzE3MTlmNTY3NDZmYWE1MWQ1Y2NjNzI5MjdiNzpiNTY0NmVmYTY5MGU1ODc3MDgzOGRhNzcxMjExNTllNjBhMmVhYTYx",
            "Cache-Control: no-cache",
            "Postman-Token: 22de8806-70b4-4425-ac6f-24a32934eabf",
            "X-Experience-API-Version: 1.0.1"
        ),
    ));

    //Send query and save reply
    $response = curl_exec($curl);
    $err      = curl_error($curl);
    //Close Connection
    curl_close($curl);

    //Check if response worked
    if ($err) {
        echo "cURL Error #:" . $err;
    } else if ($response){
        //Extract percentage as integer from response
        $string = (string) $response;
        //Retrieve string after the string "raw" up to 50 characters long
        preg_match_all('/(?<=description":{"en-US":")[^;}]{1,50}/m', $string, $matches, PREG_SET_ORDER, 0);

        $echo_sessions = array(array());
        $echo_session_strings = array();
        //for each result pop to an array.
        foreach ($matches as $match) {
            //echo var_dump($match);
            //echo "<br>";
            array_push($echo_session_strings, $match[0]);
        }

        //process echo_session strings into array of arrays
        //index variable
        $i = 0;
        foreach ($echo_session_strings as $string){
            //parse string on commas
            $session_Array = explode(',', $string);
            //change all durations to integer amount
            $session_Array[1] = (int)$session_Array[1];
            $session_Array[3] = str_replace('/', '-', $session_Array[3]);
            $echo_sessions[$i] = $session_Array;
            $i++;
        }


        return $echo_sessions;
    } else {

        //dummy data
        return "no response";

        $array = array([0] => 60, [1] => 0, [2] => 17, [3] => 20, [4] => 94, [5] => 33, [6] => 10, [7] => 85, [8] => 53, [9] => 40);
        //return $array;
    }
}


//should return a single array of arrays (duration, timestamp, date)
function GetAllEchoData(){

    //return array of data for all students
    $AllEchoArray = array(array());
    //hashes being used from data set
    $hashes = [
        'a92aa38a05297c2960c37c75699c41a8',
        '872b7d573c52a73896be9c0ea6bdc6b3',
        '54d001105729d32c90e5ce47012df6ca',
        'ae595039b3670d1c67faa074b0aa05fc',
        '362b08cbef18e826ea663d30b5d04d40',
        '6356be2af8942824196216aee572c073',
        '6681bb0816a7d9234a1e348ddcc570e2',
        'af6bd8fe7e909679540a3406f78cacd3',
        '92f0e64800fc85ea4c3882c3a9eb50e0',
        'f97850ef12876c3e0c353685c3382bb4',
        '900c83b1d545bea4e1e480f4d7737110',
        '8d865e922d6850fd73a6b04e29cc4c99',
        'e5d6c91f6b778a465c305f67c4fda62e',
        'fa4c74d424c83ab22c3d062d1efa2777',
        '4fa361cff7617c7534ee7adc47fe00bd',
    ];

    foreach($hashes as $hash){
        return $singleUserArray = GetEchoDataUser("test4");
        //array_merge($AllEchoArray, $singleUserArray);
        array_push($AllEchoArray, $singleUserArray);
    }

    return $AllEchoArray;
}

//sort dates in order
function date_sort($a, $b) {
    return strtotime($a[3]) - strtotime($b[3]);
}

//average computed from number of hours/number of students IN THAT WEEK!
function AverageEchoTimes($AllEchoData){


    usort($AllEchoData, "date_sort");
    //convert  $AllEchoData;

    //init var for loop
    //$array[0][3] = str_replace('/', '-', $AllEchoData[0][3]);
    $date = strtotime($AllEchoData[0][3]);
    $week_total=0;
    $unique_students = array();
    $weekly_avgs = array();


    // loop through the array and calculate weekly average inserting into weekly_avg array
    //count number of days between each array element
    //average computed from number of hours/number of students IN THAT WEEK!
    for($i = 0; $i < count($AllEchoData); $i++) {
        // calculate the number of days since start
        $week_days_count = (strtotime($AllEchoData[$i][3]) - ($date)) / (60 * 60 * 24);

        if (in_array($AllEchoData[$i][0], $unique_students)) {

        } else {
            //add student id to unique list
            array_push($unique_students, $AllEchoData[$i][0]);
        }


        if($week_days_count > 7) {
            //append weekly average = totals/unique

            if (count($unique_students)==0){
                array_push($weekly_avgs, ($week_total));
            } else {
                array_push($weekly_avgs, ($week_total)/(count($unique_students)));
            }

            $week_total = (int)$AllEchoData[$i][1];

            $unique_students = NULL;
            //array_push($unique_students, $AllEchoData[$i][0]);

            //this sets the new date as the next time period - not necessarily the next week.
            $date = strtotime($AllEchoData[$i][3]);
        } else {
            //update the weekly total
            //if unique student add to list of students
            $week_total += (int)$AllEchoData[$i][1];
        }


        //array_push($weekly_avgs, $week_total);


    }
    return $weekly_avgs;
}

//compute the weekly averages for a single student
function AverageEchoTimeUser($name, $AllEchoData){

    //Single student data
    $SingleStudentData = array(array());
    //extract student from all echo data
    for($i = 0; $i < count($AllEchoData); $i++) {
        if ($AllEchoData[$i][0] == $name){
            array_push($SingleStudentData, $AllEchoData[$i]);
        }
    }
    //sort dates in order
    function date_sort($a, $b) {
        return strtotime($a[3]) - strtotime($b[3]);
    }
    usort($SingleStudentData, "date_sort");

    //init var for loop
    $date = strtotime($SingleStudentData[0][3]);
    $week_total=0;
    $weekly_avgs = array();

    for($i = 0; $i < count($SingleStudentData); $i++) {
        // calculate the number of days since start
        $week_days_count = (strtotime($SingleStudentData[$i][3]) - strtotime($date));

        if($week_days_count > 7) {
            //append weekly average = totals/unique
            array_push($weekly_avgs, ($week_total));
            $week_total=0;
            $date = $SingleStudentData[$i][3];
        } else {
            //update the weekly total
            $week_total += $SingleStudentData[$i][0];
        }
    }

    return $weekly_avgs;

}

 /////////////////////////////////////////////////////////
//Unit tests - basic functionality tests ////////////////

//insertechodata test:
    //test that no errors are returned.
function UTInsert(){
    $name = "test2";
    $duration = "100";
    $timestamp = "1:30AM";
    $date = "3/12/2018";
    $title = "cab202 week1";
    return InsertEchoTimeStatement($name, $duration, $timestamp, $date, $title);
}

//GetEchoTime & Insert test:

function UTGetEchoTimeUSer(){
    $name = "test3";

    return GetEchoTimeUser($name);
}


//GetEchoDataUser:
//assumes data is already imported for real hashes

function UTGetEchoDataUser(){
    $name = "test3";
    return GetEchoDataUser($name);
}

//GetAllEchoData:

function UTGetAllEchoData(){
    return GetAllEchoData();
}

//AverageEchoTimes:

function UTAverageEchoTimes(){
    return AverageEchoTimes(GetAllEchoData());
}

//AverageEchoTimeUser:

function UTAverageEchoTimeUser(){
    $name = "test3";

    return AverageEchoTimeUser($name, GetAllEchoData());
}

