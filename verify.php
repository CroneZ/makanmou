<?php
	require_once("template/databaseConnection.php");
	require_once("template/headerTemplate.php");
	?>
	
	<!DOCTYPE html5>
	<html>
		<head>
			<title>Verify Account</title>	
		</head>
		<body class = "registerBG" onload = "checkLogin()">
			<div class = "registerFormWrap">
				<form method = "post" action = "verify.php">
				<h1>Username:</h1>
				<input type = "text" name = "userID" placeholder = "Enter your username"/>
				<h1>Verification Code:</h1>
				<input type = "text" name = "Code" placeholder = "Enter your verification code"/>
				<input type = "submit" name = "verifyCode" value = "verify"/>
			</form>
			</div>
		</body>
	</html>
	
	<?php
	if(isset($_POST['verifyCode'])){
		$userID = $_POST['userID'];
		$sql = "SELECT verifyCode FROM user WHERE userID = '$userID'";
		$result = mysqli_query($conn,$sql);
		while($row=mysqli_fetch_assoc($result)){
			$verifyCode = $row['verifyCode'];
		}
		
		if($verifyCode==$_POST['Code']){
			$sql = "UPDATE user SET status = 'Verified' WHERE user.userID = '$userID'";
			if($conn->query($sql)===TRUE){
				$message = "You have been verified successfully!";
				$url = "index.php";
				echo "<script type = 'text/javascript'>alert('$message');window.location = '$url'</script>";
			}else{
				echo $conn->error;
			}
		}
		//Need to add case if code is wrong
	}
		?>
