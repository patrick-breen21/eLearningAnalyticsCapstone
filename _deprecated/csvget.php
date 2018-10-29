<?php
//parse through a  csv and relay data
$row = 1;
if (($handle = fopen("scrubbed.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
        for ($c=0; $c < $num; $c++) {
            echo $data[$c] . "<br />\n";
        } 
    }
    fclose($handle);
}

//parse csv into an array 
array str_getcsv ( string $input [, string $delimiter = "," [, string $enclosure = '"' [, string $escape = "\\" ]]] )
$csv = array_map('str_getcsv', file('scrubbed.csv'));
?> 



