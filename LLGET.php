<?php

//Example of how to use these functions... 
$ID = InsertRiskStatement(30);

$result = GetRiskPercentage($ID);

//echo (string)$result;


//returns the statement ID to be used in GetRiskPercentage
function InsertRiskStatement($risk){
    
    $curl = curl_init();

    //add risk value into body of insert
    $PostBody = "{\n    \"actor\": {\n\t    \"name\": \"Kiara\",\n\t    \"account\": {\n\t      \"homePage\": \"http://www.example.org\",\n\t      \"name\": \"example_user_id\"\n\t    }\n    },\n    \"verb\": {\n        \"id\": \"http://adlnet.gov/expapi/verbs/scored\",\n        \"display\": {\n            \"en-US\": \"scored\"\n        }\n    },\n    \"object\": {\n        \"id\": \"http://adlnet.gov/xapi/samples/xapi-jqm/course/03-steps\",\n        \"definition\": {\n            \"name\": {\n                \"en-US\": \"assessment\"\n            },\n            \"description\": {\n                \"en-US\": \"assessment\"\n            }\n        },\n        \"objectType\": \"Activity\"\n    },\n    \"result\": {\n        \"score\": {\n            \"raw\":".$risk."\n        }\n    }\n\n}";

    //create POST request
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://ec2-13-210-217-192.ap-southeast-2.compute.amazonaws.com/data/xAPI/statements",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $PostBody,
        CURLOPT_HTTPHEADER => array(
        "Authorization: Basic OWZjMTI5YjY0ZTA2MTYxMTRkOGYyNzYxY2VjMGNmOGJkZWUwZDdhZDo1MmI5NDkyNDJiYzk4ZTJkMTM3ZDU3ODBhNmQ1MDk0NTA0MzJkMTMy",
        "Cache-Control: no-cache",
        "Content-Type: application/json",
        "Postman-Token: 1c1c95d6-4fd9-4e16-b0a3-9ecb30e000cc",
        "X-Experience-API-Version: 1.0.3"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
    echo "cURL Error #:" . $err;
    } else {

    //get the ID without quotes
    $string = (string)$response;
    preg_match('/".*?"/', $string, $matches, PREG_OFFSET_CAPTURE);

    //convert to string
    $statementIDArr = $matches[0];
    $statementID = (string)$statementIDArr[0];
    $statementID = str_replace('"', "", $statementID);
    //echo $statementID;

    return $statementID;
    }

}

function GetRiskPercentage($statementID){
    $curl = curl_init();

    $URL = "http://ec2-13-210-217-192.ap-southeast-2.compute.amazonaws.com/data/xAPI/statements?statementId=".$statementID;

    //echo var_dump($URL);
    //Create query packet to send to LL
    curl_setopt_array($curl, array(
        CURLOPT_URL => $URL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
        "Authorization: Basic OWZjMTI5YjY0ZTA2MTYxMTRkOGYyNzYxY2VjMGNmOGJkZWUwZDdhZDo1MmI5NDkyNDJiYzk4ZTJkMTM3ZDU3ODBhNmQ1MDk0NTA0MzJkMTMy",
        "Cache-Control: no-cache",
        "Postman-Token: d935ed8d-027b-4745-a8b9-7b4e750cfbdd",
        "X-Experience-API-Version: 1.0.1"
        ),
    ));

    //echo var_dump($curl);
    //Send query and save reply
    $response = curl_exec($curl);
    $err = curl_error($curl);

    //Close Connection
    curl_close($curl);

    //Check if response worked
    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        //echo var_dump($response);
        //Extract percentage as integer from response
        $string = (string)$response;
 
        //Retrieve number after the string "raw"
        preg_match('/(?<=raw":)[^}]{1,3}/', $string, $matches, PREG_OFFSET_CAPTURE);

        //convert to int
        $percentArray = $matches[0];
        $percentage = (int)$percentArray[0];

        //this is the final percentage to be used for course signal GUI... 
        //echo (string)$percentage;
        return $percentage;
    }
}

?>