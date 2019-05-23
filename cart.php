<?
	include_once("template/headerTemplate.php");
	include_once("template/databaseConnection.php");
	
	if($_SESSION['userID']){
		//check if user is vendor
		$userID = $_SESSION['userID'];
		$sql = "SELECT * FROM user WHERE userID = '$userID'";
		$result = mysqli_query($conn,$sql);
		$row = mysqli_fetch_assoc($result);
		if($row['identity']=='vendor'){
				if(isset($_GET['action'])){
					if($_GET['action']=='complete'){
					$id = $_GET['id'];
					$uSql = "UPDATE orderList SET status = 'waitingUser' WHERE orderID = $id ";
					if($conn->query($uSql)==true){
						//update successful
					}else{
						echo $conn->error;
					}
				}
			}
			?>
			<body onload = "checkLogin();">
				<div class = "pageWrap">
					<div class = "profileContainer">
						<h1><?echo $row['userID'];?></h1>
						<div>
							<h1>Search:</h1>
							<form method = "post" action = "cart.php">
								<input type = "text" name = "keyword" placeholder = "Enter Address" required/>
								<input type = "submit" name = "search" style = "display:none;"/>
							</form>
							
						</div>
					</div>
					<?
					$tableSql = "SELECT * FROM orderList";
					if(isset($_POST['search'])){
						$address = $_POST['keyword'];
						$tableSql = "SELECT * FROM orderList WHERE address LIKE '%$address%'";
					}
					$result = mysqli_query($conn,$tableSql);
					echo $conn->error;
					while($row = mysqli_fetch_assoc($result)){
					?>
				<div class = "tableWrap">
					<div class = "tableHeader">
						<h2><?echo "Order#".$row['orderID'];?></h2>
						<h2><?echo $row['address'];?></h2>
						<h2>Status: <?echo $row['status']?></h2>
						<!--ADD A SUBMIT BUTTON FOR VENDOR CONFIRMATION -->
						</div>
						<table>
						<tr>
							<th>productID</th>
							<th>quantity</th>
							<th>price</th>
						</tr>
						<?
							$arrA = explode(';',$row['encryptedCart']);
							for($i=0;$i<sizeof($arrA)-1;$i++){
								$pair = explode(",",$arrA[$i]);
								$productID = $pair[0];
								$quantity = $pair[1];
								$sql = "SELECT * FROM menulist WHERE productID = $productID";
								$nResult = mysqli_query($conn,$sql);
								$nRow = mysqli_fetch_assoc($nResult);
								if($nRow['vendorID']==$userID){
									?>
									<tr>
										<td><?echo $productID;?></td>
										<td><?echo $quantity;?></td>
										<td><?echo $nRow['productPrice']*$quantity;?>
									</tr>
									<?
								}
							}
						?>
						</table>
						<?$id = $row['orderID'];?>	
						<form method = "post" action = "cart.php?action=complete&id=<?echo $id;?>">
							<input type = "submit" value = "Complete" name = "vendorConfirm"/>
						</form>
					</div>
					<?
					}
					?>
				</div>
			</body>
			<?
		}elseif($row['identity']=='user'){ // THIS IS USER INTERFACE
			if($_SESSION['userID']){
		$userID = $_SESSION['userID'];
		if(isset($_GET['action'])){
			if($_GET['action']=='remove'){
				if(isset($_GET['productID'])){
					$cartID = $_GET['productID'];
					$rSql = "DELETE FROM cart WHERE itemID = '$cartID'";
					if($conn->query($rSql)==true){
						//cart item should be removed
						$message = "ItemRemoved!";
						$url = "cart.php";
						echo "<script type = 'text/javascript'>alert('$message');window.location = '$url'</script>";
					}else{
						echo $conn->error;
					}
				}
			}elseif($_GET['action']=='order'){
				$sql = "SELECT * FROM cart WHERE userID  ='$userID'";
				$result = mysqli_query($conn,$sql);
				$string = '';
				$address = $_GET['address'];
				while($row = mysqli_fetch_assoc($result)){
					$item = $row['productID'];
					$quantity = $row['quantity'];
					$string = "$string$item,$quantity;";
				}//encryption is done!
				$sql = "INSERT INTO orderList (userID,encryptedCart,address) VALUES ('$userID','$string','$address')";
				if($conn->query($sql)){
					//Inserted
					//move them to archived
					$sql = "INSERT INTO archiveCart(productID,quantity,userID) SELECT productID,quantity,userID FROM cart WHERE userID = '$userID'";
					if($conn->query($sql)==true){
						//archived the stuff
						$sql = "DELETE FROM cart WHERE userID = '$userID'";
						if($conn->query($sql)==true){
							//deleted from cart
						}else{
							$conn->error;
						}
					}
				}else{
					echo $conn->error;
				}
			}
		}
		$sql = "SELECT * FROM cart WHERE userID = '$userID'";
		$result = mysqli_query($conn,$sql);
		$counter = 1;
		?>
			<body onload = "checkLogin();">
			<div class = "tableWrap">
			<table id = "tableCart" class = "tableCart" >
			<tr>
				<th>No.</th>
				<th>product</th>
				<th>quantity</th>
				<th></th>
			</tr>
		<?
		while($row = mysqli_fetch_assoc($result)){
			?>
				<tr>
					<td><?echo $counter?></td><?$counter++;?>
					<td><?
						$productID = $row['productID'];
						$cartID = $row['itemID'];
						$nSql = "SELECT * FROM menulist WHERE productID = '$productID'";
						$nResult = mysqli_query($conn,$nSql);
						$nRow = mysqli_fetch_assoc($nResult);
						$name = $nRow['productName'];
						echo $name;
					?></td>
					<td><?echo $row['quantity'];?></td>
					<td><form class = "editDetails" method = 'post' action = "cart.php?action=remove&productID=<?echo $cartID;?>">
					<input type = "submit" value = "remove"/></form></td>
				</tr>
			<?
		}
		?>
			</table>
			</div><!--div wrapping the table-->
			<div class = "cartSubmitWrap">
				<form class = "editDetails" method = 'post' action = "getAddress.php">
					<input type = "submit" value = "order"/>
				</form>
			</div><!--div wrapping the bar for submit button-->
		<?
	}	

		}
	
	}
?>
