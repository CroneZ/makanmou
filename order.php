<?
	include_once("template/headerTemplate.php");
	include_once("template/databaseConnection.php");
	
	if(isset($_SESSION['userID'])){
		if(isset($_SESSION['whoIsIt'])){
			if($_SESSION['whoIsIt']=='user'){
				if($_SESSION['status']=='Verified'){
					if($_GET['action']&&$_GET['id']){
					if($_GET['action']=='add'){
						$userID = $_SESSION['userID'];
						$itemID = $_GET['id'];
						$quantity  = $_POST['quantity'];
						
						$sql = "SELECT * FROM menulist WHERE productID = '$itemID'";
						$result = mysqli_query($conn,$sql);
						$row = mysqli_fetch_assoc($result);
						$vendorID = $row['vendorID'];						
						
						$sql = "INSERT INTO cart(productID,quantity,userID,vendorID) VALUES('$itemID','$quantity','$userID','$vendorID')";
						if($conn->query($sql)==true){
							//inserted into cart
							$message = "ItemAdded!";
								$url = "index.php";
								echo "<script type = 'text/javascript'>alert('$message');window.location = '$url'</script>";
						}else{
							echo $conn->error;
						}
					}
				}
			}else{
				$message = "Please verify your account to proceed";
				$url = "index.php";
				echo "<script type = 'text/javascript'>alert('$message');window.location = '$url'</script>";
			}
			}else{ //This is for none user who clicked on the add to cart button
				$message = "Please Login";
				$url = "index.php";
				echo "<script type = 'text/javascript'>alert('$message');window.location = '$url'</script>";
			}
		}
	}else{
	//add notification later pls
		$message = "Please Login";
		$url = "index.php";
		echo "<script type = 'text/javascript'>alert('$message');window.location = '$url'</script>";
	}
?>
	<body onload = "checkLogin();"></body>
<?
?>
