<?php 
	$servername = 'di_inter_tech_mysql';
	$username = 'webuser';
	$password = 'webpass';
	$dbname = 'di_internet_technologies_project';
	
	$con = new mysqli($servername, $username, $password, $dbname);
	
	if ($con->connect_error) {
		die("Connection failed: ".$con->connect_error);
	} else {
		mysqli_set_charset($con, 'utf8');	
	}
	
?>