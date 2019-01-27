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
		  		$_SESSION['userID'] = $userID;
		  		$_SESSION['success'] = true;
		  		header("Location:mainPage.php?login=sucess");
		  	}
    	}else{
    		echo "<script type = 'text/javascript'>alert('Invalid Username/Password');</script>";
    	}	
    }else if($_GET['action']=='logout'){
    	unset($_SESSION['success']);
    	unset($_SESSION['userID']);
    }
  }//Bracket for get action validation
 ?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="css/template.css">
  <!-- This website is gonna be minimalist  -->
    <div class = "navbarWrap">
		  <div class = "container1">
		  	<a id = "home" href="/newWebsite/mainPage.php">Home</a>
		    <!-- ^Replace with logo -->
		    <a href="/newWebsite/register.php">Sign Up</a>
		    <!-- Do I really need an about page ? -->
		    <a href="">Menu</a>
		    <!-- I want this Menu to do a drop down list -->
		    <a href="">MyAcc</a>
		    <!-- This should be the same for either users or vendor -->
		  </div>
		  <div class = "container2">
		  	<p id = "welcomeText" ></p>
		  </div>
		  <div class = "container3">
		  <a id = "topRightButton"class = "logout" href = "javascript:openForm()"></a>
      </div>
		  
      
      <!-- I want this to be only be shown if not logged in -->
    </div>
    <div class = "filter2" id = "filter">
      <div class = "popupFormWrap">
        <form class = "popupForm"  method = "post" action = "mainPage.php?action=login">
          <p>Username</p>
          <input type = "text" name = "username" placeholder="Enter Username"/>
          <input type = "password" name = "password" placeholder="Enter Password"/>
          <div class = "loginButtonPanel">
            <input type = "submit" value = "Login"/>
            <input type = "button" value = "Close" onclick = "closeForm();"/>
          </div>
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
  }
  function closeForm(){
    // document.getElementById("filter").style.opacity = 0;
    document.getElementById("filter").className = "filter2";
    document.getElementById("topRightButton").className = "logout";
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
  		document.getElementById("topRightButton").href = "mainPage.php?action=logout";
  		document.getElementById("welcomeText").innerHTML = "Welcome, "+user;
  	}else{
  		document.getElementById("topRightButton").text = "LogIn";
  		document.getElementById("topRightButton").href = "javascript:openForm()";
  		document.getElementById("welcomeText").innerHTML = "";
  	}
  }
  
</script>
