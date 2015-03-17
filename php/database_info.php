<?php
//Here is the file to change the database information

function database_info($tbl, $setting){
$host="localhost:3306"; // Host name 
	$username="root"; // Mysql username 
	$password=""; // Mysql password 
	$db_name="soen"; // Database name 
	$tbl_name=$tbl; // Table name
	// Connect to server and select databse.
	if ($setting){
	$db=mysqli_connect("$host", "$username", "$password","$db_name")or die("cannot connect"); 
	return $db;
	}else	{	
	// Connect to server and select databse.
	mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
	mysql_select_db("$db_name")or die("cannot select DB");}
	}
?>