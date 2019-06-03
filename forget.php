<?php
	include_once("template/headerTemplate.php");
 ?>
 <body class = "registerBG" onload = "checkLogin()">
 <div class = "pageWrap">
 	<div class = "formPanel">
 		<form method = "post" action = "forget.php">
 			<p>UserID:</p>
 			<input type ="text" name = "userID" placeholder = "Enter Username" />
 			<p>Email:</p>
 			<input type = "text" name = "email" placeholder = "Enter Email" /></br></br>
 			<input type = "submit" name = "forgetPass" value = "submit"/>
 		</form> 	
 	</div>
 </div>
 </body>
 <?php
 	if(isset($_POST['forgetPass'])){
 		$userID = $_POST['userID'];
 		$email = $_POST['email'];
 		$sql = "SELECT * FROM user WHERE userID = '$userID' AND email = '$email'";
 		$result = mysqli_query($conn, $sql);
 		if(mysqli_num_rows($result)==1){
 			$url = "emailVerify.php?email=$email";
			echo "<script type = 'text/javascript'>window.location = '$url'</script>";

 		}
 	}
 
  ?>
