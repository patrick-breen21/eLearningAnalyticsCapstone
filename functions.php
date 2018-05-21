<?
include 'LLGET.php';

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
    include 'LL_functions.php';

    //parse csv into an array
    // array str_getcsv ( string $input [, string $delimiter = "," [, string $enclosure = '"' [, string $escape = "\\" ]]] )
    $csv = array_map('str_getcsv', file($filename));

    //get the name of the first student in the csv file - we're only storing their results
    $hash = $csv[1][0];
    echo $hash;

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
                var_dump($headings);
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
