<?php

/* //Examples of how to use functions...
$name="Ben";
$time=60;
//input the users name and time spent on particular echo session. Don't need to store the $ID for now.
ID = InsertEchoTimeStatement($name, $time);
//Returns an array of session time results for a particular user. Name is a dummy variable for now.
//$results = GetTimePercentage($name, 30);
$results = GetTimePercentage();
 */
/* $name="Ben";
$time=60;
$ID = InsertEchoTimeStatement($name, $time);
 */

//echo var_dump(GetEchoTime());
function InsertEchoTimeStatement($name, $time){

    $curl = curl_init();


    //add time and name into body of insert
    $PB1 = "{\n    \"actor\": {\n\t    \"name\": \"".$name."\",\n\t    \"account\": {\n\t      \"homePage\": \"http://www.example.org\",\n\t      \"name\": \"example_user_id\"\n\t    }\n    },\n    ";
    $PB2 = "\"verb\": {\n        \"id\": \"http://adlnet.gov/expapi/verbs/watchedecho".$name;
    $PB3 = "\",\n        \"display\": {\n            \"en-US\": \"watchedecho\"\n        }\n    },\n    \"object\": {\n        \"id\": \"http://adlnet.gov/xapi/samples/xapi-jqm/course/03-steps\",\n        \"definition\": {\n            \"name\": {\n                \"en-US\": \"echo\"\n            },\n            \"description\": {\n                \"en-US\": \"echo\"\n            }\n        },\n        \"objectType\": \"Activity\"\n    },\n    \"result\": {\n        \"score\": {\n";
    $PB4 = "\"raw\": ".$time."\n        }\n    }\n\n}";

    $PostBody = $PB1 . $PB2 . $PB3 . $PB4;

    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://ec2-52-63-89-189.ap-southeast-2.compute.amazonaws.com/data/xAPI/statements",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $PostBody,
        CURLOPT_HTTPHEADER => array(
            "Authorization: Basic MzdhZGEyNDQzNDQzNjU0MTFjOTBjNGVkOWM0Y2RkNDNkNGFmMzI5YzphZjA5Njg5ODY2MjUwNjQ1ODRiZWVlN2NmYmVmOTA5ZDRjODhkODFm",
            "Cache-Control: no-cache",
            "Content-Type: application/json",
            "Postman-Token: b9ae6949-cab3-4eab-b2e6-97380696b026",
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


//returns the statement ID to be used in GetRiskPercentage
function InsertEchoTimeStatementDepricated($name, $time)
{

    $curl = curl_init();

    //add risk value into body of insert
    $PostBody = "{\n    \"actor\": {\n\t    \"name\": \"" . $name;

    //$time variable inserted into next line
    $PostBody2 =  "\",\n\t    \"account\": {\n\t      \"homePage\": \"http://www.example.org\",\n\t      \"name\": \"example_user_id\"\n\t    }\n    },\n    \"verb\": {\n        \"id\": \"http://adlnet.gov/expapi/verbs/scored\",\n        \"display\": {\n            \"en-US\": \"scored\"\n        }\n    },\n    \"object\": {\n        \"id\": \"http://adlnet.gov/xapi/samples/xapi-jqm/course/03-steps\",\n        \"definition\": {\n            \"name\": {\n                \"en-US\": \"assessment\"\n            },\n            \"description\": {\n                \"en-US\": \"assessment\"\n            }\n        },\n        \"objectType\": \"Activity\"\n    },\n    \"result\": {\n        \"score\": {\n            \"raw\":".$time."\n        }\n    }\n\n}";
    //$PostBody2 = "\",\n\t    \"account\": {\n\t      \"homePage\": \"http://www.example.org\",\n\t      \"name\": \"example_user_id\"\n\t    }\n    },\n    \"verb\": {\n        \"id\": \"http://adlnet.gov/expapi/verbs/watchedecho".$name."\",\n        ";

    //$PostBody3 = "\"display\": {\n            \"en-US\": \"watchedecho\"\n        }\n    },\n    \"object\": {\n        \"id\": \"http://adlnet.gov/xapi/samples/xapi-jqm/course/03-steps\",\n        \"definition\": {\n            \"name\": {\n                \"en-US\": \"echo\"\n            },\n            \"description\": {\n                \"en-US\": \"echo\"\n            }\n        },\n        \"objectType\": \"Activity\"\n    },\n    \"result\": {\n        \"score\": {\n            \"raw\": " . $time . "\n        }\n    }\n\n}";
    //$PostBody4 = $PostBody . $PostBody2 . $PostBody3;
    $PostBody4 = $PostBody . $PostBody2;
    //create POST request
    curl_setopt_array($curl, array(
        CURLOPT_URL            => "http://ec2-13-210-217-192.ap-southeast-2.compute.amazonaws.com/data/xAPI/statements",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING       => "",
        CURLOPT_MAXREDIRS      => 10,
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST  => "POST",
        CURLOPT_POSTFIELDS     => $PostBody4,
        CURLOPT_HTTPHEADER => array(
            "Authorization: Basic MzdhZGEyNDQzNDQzNjU0MTFjOTBjNGVkOWM0Y2RkNDNkNGFmMzI5YzphZjA5Njg5ODY2MjUwNjQ1ODRiZWVlN2NmYmVmOTA5ZDRjODhkODFm",
            "Cache-Control: no-cache",
            "Content-Type: application/json",
            "Postman-Token: b9ae6949-cab3-4eab-b2e6-97380696b026",
            "X-Experience-API-Version: 1.0.3"
        ),
    ));





    $response = curl_exec($curl);
    $err      = curl_error($curl);
//$err = false;
//$response = false;
    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else if ($response){

        //get the ID without quotes
        $string = (string) $response;
        preg_match('/".*?"/', $string, $matches, PREG_OFFSET_CAPTURE);

        //convert to string
        $statementIDArr = $matches[0];
        $statementID    = (string) $statementIDArr[0];
        $statementID    = str_replace('"', "", $statementID);
        //echo $statementID;

        return $statementID;
    } else {
        return "no response";
    }

}

function GetEchoTimeUser($name)
{

    $curl = curl_init();

    $URL = "http://ec2-52-63-89-189.ap-southeast-2.compute.amazonaws.com/data/xAPI/statements?verb=http://adlnet.gov/expapi/verbs/watchedechokiara".$name;


    curl_setopt_array($curl, array(
        CURLOPT_URL => $URL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Basic MzdhZGEyNDQzNDQzNjU0MTFjOTBjNGVkOWM0Y2RkNDNkNGFmMzI5YzphZjA5Njg5ODY2MjUwNjQ1ODRiZWVlN2NmYmVmOTA5ZDRjODhkODFm",
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
        //Retrieve number after the string "raw"
        preg_match_all('/(?<=raw":)[^}]{1,3}/m', $string, $matches, PREG_SET_ORDER, 0);

        $times = array();
        //for each result pop to an array.
        foreach ($matches as $match) {
            //echo var_dump($match);
            //echo "<br>";
            array_push($times, (int) $match[0]);
        }
        return $times;
    } else {

//dummy data
//        if ($hash="872b7d573c52a73896be9c0ea6bdc6b3"){
//            $array = array([0] => 60, [1] => 0, [2] => 17, [3] => 20, [4] => 94, [5] => 33, [6] => 10, [7] => 85, [8] => 53, [9] => 40);
//            return $array;
//        } else if ($hash="54d001105729d32c90e5ce47012df6ca") {
//            $array = array([0] => 35, [1] => 20, [2] => 73, [3] => 94, [4] => 9, [5] => 8, [6] => 54, [7] => 45, [8] => 59, [9] => 45);
//            return $array;
//        } else if ($hash="ae595039b3670d1c67faa074b0aa05fc") {
//            $array = array([0] => 74, [1] => 35, [2] => 27, [3] => 45, [4] => 19, [5] => 38, [6] => 59, [7] => 18, [8] => 50, [9] => 4);
//            return $array;
//        } else if ($hash="362b08cbef18e826ea663d30b5d04d40") {
//            $array = array([0] => 6, [1] => 0, [2] => 7, [3] => 2, [4] => 9, [5] => 3, [6] => 1, [7] => 8, [8] => 5, [9] => 4);
//            return $array;
//        } else {
//            $array = array([0] => 6, [1] => 0, [2] => 7, [3] => 2, [4] => 9, [5] => 3, [6] => 1, [7] => 8, [8] => 5, [9] => 4);
//            return $array;
//        }

    }
    return "no response";
}


function GetEchoTimeUserdepricated($name)
{
    $curl = curl_init();
    $URL = "http://ec2-52-63-89-189.ap-southeast-2.compute.amazonaws.com/data/xAPI/statements?verb=http://adlnet.gov/expapi/verbs/watchedechokiara".$name;
    //Create query packet to send to LL
    curl_setopt_array($curl, array(
        CURLOPT_URL            => $URL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING       => "",
        CURLOPT_MAXREDIRS      => 10,
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST  => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Basic MzdhZGEyNDQzNDQzNjU0MTFjOTBjNGVkOWM0Y2RkNDNkNGFmMzI5YzphZjA5Njg5ODY2MjUwNjQ1ODRiZWVlN2NmYmVmOTA5ZDRjODhkODFm",
            "Cache-Control: no-cache",
            "Postman-Token: ce8246d6-0f33-4b5b-9441-08cf7bb772c4",
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
        //Retrieve number after the string "raw"
        preg_match_all('/(?<=raw":)[^}]{1,3}/m', $string, $matches, PREG_SET_ORDER, 0);

        $times = array();
        //for each result pop to an array.
        foreach ($matches as $match) {
            //echo var_dump($match);
            //echo "<br>";
            array_push($times, (int) $match[0]);
        }
        return $times;
    } else {

//dummy data
//        if ($hash="872b7d573c52a73896be9c0ea6bdc6b3"){
//            $array = array([0] => 60, [1] => 0, [2] => 17, [3] => 20, [4] => 94, [5] => 33, [6] => 10, [7] => 85, [8] => 53, [9] => 40);
//            return $array;
//        } else if ($hash="54d001105729d32c90e5ce47012df6ca") {
//            $array = array([0] => 35, [1] => 20, [2] => 73, [3] => 94, [4] => 9, [5] => 8, [6] => 54, [7] => 45, [8] => 59, [9] => 45);
//            return $array;
//        } else if ($hash="ae595039b3670d1c67faa074b0aa05fc") {
//            $array = array([0] => 74, [1] => 35, [2] => 27, [3] => 45, [4] => 19, [5] => 38, [6] => 59, [7] => 18, [8] => 50, [9] => 4);
//            return $array;
//        } else if ($hash="362b08cbef18e826ea663d30b5d04d40") {
//            $array = array([0] => 6, [1] => 0, [2] => 7, [3] => 2, [4] => 9, [5] => 3, [6] => 1, [7] => 8, [8] => 5, [9] => 4);
//            return $array;
//        } else {
//            $array = array([0] => 6, [1] => 0, [2] => 7, [3] => 2, [4] => 9, [5] => 3, [6] => 1, [7] => 8, [8] => 5, [9] => 4);
//            return $array;
//        }

    }
    return "no response";
}

//Dummy function to return an array of "values" which will be echo time spent per session
/* function GetTimePercentage($numPoints){
$array = array();

foreach(range(0, $numPoints) as $i) {
$array[] = rand();
}
return $array;
} */
