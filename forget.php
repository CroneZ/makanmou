<?php
	include_once("template/headerTemplate.php");
 ?>
 <body class = "registerBG" onload = "checkLogin()">
 	<form method = "post" action = "">
 		<input type ="text" name = "userID" placeholder = "Enter Username" />
 		<input type = "submit" name = "forgetPass" value = "submit"/>
 	</form> 	
 
 </body>
 <?php
 	if(isset($_POST['forgetPass'])){
 		echo "Hello";
 	}
 
  ?>
