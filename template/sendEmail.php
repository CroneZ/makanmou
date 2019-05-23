<?php
	require '/usr/share/php/libphp-phpmailer/PHPMailerAutoload.php';
		require '/usr/share/php/libphp-phpmailer/PHPMailerAutoload.php';
	$mail = new PHPMailer;
	
	//Enable SMTP debugging. 
	$mail->SMTPDebug = 3;                               
	//Set PHPMailer to use SMTP.
	$mail->isSMTP();            
	//Set SMTP host name                          
	$mail->Host = "smtp.office365.com";
	//Set this to true if SMTP host requires authentication to send email
	$mail->SMTPAuth = true;                          
	//Provide username and password     
	$mail->Username = "sowcw1@hotmail.com";                 
	$mail->Password = "rec0nb1ue";                           
	//If SMTP requires TLS encryption then set it
	//$mail->SMTPSecure = "tls";                           
	//Set TCP port to connect to 
	$mail->Port = 587;                                   

	$mail->From = "sowcw1@hotmail.com";
	$mail->FromName = "MeFromHotmail";

	$mail->smtpConnect(
		  array(
		      "ssl" => array(
		          "verify_peer" => false,
		          "verify_peer_name" => false,
		          "allow_self_signed" => true
		      )
		  )
	);

	$mail->isHTML(true);
	
	?>
