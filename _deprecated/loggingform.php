<?php
	include_once "_database/connect.php";
	include_once "_includes/head.php";

	$params['name'] = posted_value('username');
	$params['unit'] = posted_value('unit');
	$params['week'] = posted_value('week');
	$params['gtime'] = posted_value('gtime');
  
  pre_dump($params);
  
  if ($params['name'] && $params['unit'] && $params['week'] && $params['gtime']) {
      $query = "INSERT INTO `Goal Times` (`id`, `Users`, `Unit`, `Week`, `Goal Time`) VALUES (NULL, :name, :unit, :week, :gtime";
      
      $result = pdoQuery($conn, $query, $params);
      pre_dump($result);
      echo "Inserted Goal Time";
  } else {
      echo "Missing parameters";
  }
?>

<?php

//insert goal time into database for a specific user and unit
//$_POST['goaltime'] = $goaltime;
//INSERT INTO `Goal Times` (`id`, `Users`, `Unit`, `Week`, `Goal Time`) VALUES (NULL, :name, :unit, :week, :gtime);

/*
$goalTquery = $dbh->prepare("INSERT INTO `Goal Times` (`id`, `Users`, `Unit`, `Week`, `Goal Time`) VALUES (NULL, :name, :unit, :week, :gtime");
$goalTquery->bindParam(':name', $username, PDO::PARAM_STR);
$goalTquery->bindParam(':unit', $unit, PDO::PARAM_STR);
$goalTquery->bindParam(':week', $week, PDO::PARAM_STR);
$goalTquery->bindParam(':gtim', $gtime, PDO::PARAM_STR);

$goalTquery->execute();
*/


//insert logged time into learning locker
//$_POST['loggedtime'] = $duration;
$duration = 10;
$name = $_GET['username'];
$timestamp = "12:40pm"; //get the current time
$date = ""; //populate from field in the future
$totalDuration = ""; //not relevant
$title = ""; //not relevant
$unit = "cab202"; //somehow get this from the dashboard?
$verb = "selflogged";

InsertEchoTimeStatement($name, $duration, $timestamp, $date, $title, $totalDuration, $unit, $verb);

//retrieve logged time from learning locker


echo var_dump(GetStudentTimeVerb($name, $verb));
