<?
	include_once("template/headerTemplate.php");
	include_once("template/databaseConnection.php");
	
	if(isset($_SESSION['userID'])){
		if(isset($_SESSION['whoIsIt'])){
			if($_SESSION['whoIsIt']=='user'){
					if($_GET['action']&&$_GET['id']){
					if($_GET['action']=='add'){
						$userID = $_SESSION['userID'];
						$itemID = $_GET['id'];
						$quantity  = $_POST['quantity'];
						
						$sql = "INSERT INTO cart(productID,quantity,userID) VALUES('$itemID','$quantity','$userID')";
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
			}else{ //This is for none user who clicked on the add to cart button
				$message = "Please Login";
				$url = "index.php";
				echo "<script type = 'text/javascript'>alert('$message');window.location = '$url'</script>";
			}
		}
	}else{
	//add notification later pls
		echo "Please Log in";
	}
?>
	<body onload = "checkLogin();"></body>
<?
?>
