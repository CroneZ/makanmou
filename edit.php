<?php 
	require_once("template/headerTemplate.php");

?>
<body onload = "checkLogin();">
<?php
if(isset($_GET['action'])){
	if($_GET['action']=='edit'){
			if(isset($_GET['user'])){
	$userID = $_GET['user'];
	$sql="SELECT * FROM user WHERE userID = '$userID'";
	$result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_assoc($result);
	if(isset($_POST['updateUser'])){
		if($_POST['pass1'] === $_POST['pass2']){
		$email = $_POST['email'];
		$password = mysqli_real_escape_string($conn,$_POST['pass1']);
		$password = md5($password);
			if($password == $row['userPasswd']){
				$upSql = "UPDATE user SET email = '$email' WHERE userID = '$userID'";
				mysqli_query($conn,$upSql);
				$sql="SELECT * FROM user WHERE userID = '$userID'";
				$result = mysqli_query($conn,$sql);
				$row = mysqli_fetch_assoc($result);
			}else{			
				$upSql = "UPDATE user SET email = '$email', userPasswd = '$password' WHERE userID = '$userID'";
				mysqli_query($conn,$upSql);
				$sql="SELECT * FROM user WHERE userID = '$userID'";
				$result = mysqli_query($conn,$sql);
				$row = mysqli_fetch_assoc($result);
			}			
		}else{
			$message = "Password doesn't match!";
			echo "<script type = 'text/javascript'>alert('$message');</script>";
		}
	}
	?>
			<div class = "columnFlex">
		<form method = "post" action = "edit.php?user=<?php echo $userID ;?>">
		<div class = "rowFlex">
			<p>Username: <?php echo $row['userID']; ?></p>
		</div>
		<div class = "rowFlex">
			<p>Email</p>
			<input type = "text" name = "email" value = "<?php echo $row['email']; ?>" />
		</div>
		<div class = "rowFlex">
			<p>Password</p>
			<input type = "password" name = "pass1" value = "<? echo $row['userPasswd']; ?>"/>
		</div>
		<div class = "rowFlex">
			<p>Retype Password</p>
			<input type = "password" name = "pass2" value = "<? echo $row['userPasswd']; ?>"/>
		</div>
		<input type = "submit" name = "updateUser" value = "update" />
	</form>	
	</div>
	<?
}else{
	?>
		<h1>ERROR PLEASE GO BACK TO INDEX PAGE</h1>
	<?
}
	}elseif($_GET['action']=='delete'){
		if($_GET['user']){
			$userID = $_GET['user'];
			$dSql = "DELETE FROM user WHERE userID = '$userID'";
			mysqli_query($conn,$dSql);
			$message = "UserDeleted!";
			$url = "index.php";
			echo "<script type = 'text/javascript'>alert('$message');
			window.location='$url';</script>";
		}else{
		?>
			<h1>ERROR PLEASE GO BACK TO INDEX PAGE</h1>
		<?
		}
	}elseif($_GET['action']=='verifyW'){
		if($_GET['user']){
			$waitingID = $_GET['user'];
			$vSql = "INSERT INTO user(userID,userPasswd,email) SELECT userID,userPasswd,email FROM waitingList WHERE waitingID = '$waitingID'";
			if($conn->query($vSql)==true){
				$upSql = "UPDATE user SET identity = 'vendor', status = 'Verified' WHERE userID IN (SELECT userID FROM waitingList WHERE waitingID = '$waitingID')";	
				if($conn->query($upSql)==true){
				/*
					$message = "Done!";
					$url = "index.php";
					echo "<script type = 'text/javascript'>alert('$message');
					window.location='$url';</script>";
				*/
					$delSql = "DELETE FROM waitingList WHERE waitingID = '$waitingID'";
					if($conn->query($delSql)){
						$message = "Done!";
						$url = "index.php";
						echo "<script type = 'text/javascript'>alert('$message');
						window.location='$url';</script>";
					}else{
						echo $conn->error;
					}
				}else{
					echo $conn->error;
					echo $waitingID;
				}//end of check for identity update
			}//end of check for insert query
		}//end of check for $_GET['user']
	}elseif($_GET['action']=='deleteW'){
		if($_GET['user']){
			$waitingID = $_GET['user'];
			$delSql = "DELETE FROM waitingList WHERE waitingID = '$waitingID'";
			if($conn->query($delSql)){
				$message = "Done!";
				$url = "index.php";
				echo "<script type = 'text/javascript'>alert('$message');
				window.location='$url';</script>";
			}else{
				echo $conn->error;
			}
		}
	}
}
	
?>

</body>
