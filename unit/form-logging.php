<form method='post' action=''>
    <style>
        body{
            box-sizing: border-box;
        }
        .weeklygoaltime{
            padding: 16px;
            font-size: 13pt;
            background-color: lightgray;
        }
    </style>
    <div class="weeklygoaltime">
        <label><b>Weekly Time Logging</b></label>
        <select>
            <option value="week 1">week 1</option>
            <option value="week 2">week 2</option>
            <option value="week 3">week 3</option>
            <option value="week 4">week 4</option>
            <option value="week 5">week 5</option>
            <option value="week 6">week 6</option>
            <option value="week 7">week 7</option>
            <option value="week 8">week 8</option>
            <option value="week 9">week 9</option>
            <option value="week 10">week 10</option>
            <option value="week 11">week 11</option>
            <option value="week 12">week 12</option>
            <option value="week 13">week 13</option>
            <option value="exams">Exams</option>
        </select>
        <input type="text" id='logged' placeholder="10" name='ltime' />
        <input type='submit' class='button' value='Submit'/>
    </div>
</form>

<?php

//Insert logged time into learning locker
$name = posted_value('username');
$unit = posted_value('unit');
$date = posted_value('week');
$duration = posted_value('ltime');
$timestamp = time();
$title = ""; // not relevant
$totaDuration = ""; // not relevant
$verb = "logging";
//
//  if ($name && $unit && $date && $duration && $timestamp && $title && $totaDuration && $verb) {
//      var_dump(InsertEchoTimeStatement($name, $duration, $timestamp, $date, $title, $totalDuration, $unit, $verb));
//  }
var_dump(InsertEchoTimeStatement($name, $duration, $timestamp, $date, $title, $totalDuration, $unit, $verb));

?>