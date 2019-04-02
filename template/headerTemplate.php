<?php
	include_once("databaseConnection.php");
  // if action variable exist
  if(isset($_GET['action'])){
    // login actions
    if($_GET['action']=="login"){
    	$userID = mysqli_real_escape_string($conn,$_POST['username']);
    	$password = mysqli_real_escape_string($conn,$_POST['password']);
    	
    	//Check For Empty Entry
    	if(empty($username)){
    		array_push($errors,"Please Enter Username");
    	}
    	if(empty($password)){
    		array_push($errors,"Please Enter Password");
    	}
    	
    	if(count($errors)==0){
    		$password = md5($password);
    	 	$sql = "SELECT * FROM user WHERE userID = '$userID' AND userPasswd = '$password'";
		  	$result = mysqli_query($conn,$sql);
		  	if(mysqli_num_rows($result)==1){
		  		//Login Success
		  		$row = mysqli_fetch_assoc($result);
		  		$_SESSION['userID'] = $userID;
		  		$_SESSION['whoIsIt'] = $row['identity'];
		  		$_SESSION['success'] = true;
		  		header("Location:index.php?login=sucess");
		  	}
    	}else{
    		echo "<script type = 'text/javascript'>alert('Invalid Username/Password');</script>";
    	}	
    }else if($_GET['action']=='logout'){
    	unset($_SESSION['success']);
    	unset($_SESSION['userID']);
    	unset($_SESSION['whoIsIt']);
    }
  }//Bracket for get action validation
 ?>

<!DOCTYPE html5>
<html>
<head>
	<title>MakanMOU</title>
  <link rel="stylesheet" type="text/css" href="css/template.css">
  <!-- This website is gonna be minimalist  -->
    <div class = "navbarWrap">
		  <div class = "container1">
		  	<a id = "home" href="/newWebsite/index.php">Home</a>
		    <!-- ^Replace with logo -->
		    <!-- I want this Menu to do a drop down list -->
		    <a href="">MyAcc</a>
		    <!-- This should be the same for either users or vendor -->
		  </div>
		  <div class = "container2">
		  	<p id = "welcomeText" ></p>
		  </div>
		  <div class = "container3">
		  <a id = "signUp" class = "signUp" href="/newWebsite/register.php?mode=user">Sign Up</a>
		  <a id = "topRightButton"class = "logout" href = "javascript:openForm()"></a>
      </div>
		  
      
      <!-- I want this to be only be shown if not logged in -->
    </div>
    <div class = "filter2" id = "filter">
      <div class = "popupFormWrap">
        <form class = "popupForm"  method = "post" action = "index.php?action=login">
          <p>Username</p>
          <input type = "text" name = "username" placeholder="Enter Username" required>
          <input type = "password" name = "password" placeholder="Enter Password" required>
          <div class = "loginButtonPanel">
            <input type = "submit" value = "Login"/>
            <input type = "button" value = "Close" onclick = "closeForm();"/>
          </div>
          <a class = "navbarWrap" id = "forgotPass" href="/newWebsite/forget.php">Forgot Your Password</a>
        </form>
      </div>
    </div>
</head>
</html>
<script>
  function openForm(){
    // document.getElementById("filter").style.opacity = 1;
    document.getElementById("filter").className = "filter3";
    document.getElementById("topRightButton").className = "logout2";
    document.getElementById("signUp").className = "signUpAfter";
  }
  function closeForm(){
    // document.getElementById("filter").style.opacity = 0;
    document.getElementById("filter").className = "filter2";
    document.getElementById("topRightButton").className = "logout";
    document.getElementById("signUp").className = "signUp";
  }
  function checkLogin(){
  	<?php
  		if(isset($_SESSION['success'])){
  			$checkLoggedIn = $_SESSION['success'];
  			if(isset($_SESSION['userID'])){$userID = $_SESSION['userID'];}
  		}
  	?>
  	var checkLoggedIn = "<?php if(isset($checkLoggedIn)){echo $checkLoggedIn;}else{/*This is the default case*/echo 'false';}?>";
  	if(checkLoggedIn == true){
  		var user = "<?php if(isset($userID)){echo $userID;}else{ echo 'default';} ?>";
  		document.getElementById("topRightButton").text = "LogOut";
  		document.getElementById("topRightButton").href = "index.php?action=logout";
  		document.getElementById("welcomeText").innerHTML = "Welcome, "+user;
  	}else{
  		document.getElementById("topRightButton").text = "LogIn";
  		document.getElementById("topRightButton").href = "javascript:openForm()";
  		document.getElementById("welcomeText").innerHTML = "";
  	}
  }
  function changeCurrent(who){
  	if(who == 'user'){
  		document.getElementById("tableUser").style.display = "table";
  		document.getElementById("tableVendor").style.display = "none";
  	}else if(who == 'vendor'){
  		document.getElementById("tableVendor").style.display = "table";
  		document.getElementById("tableUser").style.display = "none";
  	}else{
  		document.write("ERROR no Value for changeCurrent function argument!");
  	}
  }
  function registerUser(who){
  	if(who == 'user'){
  		window.location = "register.php?mode=user";
  	}else if(who == 'vendor'){
  		window.location = "register.php?mode=vendor";
  	}
  }
  
</script>
