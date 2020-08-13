<?php

	//set the function for cleaning
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = nl2br($data);
	  return $data;
	}

	//function to connect to the database'
	function dbconnect(){

	    $sql = "localhost"; 
	    $username = "root";
	    $password = "";
	    $conn = mysqli_connect($sql, $username, $password) or 
	    die("Unable to connect to the database");
	    $databse = mysqli_select_db($conn, "bsc_demo");

	    // Return from the function 
	    return $conn; 
	}

?>