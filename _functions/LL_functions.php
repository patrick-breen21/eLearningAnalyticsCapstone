<?php

/*
These functions provide an interface with learning locker.
Functionality includes inserting and querying the learning locker db.
 */

function InsertEchoTimeStatement($name, $duration, $timestamp, $date, $title, $totalDuration, $unit, $verb){

    $curl = curl_init();
//    $name = "george";
//    $duration = "50";
//    $timestamp = "11:30AM";
//    $date = "21/2/18";
//    $title = "";
//    $totalDuration = "";
    $date = str_replace('/', '-', $date);

    $name = $name;

    //string of name, time, timestamp and date - comma separated & semicolon ended.
    $data_string = $name . "," . $duration . "," . $timestamp . ", " . $date . ", " .$unit. ", " . $verb . ";";
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
            "Authorization: Basic NDEzODczNWIxMTg0NjIwY2ZmYzVkYjk4YWY4YmVhMzcwODYyZGQ2Nzo1Mzk3YWE3NDRhYjJjMmNmZWIzMDZiNDkzOWNjMmRmZmU1MThmMjVh",
            "Cache-Control: no-cache",
            "Content-Type: application/json",
            "Postman-Token: 2f9b0374-8c2e-4153-be03-0430171f0d94",
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
        "Authorization: Basic NDEzODczNWIxMTg0NjIwY2ZmYzVkYjk4YWY4YmVhMzcwODYyZGQ2Nzo1Mzk3YWE3NDRhYjJjMmNmZWIzMDZiNDkzOWNjMmRmZmU1MThmMjVh",
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
function StaticInsert($name, $duration, $timestamp, $date, $title, $totalDuration){

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
            "Authorization: Basic NDEzODczNWIxMTg0NjIwY2ZmYzVkYjk4YWY4YmVhMzcwODYyZGQ2Nzo1Mzk3YWE3NDRhYjJjMmNmZWIzMDZiNDkzOWNjMmRmZmU1MThmMjVh",
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
            "Authorization: Basic NDEzODczNWIxMTg0NjIwY2ZmYzVkYjk4YWY4YmVhMzcwODYyZGQ2Nzo1Mzk3YWE3NDRhYjJjMmNmZWIzMDZiNDkzOWNjMmRmZmU1MThmMjVh",
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
        preg_match_all('/(?<=description":{"en-US":")[^;}]{1,200}/m', $string, $matches, PREG_SET_ORDER, 0);

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
            "Authorization: Basic NDEzODczNWIxMTg0NjIwY2ZmYzVkYjk4YWY4YmVhMzcwODYyZGQ2Nzo1Mzk3YWE3NDRhYjJjMmNmZWIzMDZiNDkzOWNjMmRmZmU1MThmMjVh",
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
        preg_match_all('/(?<=description":{"en-US":")[^;}]{1,200}/m', $string, $matches, PREG_SET_ORDER, 0);

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
        return array();

        //$array = array([0] => 60, [1] => 0, [2] => 17, [3] => 20, [4] => 94, [5] => 33, [6] => 10, [7] => 85, [8] => 53, [9] => 40);
        //return $array;
    }
}


//should return a single array of arrays (duration, timestamp, date)
function GetAllEchoData(){

    //return array of data for all students
    $AllEchoArray = array(array());
    //hashes being used from data set
    $hashes = [
            "test4",
        "George",

        "ben",
        "kiara",
    "patty",
        "test9",
        "test10",
        "test11",
        "test12",
        "test13",
        "test14",
        "test15",
        "test16",
        "test17",
        "test18",
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
        'd60379e6bf7e7ecb767e337bb7685888',
        '95d53fc95b4461325a0b78ab40d228d1',
        'a6b6d022df0cc0eab11228fef61703a8',
        '78aaa676e1feee296b6c5670ee34c9bd',
        '6f99e98dbc813044a9692dfd003d36fe',
        '40b4a0b6a2f53e58a51fbc6327d5b287',
        'a51a13f406ee1572696c47fdf0f2dd2d',
        '28719c9931270ad08ae4c5c3b1442e78',
        '10c84f981dbb8ec043e20047e5c35863',
        '2298ceb1b8786831e6f68aab2c9e55ac',
        'ece448ff001e253864a737ff69f3a7aa',
        'dc132777938086d0029e5472b5f9e4ad',
        '760d117fe643abdad707ffcf40ffb0d7',
        '5c5f54fd3605d401fdf0c55f512a98ac',
        'fdb919d5bcfed3774f0525fd0e9ac0d5',
        'aad9b5ee4ce172f7438807b6101a8d38',
        '5c3ec5ca4f2dfb435895bbae1103af46',
        'dbd75d91d16da1bcae3f96cb3f17cb84',
        'c68f272fd4b15f49b88d15c3d00fccee',
        '52de8bbaed3fb1a2ffd01fac93e145ce',
'61fd3fb6f372955857da817828c92f0b',
'3c82336e8fe08dabfc31c05e60763f57',
'912aff9b8e09dc90343107f5b7076932',
'a4078b4e0868e249a472398e25dd01e0',
'39ccc89d8b0d00ce1675a802ba596dac',
'c2e187332f1447ce123e87737191cce3',
'c5982233229074b2d8b819aa181dd721',
'4d624eb4af549bf8abe5759f9f745e51',
'7519f848881c3490536ee07a1d67d61c',
'86a484fcf67daa2afd66148d0d854302',
'9458d15090e7384bc301434c7450494d',
'b98826bcc5e92b726a18550b717ce51f',
'505635dc792f2c46b4788fa6d1c3cae5',
'05cc651becf646117f283274104f9538',
'15e61596bad9a9e2c2418d6813015cae',
'4a50bdf5f7d393667d84c711946d3c70',
'6d9c6a3b444a4bafd04858f22982cfc6',
'd6119bff90a38d7a2e3fdfb740091df9',
'aca6877f401772e78812a4a9c6ffd7cd',
'c4a97e845f4edd0962ac96df3b0371cf',
'08092e02dd04c5a69cb6429e88b93c5b',
'9abee4ffd4139e565ca65added9be515',
'e6950bd6be66ae469a6de5ddafcff004',
'52d6dcd3304ae4dadabec3d9e8969afe',
'c615820b26578030ccaf0c41498d850e',
'b2f4a8d6b26913679a45c5da0fc689e2',
'45646308478c613f7b8307ce25c727a0',
'604a3087e92401bc17ba3a07873ccdcb',
'48a9873f4bf7d3fd032e9142174ab211',
'14071a2586761833cfc88117fcd9afce',
'0f26f2173426ac4ca8c5c76b37328f63',
'00a2097c10b57ee652394e93706c29bb',
'b5fa4a406149d65c394295a5b33456eb',
        '6c00bbe8aa1c441b8663c268b61cb862',
'147051f8c5332aadd2dba9fc339b3453',
'54c50af26603a124427c5ce4fb9b921a',
'7df38f37399efd3032a3e4daf32e5545',
'8c7a14112f4ca063c660616d9ac7fc02',
'a42dacfb2cef2cafd9c47590eda57f89',
'6974fb077abbed36a7ad74c2b4ccdea4',
'134c995cad2337843ead9bd89e36df6e',
'9e7b4ce8599e16cda7cc5175bd071ba1',
'3d6b18c1da4da7c3b6d3de62316b44a5',
'ee87ca073aeaeb0940af8ccb096ae645',
'5e7fba6bea26cff768f6a23de1bf3cad',
'72b110c15f6f993bb0afc38d72fff3c1',
'4377574d5ded0af5922589ba03b0b15d',
'74b0d2041f309c9dd034c46406cb0119',
'4eeefd3003192c56495cad3a6c44c596',
'f13e26def316357aa8cc9ab7d3485c7c',
'5b2dde87818c12eed2dfc4f4c9f7ca4a',
'ef3eeff2d4b626bd7fe43de23d40bc3b',
'9cbb99e504afc446794e558fdd53a388',
'4220d3bc378df815ea6d42f637516133',
'ede05165b9da2dfd8ad639422bead6ac',
'f6bf66854c2f262293439ea4bba0653c',
'adce36d6d625754870fc519e2d1b0af2',
'40b0434e624f3932cf9ebe10191285d1',
'320e10eca7ce566912d0952471a975d8',
'7c9fa4d863c7f5f56922e4e18f422a30',
'adc2f9f24231162612a01a4e66bc6ec5',
'f7e0652b62e35f230a70f1ec683f827e',
'cef1841a628e0bb6e7ff7aad87cbb736',
'b7c7ed5b6a03817052931f5630f7d35c',
'a1177b9d30582ceea4894db3a5d91610',
'51d62e6b595b153d636743d6b4d97a2d',
'82f304812bcb06a597ca2859002ac867',
'c39a9dcdf53869af8c04514048395922',
'063cc03b4fa57b020c97f72fd57054eb',
'760fc94cc4230c6956285bd31a0c4727',
'c04a7b5e2783607853e299d2599ea4be',
'4814c5abddbfc69e50b183a01f08d70f',
'161a293308cd95e19b11282a823a69c5',
'4bccadeded341fde10ffb757e5b9427a',
'1f68e475caa2f3c6b11f61d618f6cc84',
'6631a19fecc974f8e04e621517cf2e59',
'71bb4cdc646a3ec0698aec98aeb3ca96',
'b367f3ec54887aeb27e440cffa6b7639',
'68c4c45afcbb8e1f9623ca1d32e12e48',
'9f84f3e6897b050e6e972f2781ea6377',
'8fa81292f129bcf1a4da6eb3c633b748',
'208558aba0cf8450971ab2bab72471a6',
'28a465c576d7691c0d96ee5e501ab46f',
'8c9a769e930f96b9569d7a8ca1300086',
'8b08df61db224882e51d78815cca7873',
'4e546b78cdf92629fd1c8bdb7ef9a274',
'2cdd4771fa3fb6baf685242425f310e2',
'236f67b325ad54fc623eb6a8a5dbd964',
'257e0c3e7ca3b68c4961db8a0b2f444a',
'a74ed074199c59b90d90e30bd20b6ebd',
'f618272b2597e606ba277a75f01ebbe0',
'45be10d82c7bcf05e9aad2c41d512b29',
'f49196d0f6231ddceb7e52f1720f615e',
'c4138ae43ad2db3030b2ea668c7f79f7',
'c91e83218d1079d3bc9c78f1d4cc669f',
'd2a0e944962423a057ed1cadab5b4bc9',
'b7778679f4f1a7af41c54511b7f4cc3d',
'b92f73741488e1dea16caa700c03a3eb',
'b124e80cc26c757a731bcb70dd5a82d3',
'1bef5b026ac2ff74b407d6ced19278ad'

    ];


    foreach($hashes as $hash){
        $singleUserArray = GetEchoDataUser($hash);
        if (count($singleUserArray[0]) > 0) {
            $AllEchoArray = array_merge($AllEchoArray, $singleUserArray);
            //array_push($AllEchoArray, $singleUserArray);
        }
    }
    array_shift($AllEchoArray);
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
    $weekly_avgs = array(array());

    // loop through the array and calculate weekly average inserting into weekly_avg array
    //count number of days between each array element
    //average computed from number of hours/number of students IN THAT WEEK!
    for($i = 0; $i < count($AllEchoData); $i++) {

        //run code if entry is not zero
        if (!empty($AllEchoData[$i])) {
//        if (($AllEchoData[$i][1] != 0)) {


            // calculate the number of days since start
            $week_days_count = (strtotime($AllEchoData[$i][3]) - ($date)) / (60 * 60 * 24);
            //array_push($weekly_avgs, (string)$week_days_count );
            array_push($unique_students, $AllEchoData[$i][0]);
            $number_of_unique = count(array_count_values($unique_students));


            if ($week_days_count > 7) {
                //append weekly average = totals/unique

//                $testarray = array((($week_total)/(($number_of_unique))), $AllEchoData[$i][0],  $number_of_unique);
//                array_push($weekly_avgs, $testarray);

                array_push($weekly_avgs, (int)(($week_total)/(($number_of_unique))));
                $week_total = (int)$AllEchoData[$i][1];
                $unique_students = NULL;
                $unique_students = array();
                //this sets the new date as the next time period - not necessarily the next week.
                $date = strtotime($AllEchoData[$i][3]);
            } else {
                //update the weekly total
                //if unique student add to list of students
                $week_total += (int)$AllEchoData[$i][1];
            }
        }
    }

    //why is first element 0? to do with the days count if statement.
    //because I'm initializing and empty array there are null elements.
    array_shift($weekly_avgs);
    //array_shift($weekly_avgs);

//    //add dummy data for array length could use while loop
//    if(count($weekly_avgs) < 10){
//        for($i = 0; $i < count($weekly_avgs);$i++){
//            array_push($weekly_avgs, rand(10, 300));
//        }
//    }
    return $weekly_avgs;
//    return $unique_students;
}

//compute the weekly averages for a single student
function AverageEchoTimeUser($name, $AllEchoData){


    $AllEchoData = GetEchoDataUser($name);

    usort($AllEchoData, "date_sort");
    //convert  $AllEchoData;

    //init var for loop
    //$array[0][3] = str_replace('/', '-', $AllEchoData[0][3]);
    $date = strtotime($AllEchoData[0][3]);
    $week_total=0;
    $weekly_avgs = array();


    // loop through the array and calculate weekly average inserting into weekly_avg array
    //count number of days between each array element
    //average computed from number of hours/number of students IN THAT WEEK!
    for($i = 0; $i < count($AllEchoData); $i++) {
        // calculate the number of days since start
        $week_days_count = (strtotime($AllEchoData[$i][3]) - ($date)) / (60 * 60 * 24);
        if($week_days_count > 7) {
            //append weekly average = totals/unique
            array_push($weekly_avgs, ($week_total));
            $week_total = (int)$AllEchoData[$i][1];
            //this sets the new date as the next time period - not necessarily the next week.
            $date = strtotime($AllEchoData[$i][3]);
        } else {
            //update the weekly total
            //if unique student add to list of students
            $week_total += (int)$AllEchoData[$i][1];
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
    return InsertEchoTimeStatement($name, $duration, $timestamp, $date, $title, $title, $duration, $name);
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

//Test for Average echo data

function UTAverageCalcCheck(){

    $name = "test";
    $duration = "10";
    $timestamp = "11:30AM";
    $title = "title";
    $totalDuration = 60;

//    for($i=14; $i < 16; $i++) {
//        $name = "test" . (string)$i;
//        InsertEchoTimeStatement($name, $duration, $timestamp, "01/01/2018", $title, $totalDuration);
//        InsertEchoTimeStatement($name, $duration, $timestamp, "9/1/2018", $title, $totalDuration);
////        InsertEchoTimeStatement($name, $duration, $timestamp, "9/1/2018", $title, $totalDuration);
//        InsertEchoTimeStatement($name, $duration, $timestamp, "17/1/2018", $title, $totalDuration);
//        InsertEchoTimeStatement($name, $duration, $timestamp, "27/3/2018", $title, $totalDuration);
//    }
//
//    for($i=16; $i < 18; $i++) {
//        $name = "test" . (string)$i;
//        InsertEchoTimeStatement($name, $duration, $timestamp, "01/01/2018", $title, $totalDuration);
//
//        InsertEchoTimeStatement($name, $duration, $timestamp, "10/3/2018", $title, $totalDuration);
//    }


    return AverageEchoTimes(GetAllEchoData());

}

//return the results for a particular students chosen unit
//Output: array of arrays
function GetStudentTimeUnit($name, $unit)
{
    $result = array();
    $query = GetEchoDataUser($name);
    foreach ($query as $entry) {
        $str = str_replace(' ','',$entry[4]);
        if ($str == $unit) {
            array_push($result, $entry[1]);
        }
    }

    return $result;
}

//return the results for a particular students chosen unit
//Output: array of arrays
function GetStudentTimeVerb($name, $verb)
{
    $result = array();
    $query = GetEchoDataUser($name);
    foreach ($query as $entry) {
        $str = str_replace(' ','',$entry[5]);
        if ($str == $verb) {
            array_push($result, $entry[1]);
        }
    }
    return $result;
}


    //3abf3ade641e3ecc12ee8c86ce28b96f
    //5aed6e68cfa3fd624861dab50dfcf177
    //a54fc34405fb1de04a464cd5cbfa3993
    //d7d032ebf520f3529ff2355fe8fce968
    //610144e30347da69073601272a979079
    //681cfa1281b289af4ccbbf949dc07ce8
    //42dce1de5af33f5b408ce26cde7c8909
    //cf57fb5f0e92048593d3c0c85e3caac8
    //d2ebf903da5a930ff4d67b828872db6d
    //3a33971093542d65bbe0f466dec6aa66
    //053d4597bd3720f20bb8df2bfbe44612
    //87b51e1872658295d5663e7b8f7c3f83
    //0f71c4308af69d6e8515b19b249557d0
    //dfede65c23f25fb74d95dbeb68226596
    //c9754a5755c28442062eb3029cb3ae98
    //c3e7d003037826efbe0e5093539bee1f
    //f20b027358eecde80c2499382445903c
    //d78c360135a870638afa1655064873b3
    //829d7760c2e0c9e6511a97789973e1ee
    //8ae680d9a98e63b5d3e460829c2d8f4f
    //9526814b17c5cb73b8029f6996f67770
    //36e645594ba0e861e86578d7635952cd
    //780ec9deee65743a76da0958b7f338a6
    //6332962d27b5ddf8f8d464adf1cb1bba
    //a06bc4242b3559060e833f090aa4c4f4
    //b64dcfa8a347ca125aab33357f16348d
    //c8f113f85b14b3d7b50064defdbb3778
    //842de96fb29a5294772e5446242f0251
    //0aa3fb671f082abd396353ab751d62dd
    //565ff769866d5a0eed6134f161e84508
    //b0f601df7abf7f294b377db1bc7457dd
    //d129f5b248c258a179492e8e8116094b
    //fcf88d1194b20c245952c5c437311e51
    //9c00b70e4a9edb629f517a39ddb4e8dc
    //8ba2dee937c6a8245f0b0128ddbc4111
    //c0913468a95726dde058d92796c1a5cd
    //d07083ce5504c1c9fd2585fa1e15c6f5
    //c53029f8960cdb0d88daf0bb70fc3208
    //9514cf432db3712a226f95175859430f
    //97ea6d2a6a7a19e3caf31210ad93173e
    //3b81e7a7f42373ffdf3c157583a8b527
    //959e664e6343fab2240c91a1f0b4664a
    //c105ffbd6a2925ea159ddb12fa20b2d2
    //a20461e793a9a5f380f58fc396a62cc5
    //6bbf8482cd53ea0cfe7883c6e15213aa
    //6f26f381fe263731d356c2bfd67665e6
    //6e6ecba376ebdb6af4396270789b7647
    //94666aff27a9a24eed66216d6f8a12b2
    //292f431208c2757f887004894abf61cb
    //b23b82e8927e10df91bd62da870fe8ce
    //586b1e746223fe3b492e67876a0b02db
    //0cfc3d9826846cfa3895c7af502f4276
    //0df60b43ea08f459cd7c0fc6dc38e063
    //775a0d00caefa5369b644e033f31a440
    //4209e79937dd1f34b50d5b772cab461b
    //ef69de9cd803e95aa521bb94b3726a45
    //bfad1a5801d3842341486367a8b5a1ee
    //253b253997e7f0710fe9de95dbfeea4a
    //98e93c9c2766eb13ce8eb54a97c1403a
    //4176a9c8d7dcde4ac65c052cd8d90a36
    //1d5596ee1246cace6de6d3a54a9b2bad
    //b50c9dc14ca153790ce081c8f6f1adfb
    //8df80dc49f941e1de56e4db2f31f55eb
    //5a76c543f1a8240dbcf33d56a5b88cd2
    //96f3082d8797586aa12bfb8c2e8d7466
    //4c0ec2f66699097088ea6977e2e84d9d
    //4d902df1a8a26d1102424cce351f5de2
    //9913c424436ce7096b1c86f35c05beee
    //a13849b21ab6dabcb5f1b8de4820e345
    //ba8d4272020b235a99dbf0c03a493fbb
    //955464bae5a338af55fd274a560d4ae0
    //c893f759929a7c151835ba4b7ba9214f
    //0001866ea92d141e6236a87f6789a200
    //735431e42db864361c3c42a5274f35e2
    //734caff45a583e5eabc58fcc565bb1ad
    //8a60aca151fd0f2f8c2bec793e4e94a7
    //d0101ee69b60d191b119b5a800b70276
    //ac96f3ae52110a95863d901f327f6492
    //4f9b20a1c3279acafd10ef1af05a3b4a
    //f588f02aab5af05f816a08835d9a4b55
    //815ed1f672a0fefcbd56ec50cfa1b4dd
    //68496c66a187415557e361aeba9a17a7
    //74261176a86fe50b7d6b1625eb353119
    //97dfe5455fe95832b42fa2674f3202e1
    //f34e8b6303ad71c3c9daf2c5d927eab7
    //2c846ee3101c9486516de5e2454fd35b
    //bf6a92a919ee9a916855b9c42a4128b2
    //ae8d70784a336705d62b731041bcba39
    //f63d9f6a16dbdf01e93b04d63893e94d
    //c4d285f46d0eb7d7cb89af1dcc4ddae6
    //f28533471320af322b118f6f3c4e880d
    //d53553cef93e99e087c610b830c0103d
    //c82c06369f39fb29bd704b725302fbc8
    //5826b2ca23dcb0cfb3ba028514e52b62
    //13854a36ac067272253fd2c71b2f6329
    //9effc7c54329c9f6d45834180b8ccbf0
    //1d28787107db08871bbd988c9363e5d5
    //669039794fc5161f9d63f0e2c54717b0
    //0d0f5949fb86a04a0df0206a9f796f9d
    //e3144d55f937a3594dae78be521ea431
    //8e9a9e3c62c01f85bdef70ec0e26771f
    //cc9bd0243ecede5072da49deb69bd9dc
    //3c643705da445a6a1ed864eca33bd3d3
    //ca497b06003c2876b41b99b6d5e97ba1
    //53407d7c0030fc456114db42477ac5fe
    //5e8c8f1c75b903a0cca33694a373dba5
    //8e6f4f52a98aa0397e1567f072ec631a
    //502891e567168f5f79650a1f51834de4
    //48ea0e6c26c2728f4f04eb0e90d8db23
    //39b183d1dbc56a43ed63a7c32c34c267
    //4887f188e3764b57d49119598c560c0a
    //c5072395125d3cf57cd7f419a95d1910
    //7389b09b4c8ca1a39ae97d9202078617
    //0816de42dc618063449eb249cc2af79b