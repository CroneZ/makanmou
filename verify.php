<?php
	require_once("template/databaseConnection.php");
	?>
	
	<!DOCTYPE html5>
	<html>
		<head>
			<title>Verify Account</title>	
		</head>
		<body>
			<form method = "post" action = "verify.php">
				<h1>Username:</h1>
				<input type = "text" name = "userID" placeholder = "Enter your username"/>
				<h1>Verification Code:</h1>
				<input type = "text" name = "Code" placeholder = "Enter your verification code"/>
				<input type = "submit" name = "verifyCode" value = "verify"/>
			</form>
		</body>
	</html>
	
	<?php
	if(isset($_POST['verifyCode'])){
		$userID = $_POST['userID'];
		if($_SESSION['verifyCode']==$_POST['Code']){
			$sql = "UPDATE user SET status = 'Verified' WHERE user.userID = '$userID'";
			if($conn->query($sql)===TRUE){
				$message = "You have been verified successfully!";
				echo "<script type = 'text/javascript'>alert('$message')</script>";
			}else{
				echo $conn->error;
			}
		}
	}
		?>
