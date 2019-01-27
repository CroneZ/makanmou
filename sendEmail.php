<body onload = "checkLogin()"></body>

<script>function checkLogin(){
  	<?php  	
  		if(isset($_SESSION['success'])){
  			$checkLoggedIn = $_SESSION['success'];
  			if(isset($_SESSION['userID'])){$userID = $_SESSION['userID'];}
  		}
  	?>
  	var checkLoggedIn = "<?php if(isset($checkLoggedIn)){echo $checkLoggedIn;}else{/*This is the default case*/echo 'LogIn';}?>";
  	console.log(checkLoggedIn);
  	if(checkLoggedIn == true){
  		alert("i");
  		var user = "Welcome, ";
  		document.getElementById("topRightButton").text = user; 
  	}else{
  		document.getElementById("topRightButton").text = "LogIn";
  	}
  }</script>
