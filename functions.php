<?
include_once 'LLGET.php';
include_once 'LL_functions.php';


function pre_dump($var) {
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
}


function csvget($filename)
{
    //parse through a  csv and relay data
    $row = 1;
    if (($handle = fopen($filename, "r")) !== false) {
        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            $num = count($data);
            //echo "<p> $num fields in line $row: <br /></p>\n";
            $row++;
            for ($c = 0; $c < $num; $c++) {
                //echo $data[$c] . "<br />\n";
            }
        }
        fclose($handle);
    }

    //make sure LL_functions.php is in same folder as this file.

    //parse csv into an array
    // array str_getcsv ( string $input [, string $delimiter = "," [, string $enclosure = '"' [, string $escape = "\\" ]]] )
    $csv = array_map('str_getcsv', file($filename));

    //get the name of the first student in the csv file - we're only storing their results
    $hash = $csv[1][0];
    //echo $hash;

    //run
    loadOneUsersEchoTimes($hash);
}

function loadOneUsersEchoTimes($hash)
{
    $csv = array_map('str_getcsv', file('scrubbed.csv'));

    foreach ($csv as $row) {
        //echo var_dump($row[3]);
        $duration = (int) $row[4];

        if ($hash == $row[0]) {
            //insert data into learning locker
            InsertEchoTimeStatement($hash, $duration);
        }
    }
}

function csv_import_form($name = 'csv', $action = '', $btntxt = 'Submit', $formname = 'csvform')
{
    echo "<form action=\"$action\" method='post' enctype='multipart/form-data' name=\"$formname\" class='csvform'>";
    echo "Choose your file: <br /> ";
    echo "<input name=\"$name\" type='file' class='csv-upload' />";
    echo "<input type='submit' name='Submit' value=\"$btntxt\" />";
    echo "</form>";
}

function parseCSV($csv, $headings = null)
{
    $output = [];

    if ($csv[size] > 0) {

        //get the csv file
        $file   = $csv[tmp_name];
        $handle = fopen($file, "r");

        //loop through the csv file get data
        do {
            if (!$headings) {
                $headings = $data;
                continue;
            }

            if (count($data) != count($headings)) {
                continue;
            }

            $row = [];
            for ($i = 0; $i < count($headings); $i++) {
                $row[$headings[$i]] = $data[$i];
            }

            array_push($output, $row);
        } while ($data = fgetcsv($handle, 1000, ",", '"'));

        return $output;
    }
    return null;
}

function loadData($data, $portal='LL', $userid=null, $cols=null)
{
    foreach ($data as $row) {
        if ($userid != null && !in_array( $userid, $row ) ) continue;
        //extract relevent data
        $args = [ 'userid' => $userid ];

        if ($cols == null) {
          $args = array_merge($args,$row); 
        } else {
          foreach ($cols as $col) {
            $args[$col] = $row[$col];
          }
        }
        
        switch ($portal) {
          case 'LL':
            InsertEchoTimeStatement($args['userid'], $duration=$args['Echo Duration (Minutes)'], $duration=$args['Total Minutes Viewed'], $timestamp=$args['Echo Time'], $date=$args['Echo Date'], $title=$args['Echo Title']);
            break;
        }   
    }
    echo('import for all rows completed');
}


function displayData($data) {
    echo "<table class='datatable'>";
    echo "<tr>";
    foreach ($data[0] as $heading => $value) {
        echo "<td>$heading</td>";
    }
    echo "</tr>";
    foreach ($data as $row) {
        echo "<tr>";
        foreach ($row as $heading => $value) {
            echo "<td>$value</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}
