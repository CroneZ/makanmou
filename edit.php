<?php 
	require_once("template/headerTemplate.php");

?>
<body onload = "checkLogin();">
<?php
	if(isset($_GET['user'])){
	$userID = $_GET['user'];
	if(isset($_POST['updateUser'])){
		if($_POST['pass1'] == $_POST['pass2']){
			if($_POST['pass1']==$row['password']){
				$email = $_POST['email'];
				$upSql = "UPDATE user SET email = '$email' WHERE userID = '$userID'";
			}
			$upSql = "UPDATE user SET (email,password) WHERE userID = '$userID'";
		}else{
			
		}
	}
	$sql="SELECT * FROM user WHERE userID = '$userID'";
	$result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_assoc($result);
	if(isset($_POST['updateUser'])){
		if($_POST['pass1'] == $_POST['pass2']){
			if($_POST['pass1']==$row['password']){
				$email = $_POST['email'];
				$upSql = "UPDATE user SET email = '$email' WHERE userID = '$userID'";
			}
			$upSql = "UPDATE user SET (email,password) WHERE userID = '$userID'";
		}else{
			
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
			<input type = "text" value = "<?php echo $row['email']; ?>" />
		</div>
		<div class = "rowFlex">
			<p>Password</p>
			<input type = "password" name = "pass1" value = "<? echo $row['password']; ?>"/>
		</div>
		<div class = "rowFlex">
			<p>Retype Password</p>
			<input type = "password" name = "pass2" value = "<? echo $row['password']; ?>"/>
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
	
?>

</body>
