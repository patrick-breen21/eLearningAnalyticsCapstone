<?php
	// Connects to the database
	// Note: this file contains the password and must not be revealed

	// mysqli
	$hostname = "wsh1-2e-syd.hostyourservices.net";
	$user = "smallpro_ifb398";
	$password = "o>w8E?J7cxYM";
	$database = "smallpro_capstone";

	$mysqli = new mysqli($hostname, $user, $password, $database);

	// check connection
	if (mysqli_connect_errno())
	{
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}

?>
