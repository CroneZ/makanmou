<?
 require_once('template/headerTemplate.php');
 require_once('template/databaseConnection.php');
 
 if(isset($_POST['updatePass'])){
 		$userID = $_GET['user'];
 		$pass1 = $_POST['pass1'];
 		$pass2 = $_POST['pass2'];
 		if($pass1==$pass2){
 			$password = md5($pass1);
 			$sql = "UPDATE user SET userPasswd = '$password' WHERE userID = '$userID'";
 			if($conn->query($sql)==true){
 				//update success
 				$message = "Password Resetted!";
 				$url = "index.php";
				echo "<script type = 'text/javascript'>alert('$message');window.location = '$url'</script>";
 			}else{
 				echo $conn->error;
 			}
 		}
 }elseif(isset($_POST['reset'])){
 		$userID = $_POST['userID'];
 		$email = $_POST['email'];
 		$verifyCode = $_POST['verifyCode'];
 		
 		$sql = "SELECT * FROM user WHERE userID = '$userID' AND email = '$email' AND verifyCode = '$verifyCode' ";
 		$result = mysqli_query($conn,$sql);
 		if(mysqli_num_rows($result)==1){
 			?>
 			<body class = "registerBG" onload = "checkLogin()">
 			<div class = "pageWrap">
 				<div class = "formPanel">
 				<form method = "post" action = "resetPassword.php?user=<?echo $userID;?>">
 				<p>Password:</p>
 					<input type = "password" name = "pass1" placeholder = "Enter password"/><p>Confirm password:</p>
 					<input type = "password" name = "pass2" placeholder = "Enter password"/></br>
 					<input type = "submit" name = "updatePass" value = "SUBMIT"/>
 				</form>
 					</div>
 				</div>	
 			</body>
 			
 			<?
 		}
 		
 }else{
	?>
	<body class = "registerBG" onload = "checkLogin()">
	<div class = "pageWrap">
	<div class = "formPanel">
		<form method = "post" action = "resetPassword.php">
			<p>UserID:</p>
			<input type = "text" name = "userID" placeholder = "Please Enter Your UserID"/>
			<p>Email:</p>
			<input type = "email" name = "email" placeholder = "Please Enter Your Email"/>
			<p>VerificationCode:</p>
			<input type = "text" name = "verifyCode" placeholder = "Please Enter Your Verification Code"/></br>
			<input type = "submit" name = "reset" value = "SUBMIT" />
		</form>
		</div>
	</div>
</body>
	<? 
 }
 
?>


