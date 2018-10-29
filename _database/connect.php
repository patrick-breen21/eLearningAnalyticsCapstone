<?php
  //phpinfo();
/*
	$host = 'wsh1-2e-syd.hostyourservices.net';
	$dbname = 'smallpro_capstone';
	$user = 'smallpro_ifb398';
	$pass = 'o>w8E?J7cxYM';

	//$conn = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $pass);
	//$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
try{
	$conn = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $pass);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException  $e ){
  $conn = null;
  echo "Error: ".$e;
}

var_dump($conn);
*/
?>

<?php

	$host = 'wsh1-2e-syd.hostyourservices.net';
	$dbname = 'smallpro_capstone';
	$user = 'smallpro_ifb398';
	$pass = 'o>w8E?J7cxYM';

	$conn = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $pass);
	//$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>