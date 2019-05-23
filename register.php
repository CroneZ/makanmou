<?php
	require_once("template/headerTemplate.php");
	if(isset($_GET['mode'])){
		if($_GET['mode']=='user'){
		?>
				<body class = "registerBG" onload = "checkLogin()">
				<div class = "registerFormWrap">
				<form id = "registerForm" class  ="registerForm" method = "post" action  ="emailVerify.php">
				  <h1>Register</h1>
				  <h2>Username</h2>
				  <input type = "text" name = "userID" placeholder="Enter Username"/>
				  <h2>Email</h2>
				  <input type = "text" name = "email" placeholder = "Enter Email"/>
				  <h2>Password</h2>
				  <input type = "password" name = "userPasswd1" placeholder="Enter Password"/>
				  <input type = "password" name = "userPasswd2" placeholder="Enter Password Again"/>
				  <input type = "submit" name = "registerForm" value = "register"/>
				</form>
			</body>
		</html>
		<?php
		}else if($_GET['mode']=='vendor'){
		?>
					<body class = "registerBG" onload = "checkLogin()">
				<div class = "registerFormWrap">
				<form id = "registerForm" class  ="registerForm" method = "post" action  ="emailVerify.php">
				  <h1>Register</h1>
				  <h2>Username</h2>
				  <input type = "text" name = "userID" placeholder="Enter Username"/>
				  <h2>Email</h2>
				  <input type = "text" name = "email" placeholder = "Enter Email"/>
				  <h2>Password</h2>
				 <!-- The password will be resetted by the vendor -->
				  <input type = "password" name = "userPasswd1" placeholder="Enter Password"/>
				  <input type = "password" name = "userPasswd2" placeholder="Enter Password Again"/>
				  <input type = "submit" name = "vendorForm" value = "submit"/>
				</form>
			</body>
		</html>
		<?php
		}
	}else{
		?>
		<body class = "registerBG" onload = "checkLogin()">
			<div class = "registerFormWrap">
				<form id = "registerForm" class = "registerForm" method = "post" action = "emailVerify.php">
					<input type = "button" value = "user" onclick = "registerUser('user');"/>
					<input type = "button" value = "vendor" onclick = "registerUser('vendor');"/>
				</form>
			</div>
		</body>
		<?
	}
	?>
