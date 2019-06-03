<?
	include_once("template/headerTemplate.php");
	include_once("template/databaseConnection.php");
	
	if(isset($_SESSION['userID'])){
		//check if user is vendor
		$userID = $_SESSION['userID'];
		$sql = "SELECT * FROM user WHERE userID = '$userID'";
		$result = mysqli_query($conn,$sql);
		$row = mysqli_fetch_assoc($result);
		if($row['identity']=='vendor'){
				if(isset($_GET['action'])){
					if($_GET['action']=='complete'){
					$id = $_GET['id'];
					//update the status in pending database
					$uSql = "UPDATE pendingOrder SET status = 'waitingUser' WHERE pendingID = $id ";
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
						<div class = "vendorSearch">
							<h1>Search:</h1>
							<form method = "post" action = "cart.php">
								<input type = "text" name = "keyword" placeholder = "Enter Address" required/>
								<input type = "submit" name = "search" style = "display:none;"/>
							</form>
							
						</div>
					</div>
					<?
					$tableSql = "SELECT * FROM pendingOrder WHERE vendorID = '$userID'";
					if(isset($_POST['search'])){
						$address = $_POST['keyword'];
						$tableSql = "SELECT * FROM pendingOrder WHERE address LIKE '%$address%' AND vendorID = '$userID'";
					}
					$result = mysqli_query($conn,$tableSql);
					echo $conn->error;
					while($row = mysqli_fetch_assoc($result)){
					?>
				<div class = "tableWrap">
					<div class = "tableHeader">
						<h2><?echo "Order#".$row['pendingID'];?></h2>
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
							$price = 0;
							$arrA = explode(';',$row['encryption']);
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
								$price = $price + $nRow['productPrice']*$quantity;
							}
						?>
						</table>
						<?$id = $row['pendingID'];?>	
						<form method = "post" action = "cart.php?action=complete&id=<?echo $id;?>">			<h2>TOTAL DUE: RM<?echo $price;?></p>
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
			$string = '';
				$address = $_GET['address'];
				$sql = "SELECT * FROM user WHERE identity = 'vendor'";
				$result = mysqli_query($conn,$sql);
				echo $conn->error;
				while($row = mysqli_fetch_assoc($result)){
					$string = '';
					$vendorID = $row['userID'];
					$aSql = "SELECT * FROM cart WHERE userID = '$userID' AND vendorID = '$vendorID'";
					$aResult = mysqli_query($conn,$aSql);
					while($aRow = mysqli_fetch_assoc($aResult)){
						$item = $aRow['productID'];
						$quantity = $aRow['quantity'];
						$string = "$string$item,$quantity;";
					}//encryption done
					$iSql = "INSERT INTO pendingOrder (userID,vendorID,encryption,address) VALUES ('$userID','$vendorID','$string','$address')";
					if($conn->query($iSql)){
						//success
						//move to archived after all is saved
					}else{
						echo $conn->error;
					}
				}
				$cSql = "INSERT INTO archiveCart(productID,quantity,userID) SELECT productID,quantity,userID FROM cart WHERE userID = '$userID'";
				if($conn->query($cSql)){
					//remove useless record
					$dSql = "DELETE FROM cart WHERE userID = '$userID'";
					if($conn->query($dSql)){
						//success in removing useless record
					}else{
						echo $conn->error;
					}
				}else{
					echo $conn->error;
				}
			}elseif($_GET['action']=='complete'){
				$id = $_GET['id'];
				$price = 0;
				$cSql = "SELECT * FROM pendingOrder WHERE pendingID = '$id'";				
				$result = mysqli_query($conn,$cSql);
				$row = mysqli_fetch_assoc($result);
				$arrA = explode(';',$row['encryption']);
					for($i=0;$i<sizeof($arrA)-1;$i++){
						$pair = explode(",",$arrA[$i]);
						$productID = $pair[0];
						$quantity = $pair[1];
						$sql = "SELECT * FROM menulist WHERE productID = $productID";
						$nResult = mysqli_query($conn,$sql);
						$nRow = mysqli_fetch_assoc($nResult);
						$price = $price + $nRow['productPrice']*$quantity;
					}
				if($row['status']=='waitingUser'){
					$uSql = "INSERT INTO archivedOrder(encryption,vendorID,userID,address,payment) SELECT encryption,vendorID,userID,address, '$price' FROM pendingOrder WHERE pendingID = '$id'";
					if($conn->query($uSql)==true){
						$dSql = "DELETE FROM pendingOrder WHERE pendingID = '$id'";
						if($conn->query($dSql)){
							//delete success
						}else{
							$conn->error;
						}
					}else{
						echo $conn->error;
					}
				}else{
					$message = "Please wait for vendor to deliver!";
					$url = "cart.php";
					echo "<script type = 'text/javascript'>alert('$message');window.location = '$url'</script>";

				}
			}
		}
		$sql = "SELECT * FROM cart WHERE userID = '$userID'";
		$result = mysqli_query($conn,$sql);
		$counter = 1;
		?>
			<body onload = "checkLogin();">
			<div class = "upperBody" >
				<h1>Cart</h1>
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
			<div><!--div wrapping the upper body-->
			<div class = "lowerBody">
				<h1>Orders</h1>
				<?
					$sql = "SELECT * FROM pendingOrder WHERE userID = '$userID'";
					$result = mysqli_query($conn,$sql);
					while($row = mysqli_fetch_assoc($result)){
					?>
						<div class = "tableWrap">
							<div class = "tableHeader">
								<h2><?echo "Order#".$row['pendingID'];?></h2>
								<h2><?echo $row['address'];?></h2>
								<h2>Status: <?echo $row['status']?></h2>
								<!--ADD A SUBMIT BUTTON FOR VENDOR CONFIRMATION -->
								</div>
								<table>
								<tr>
									<th>product</th>
									<th>quantity</th>
									<th>price</th>
								</tr>
								<?
									$price = 0;
									$arrA = explode(';',$row['encryption']);
									for($i=0;$i<sizeof($arrA)-1;$i++){
										$pair = explode(",",$arrA[$i]);
										$productID = $pair[0];
										$quantity = $pair[1];
										$sql = "SELECT * FROM menulist WHERE productID = $productID";
										$nResult = mysqli_query($conn,$sql);
										$nRow = mysqli_fetch_assoc($nResult);
										$name = $nRow['productName'];
											?>
											<tr>
												<td><?echo $name;?></td>
												<td><?echo $quantity;?></td>
												<td><?echo $nRow['productPrice']*$quantity;?>
											</tr>
											<?
											$price = $price + $nRow['productPrice']*$quantity;
									}
								?>
								</table>
								<?$id = $row['pendingID'];?>	
								<form method = "post" action = "cart.php?action=complete&id=<?echo $id;?>">
								<h2>TOTAL DUE: RM<?echo $price?></h2>
									<input type = "submit" value = "Complete" name = "userConfirm"/>
								</form>
							</div>

					<?
					}
				?>
			</div>
		<?
	}//end of check session user	
		//end of user interface
		}else if($row['identity']=='admin'){
			$url = "chart.php";
			echo "<script type = 'text/javascript'>window.location = '$url'</script>";
		}
	
	}else{//Error handling for unauthorized access
		$message = "Please LogIn";
		$url = "index.php";
		echo "<script type = 'text/javascript'>alert('$message');window.location = '$url'</script>";

	}
?>
