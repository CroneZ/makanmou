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
		 		$sql = "INSERT INTO user (userID,email,userPasswd) VALUES ('$userID','$userEmail','$password')";
		 		if($conn->query($sql)===TRUE){
			 			$arr = array(rand(0,9),rand(0,9),rand(0,9),rand(0,9));
			 			$verifyCode = implode($arr);	
			 			$_SESSION['verifyCode'] = $verifyCode;

					$mail->addAddress($userEmail, "MeFromGmail");	

					$mail->Subject = "Email Verification";
					$mail->Body = "<p>Your verification Code is ".$verifyCode."</p>
												<p>Click the link to verify your account</p>
												<a href = localhost/newWebsite/verify.php>Link to Verify</a>";
					$mail->AltBody = "This is the plain text version of the email content";

					if(!$mail->send()){
							echo "Mailer Error: " . $mail->ErrorInfo;
					}else{
						echo "<script type = 'text/javascript'>alert('Please Check Your Email for Verification Code')</script>";
						header('Location:localhost/newWebsite/mainPage.php');
					}				 			
   		}
   	}
  }
 ?>