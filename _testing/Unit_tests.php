<?php include('LL_functions.php'); ?>


<?php


echo "
    <!DOCTYPE html>
    <html>
    <body>
    
    <h1>Unit Test results</h1>";


//    echo "<h2>Inserting static data into Learning Locker. Username: 'test', Response:<br></br> </h2>";
//
    $name = "ae595039b3670d1c67faa074b0aa05fc";
    $duration = "100";
    $timestamp = "11:30AM";
    $date = "11-3-2017";
    $title = "title";
    $totalDuration = 100;
    $verb = "watch";
    $unit = "cab201";
//
//    echo "<p>".(StaticInsert($name, $duration, $timestamp, $date, $title, $totalDuration))."</p>";


    //echo "<br><br><br><h2>Getting static Echo times from Learning Locker for 'test' user. Response: </h2>";


//    echo var_dump(StaticGetEchoTimeUser());
//        echo "<br><br><br><h2>Getting Echo times from Learning Locker for 'test5' user. Response: </h2>";




//        echo "<p>".(UTInsert())."</p>";
echo "<h2>Inserting data into Learning Locker. Username: 'george', Response:<br></br> </h2>";


        echo "<p>".var_dump(InsertEchoTimeStatement($name, $duration, $timestamp, $date, $title, $totalDuration, $unit, $verb))."</p>";
        echo "<p>".var_dump(InsertEchoTimeStatement($name, $duration, $timestamp, "01/08/2017", $title, $totalDuration, $unit, $verb))."</p>";
        echo "<p>".var_dump(InsertEchoTimeStatement($name, $duration, $timestamp, "08/08/2017", $title, $totalDuration, $unit, $verb))."</p>";
        echo "<p>".var_dump(InsertEchoTimeStatement($name, $duration, $timestamp, "16/08/2017", $title, $totalDuration, $unit, $verb))."</p>";
        echo "<p>".var_dump(InsertEchoTimeStatement($name, $duration, $timestamp, "25/08/2017", $title, $totalDuration, $unit, $verb))."</p>";
    echo "<p>".var_dump(InsertEchoTimeStatement($name, $duration, $timestamp, "3/09/2017", $title, $totalDuration, $unit, $verb))."</p>";
    echo "<p>".var_dump(InsertEchoTimeStatement($name, $duration, $timestamp, "11/09/2017", $title, $totalDuration, $unit, $verb))."</p>";
//    echo "<p>".var_dump(InsertEchoTimeStatement($name, $duration, $timestamp, "19/09/2017", $title, $totalDuration))."</p>";
    echo "<p>".var_dump(InsertEchoTimeStatement($name, $duration, $timestamp, "27/09/2017", $title, $totalDuration))."</p>";
    echo "<p>".var_dump(InsertEchoTimeStatement($name, $duration, $timestamp, "6/10/2017", $title, $totalDuration))."</p>";
    echo "<p>".var_dump(InsertEchoTimeStatement($name, $duration, $timestamp, "15/10/2017", $title, $totalDuration))."</p>";
    echo "<p>".var_dump(InsertEchoTimeStatement($name, $duration, $timestamp, "24/10/2017", $title, $totalDuration))."</p>";

//
//
echo "<h2>Retrieving unit data from Learning Locker. Username: 'george', unit: 'cab202', Response:<br></br> </h2>";

echo "<p>".var_dump(GetStudentTimeUnit($name, $unit))."</p>";


echo "<h2>Retrieving unit data from Learning Locker. Username: 'george', verb 'watch', Response:<br></br> </h2>";

echo "<p>".var_dump(GetStudentTimeVerb($name, $verb))."</p>";

//
//        echo var_dump(GetEchoTimeUser("test6"));
//
//
//
//
        echo "<br><br><br><h2>Getting Echo data from Learning Locker for 'test' user. Response: </h2>";
//
//        echo var_dump(GetEchoDataUser("4fa361cff7617c7534ee7adc47fe00bd"));
//
//    //
//        echo "<br><br><br><h2>Getting all Echo data from Learning Locker. Modified to only retrieve 'test' user since the learning locker import doesn't seem to have stored the unique hashes.  Response: </h2>";
//
//        echo var_dump(GetAllEchoData());
////        $array = (GetAllEchoData());
////
////        foreach ($array as $element){
////            echo vardump($element)."<br><br>";
////        }
//
//    //

        echo "<br><br><br><h2>Compute average from all data. Response: </h2>";

//        echo var_dump(AverageEchoTimes(GetAllEchoData()));

//        echo var_dump(UTAverageCalcCheck());

//        $array = UTAverageCalcCheck();
//
//        for($i=0; $i < count(UTAverageCalcCheck()); $i++){
//            echo "<p>Row ". (string)$i . "</p>";
//            echo $array[$i]."<br>";
//        }

        echo "<br><br><br><h2>Compute average for one student. Response: </h2>";

//        echo var_dump(AverageEchoTimeUser("4fa361cff7617c7534ee7adc47fe00bd", GetAllEchoData()));


    echo "
        
        </body>
        </html>
    ";

?>