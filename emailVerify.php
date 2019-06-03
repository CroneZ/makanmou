<?php
	require_once("template/databaseConnection.php");
	require_once("template/sendEmail.php");

  if(isset($_POST['registerForm'])){
    $userID = mysqli_real_escape_string($conn, $_POST['userID']);
    $userEmail = mysqli_real_escape_string($conn,$_POST['email']);
    $password1 = mysqli_real_escape_string($conn,$_POST['userPasswd1']);
    $password2 = mysqli_real_escape_string($conn,$_POST['userPasswd2']);
   	
   	if(empty($userID)){
   		array_push($errors,"Username is required");
   	}
   	if(empty($password1)){
   		array_push($errors,"Password is required");
   	}
   	if($password1!=$password2){
   		array_push($errors,"Password do no match");
   	}
   	$userCheckQuery = "SELECT * FROM user WHERE userID = '$userID' OR email = '$userEmail'";
   	$result = mysqli_query($conn,$userCheckQuery);
   	$user = mysqli_fetch_assoc($result);
   	
   	if($user){
   		array_push($errors,"User already exist");
   	}
   	
   	if(count($errors)==0){
		 		$password = md5($password1);
		 		$sql = "INSERT INTO user (userID,email,userPasswd,identity) VALUES ('$userID','$userEmail','$password','user')";
		 		if($conn->query($sql)===TRUE){
		 		//Create Verify Code & insert into database
		 		$insert = FALSE;
		 		while($insert === FALSE){
			 			$arr = array(rand(0,9),rand(0,9),rand(0,9),rand(0,9));
			 			$verifyCode = implode($arr);	
			 			$_SESSION['verifyCode'] = $verifyCode;
			 			$vSql = "UPDATE user SET verifyCode = '$verifyCode' WHERE userID = '$userID'";
			 			echo "Hello";
			 			if($conn->query($vSql)===TRUE){
			 				$insert = TRUE;
			 			}
		 		}
					//Generate Email
					$mail->addAddress($userEmail, "MeFromGmail");	

					$mail->Subject = "Email Verification";
					$mail->Body = "<p>Your verification Code is ".$verifyCode."</p>
												<p>Click the link to verify your account</p>
												<a href = localhost/newWebsite/verify.php>Link to Verify</a>";
					$mail->AltBody = "This is the plain text version of the email content";

					if(!$mail->send()){
							echo "Mailer Error: " . $mail->ErrorInfo;
							//Might have to add a resend function for unsent email. Refer verify code in database and resend it.
					}else{
						$message = "Please Check Your Email for Verification Code!";
				$url = "index.php";
				echo "<script type = 'text/javascript'>alert('$message');window.location = '$url'</script>";
					}				 			
   		}
   	}else{
   		echo $error;
   	}
  }elseif(isset($_POST['vendorForm'])){
  	$userID = mysqli_real_escape_string($conn, $_POST['userID']);
    $userEmail = mysqli_real_escape_string($conn,$_POST['email']);
    $password1 = mysqli_real_escape_string($conn,$_POST['userPasswd1']);
    $password2 = mysqli_real_escape_string($conn,$_POST['userPasswd2']);
   	
   	if(empty($userID)){
   		array_push($errors,"Username is required");
   	}
   	if(empty($password1)){
   		array_push($errors,"Password is required");
   	}
   	if($password1!=$password2){
   		array_push($errors,"Password do no match");
   	}
   	$userCheckQuery = "SELECT * FROM user WHERE userID = '$userID' OR email = '$userEmail'";
   	$result = mysqli_query($conn,$userCheckQuery);
   	$user = mysqli_fetch_assoc($result);
   	
   	if($user){
   		array_push($errors,"User already exist");
   	}
   	
   	if(count($errors)==0){
		 		$password = md5($password1);
		 		$sql = "INSERT INTO waitingList (userID,email,userPasswd) VALUES ('$userID','$userEmail','$password')";
		 		if($conn->query($sql)===TRUE){
		 			$message = "Registered Successfully Please wait for Admin verification";
		 			$url = "index.php";
		 			echo "<script type='text/javascript'>alert('$message');window.location='$url'</script>";
  	}
  }
 }elseif(isset($_GET['email'])){
		 //This is for forget password
		$email = $_GET['email'];
		echo $email;
		$insert = FALSE;
		 	while($insert === FALSE){
			 	$arr = array(rand(0,9),rand(0,9),rand(0,9),rand(0,9));
			 	$verifyCode = implode($arr);	
			 	$_SESSION['verifyCode'] = $verifyCode;
			 	$vSql = "UPDATE user SET verifyCode = '$verifyCode' WHERE email = '$email'";
			 	echo "Hello";
			 	if($conn->query($vSql)===TRUE){
			 		$insert = TRUE;
			 	}
		 }
		 
		$mail->addAddress($email, "MeFromGmail");	
		$mail->Subject = "Email Verification";
		$mail->Body = "<p>Click on the following link to reset your password</p>
										<p> This is your verification code : $verifyCode</p>
										<a href = localhost/newWebsite/resetPassword.php>Link to Verify</a>";
		$mail->AltBody = "This is the plain text version of the email content";
			if(!$mail->send()){
				echo "Mailer Error: " . $mail->ErrorInfo;
				//Might have to add a resend function for unsent email. Refer verify code in database and resend it.
			}else{
				//mail sent successfully
				$url = "index.php";
				$message = "Check Your inbox for mail!";
				echo "<script type = 'text/javascript'>alert('$message');window.location = '$url'</script>";
		 		}	
 }
 ?>
