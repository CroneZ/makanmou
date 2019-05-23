<?php
	include_once("template/headerTemplate.php");
 ?>
 <body class = "registerBG" onload = "checkLogin()">
 	<form method = "post" action = "">
 		<input type ="text" name = "userID" placeholder = "Enter Username" />
 		<input type = "text" name = "email" placeholder = "Enter Email" />
 		<input type = "submit" name = "forgetPass" value = "submit"/>
 	</form> 	
 
 </body>
 <?php
 	if(isset($_POST['forgetPass'])){
 		$userID = $_POST['userID'];
 		$email = $_POST['email'];
 		$sql = "SELECT * FROM user WHERE userID = '$userID' AND email = '$email'";
 		$result = mysqli_query($conn, $sql);
 		if(mysqli_num_rows($result)==1){
 			
 		}
 	}
 
  ?>
