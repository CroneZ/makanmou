<?php
	session_start();	
	
  $servername = "localhost";
  $username = "root";
  $password  = "";
  // insert database name here
  $dbname = "workshop";
  $errors = array();

  $conn = new mysqli($servername,$username,$password,$dbname);

  // if connection error exist then true
  if($conn->connect_error){
    die("Connection failed: "+$conn->connect_error);
  }

 ?>
 

