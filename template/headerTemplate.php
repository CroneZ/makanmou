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
		  		$_SESSION['status'] = $row['status'];
		  		header("Location:index.php?login=sucess");
		  	}
    	}else{
    		echo "<script type = 'text/javascript'>alert('Invalid Username/Password');</script>";
    	}	
    }else if($_GET['action']=='logout'){
    	unset($_SESSION['success']);
    	unset($_SESSION['userID']);
    	unset($_SESSION['whoIsIt']);
    }else if($_GET['action']=='available'){
    	$userID = $_SESSION['userID'];
    	$sql = "UPDATE user SET status = 'available' WHERE userID = '$userID'";if($conn->query($sql)){}else{echo $conn->error;}
    }else if($_GET['action']=='unavailable'){
    	$userID = $_SESSION['userID'];
    	$sql = "UPDATE user SET status = 'unavailable' WHERE userID = '$userID'";if($conn->query($sql)){}else{echo $conn->error;}
    }
  }//Bracket for get action validation
  //update status
  if(isset($_SESSION['success'])){
  	$userID = $_SESSION['userID'];
  	$sql = "SELECT * FROM user WHERE userID = '$userID'";
  	$result = mysqli_query($conn,$sql);
  	$row = mysqli_fetch_assoc($result);
  	$_SESSION['status']=$row['status'];
  }
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
		    <a href="cart.php">
		    <?
		    if(isset($_SESSION['success'])){
		    	if($_SESSION['whoIsIt']=='user'||$_SESSION['whoIsIt']=='vendor'){
		    		echo "MyOrders";
		    	}elseif($_SESSION['whoIsIt']=='admin'){
		    		echo "Analytics";
		    	}
		    }else{
		    	echo "MyOrders";
		    }
		    ?>
		    </a>
		    <!-- This should be the same for either users or vendor -->
		  </div>
		  <div class = "container2">
		  	<p id = "welcomeText" ></p>
		  </div>
		  <div class = "container3">
		  <a id = "topRightButton"class = "logout" href = "javascript:openForm()"></a>
		  <a id = "signUp" class = "logout" href="/newWebsite/register.php"><?
		  if(isset($_SESSION['whoIsIt'])){
		  	if($_SESSION['whoIsIt']=='admin'){
		  		echo "addUser";
		  	}else{
		  	}
		  }else{
		  	echo "SignUp";
		  }
		  ?></a>
      </div>
		  
      
      <!-- I want this to be only be shown if not logged in -->
    </div>
    <div class = "filter2" id = "filter">
      <div class = "popupFormWrap">
        <form class = "popupForm"  method = "post" action = "index.php?action=login">
          <p>Login</p>
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
    document.getElementById("signUp").className = "logout";
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
  		document.getElementById('tableVerify').style.display = "none";
  		document.getElementById('current').innerHTML = "Currently Viewing: User";
  	}else if(who == 'vendor'){
  		document.getElementById("tableVendor").style.display = "table";
  		document.getElementById("tableUser").style.display = "none";
  		document.getElementById('tableVerify').style.display = "none";
  		document.getElementById('current').innerHTML = "Currently Viewing: Vendor";
  	}else if(who == 'verify'){
  		document.getElementById('tableVerify').style.display = "table";
  		document.getElementById('tableUser').style.display = "none";
  		document.getElementById('tableVendor').style.display = "none";
  		document.getElementById('current').innerHTML = "Currently Viewing: Verify List";
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
  function changeStatus(){
  		var status = "<?php if(isset($_SESSION['status'])){echo $_SESSION['status'];}else{echo 'false';}?>";
  		if(status == 'available'){
  			//user is already available , now change to unavailable
 				window.location = "index.php?action=unavailable";
  			
  		}else if(status == 'unavailable'){
  			//user is already unavailable , now change to available
  			window.location = "index.php?action=available";
  		
  		}else{
  			//Error
  		}
  }
  function checkStatus(){
  		var status = "<?php if(isset($_SESSION['status'])){echo $_SESSION['status'];}else{echo 'false';}?>";
  		if(status == 'available'){
  			//user is already available , now change to unavailable
  			document.getElementById('checkBox').checked = true;
  		}else if(status == 'unavailable'){
  			//user is already unavailable , now change to available
  			document.getElementById('checkBox').checked = false;
  		}else{
  			//Error
  		}
  }
  
  function changeChart(chart){
  	if(chart == 'hostel'){
  		document.getElementById('chart_div').style.display = "block";
  		document.getElementById('chart_div2').style.display = "none";
  		document.getElementById('chart_div3').style.display = "none";
  	}else if(chart == 'satria'){
  		document.getElementById('chart_div').style.display = "none";
  		document.getElementById('chart_div2').style.display = "block";
  		document.getElementById('chart_div3').style.display = "none";
  	}else if(chart == 'lestari'){
  		document.getElementById('chart_div').style.display = "none";
  		document.getElementById('chart_div2').style.display = "none";
  		document.getElementById('chart_div3').style.display = "block";
  	}
  }
 

  

</script>
