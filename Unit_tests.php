<?php include('LL_functions.php') ?>


<?php


echo "
    <!DOCTYPE html>
    <html>
    <body>
    
    <h1>Unit Test results</h1>";


    echo "<h2>Inserting static data into Learning Locker. Username: 'test', Response:<br></br> </h2>";
//
    $name = "test2";
    $duration = "50";
    $timestamp = "11:30AM";
    $date = "21/2/2018";
    $title = "title";
//
    echo "<p>".(StaticInsert($name, $duration, $timestamp, $date, $title))."</p>";


//    echo "<br><br><br><h2>Getting static Echo times from Learning Locker for 'test' user. Response: </h2>";
//
//
//    echo var_dump(StaticGetEchoTimeUser());
        echo "<br><br><br><h2>Getting Echo times from Learning Locker for 'test' user. Response: </h2>";




        //echo "<p>".(UTInsert())."</p>";
//echo "<h2>Inserting data into Learning Locker. Username: 'test', Response:<br></br> </h2>";

//////
//        echo "<p>".var_dump(InsertEchoTimeStatement($name, $duration, $timestamp, "22/2/2018", $title))."</p>";
//        echo "<p>".var_dump(InsertEchoTimeStatement($name, $duration, $timestamp, "3/3/2018", $title))."</p>";
//        echo "<p>".var_dump(InsertEchoTimeStatement($name, $duration, $timestamp, "9/3/2018", $title))."</p>";
//        echo "<p>".var_dump(InsertEchoTimeStatement($name, $duration, $timestamp, "20/3/2018", $title))."</p>";
//        echo "<p>".var_dump(InsertEchoTimeStatement($name, $duration, $timestamp, "30/3/2018", $title))."</p>";
//



        echo var_dump(GetEchoTimeUser("test3"));




        echo "<br><br><br><h2>Getting Echo data from Learning Locker for 'test' user. Response: </h2>";

        echo var_dump(UTGetEchoDataUser()[0]);

    //
        echo "<br><br><br><h2>Getting all Echo data from Learning Locker. Modified to only retrieve 'test' user since the learning locker import doesn't seem to have stored the unique hashes.  Response: </h2>";

        echo var_dump(UTGetAllEchoData());

    //

        echo "<br><br><br><h2>Compute average from all data. Response: </h2>";

        echo var_dump(AverageEchoTimes(GetAllEchoData()));

    //
    //
    //    echo "<br><br><br><h2>Compute average from all data. Response: </h2>";
    //
    //    echo var_dump(UTAverageEchoTimeUser());
    //

    echo "
        
        </body>
        </html>
    ";

?>