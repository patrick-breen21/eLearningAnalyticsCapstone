<?php
session_start();
$site_url = "http://{$_SERVER['HTTP_HOST']}/capstone/";
$root = "{$_SERVER['DOCUMENT_ROOT']}/capstone";
  
$dev = false;
//Start the Session
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <base href="<?=$site?>" />
    <meta name="description" content="">
	<meta name="keywords" content="">
    <link rel="SHORTCUT ICON" href="_images/logo.png">

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="_scripts/script.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,500,400italic,700,700italic' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" 													href="_css/global.css"/><!-- global.css -->
	<link rel="stylesheet" media="(min-width: 0px) and (max-width: 640px)" href="_css/small.css" /><!-- small.css -->
	<link rel="stylesheet" media="(min-width: 641px) and (max-width: 979px)" href="_css/medium.css"/><!-- medium.css -->
	<link rel="stylesheet" media="(min-width: 980px)"						href="_css/large.css" /><!-- large.css -->

	<!-- Google Fonts -->
	<?php
	$fonts = ['Roboto'];

	for ($i = 0; $i < count($fonts); $i++):
	    echo "<link href='http://fonts.googleapis.com/css?family=".$fonts[$i]."' rel='stylesheet' type='text/css'>";
	endfor;
	?>

  </head>
  
<?php
    //var_dump($_SESSION['user']);
    if (!isset($_SESSION['user'])) include('login.php');
    //var_dump($_SESSION['user']);
?>