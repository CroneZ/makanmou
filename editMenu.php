<?php
	require_once("template/databaseConnection.php");
	require_once("template/headerTemplate.php");
	
	if(isset($_GET['user'])){
		if(isset($_GET['action'])){
			if($_GET['action']=='edit'){
				$userID = $_GET['user'];
				$itemID = $_GET['itemID'];
				$sql = "SELECT * FROM menulist WHERE productID = '$itemID'";
				$result = mysqli_query($conn,$sql);
				$row = mysqli_fetch_assoc($result);
				$productName = $row['productName'];
				$productDesc = $row['productDesc'];
				$productPrice = $row['productPrice'];
				$imagePath = $row['imagePath'];
				?>
				<body onload = "checkLogin();">
					<div class = "menuRegister">
						<form method = "post" action = "editMenu.php?action=edit&user=<? echo $userID; ?>&itemID=<? echo $itemID; ?>" enctype = "multipart/form-data">
						<input type = "file" name = "imgFile" value = "imgFile">
								<p>Name Of the Product</p>
								<input type = "text" name = "itemName" value = "<? echo $productName; ?>" required>
								<p>Product Description</p>
								<input type = "text" name = "itemDesc" value = "<? echo $productDesc; ?>" required>
								<p>Product Price</p>
								<input type = "text" name = "itemPrice" value = "<? echo $productPrice; ?>" required>
								<input type = "submit" name="editVendor" value = "Submit" >
								<input type = "submit" name = "refresh" value = "refresh">
					</form>
					</div>
				</body>
				<?
				if(isset($_POST['editVendor'])){
					//check for difference
					if(isset($_POST['imgFile'])){
					//THERE IS CHANGE TO IMG FILE so DO UPDATE
						//Start of menu registration
						$files = $_FILES['imgFile'];
						//Example: Array ( [name] => DSC_0053jpg.JPG [type] => image/jpeg
						//[tmp_name] => C:\xampp\tmp\php2AD4.tmp [error] => 0 [size] => 1074154 )
						$fileName = $_FILES['imgFile']['name'];
						$fileType = $_FILES['imgFile']['type'];
						$fileTmpName = $_FILES['imgFile']['tmp_name'];
						$fileError = $_FILES['imgFile']['error'];
						$fileSize = $_FILES['imgFile']['size'];

						//Get the type from the name and lowercase it
						$fileExt = explode('.', $fileName);
						$fileRealExt = strtolower(end($fileExt));
						//Check for ext to see whether is allowed
						$allowed  = array('jpg' , 'jpeg','png');
						if(in_array($fileRealExt, $allowed)){
							if($fileError===0){
								if($fileSize < 2000000000000){
								  //Move item from temp file to designated area
								  $fileNewName  = uniqid('',true).".".$fileRealExt;
								  $imagePath = 'images/'.$fileNewName;
								  if(move_uploaded_file($fileTmpName, $imagePath)){
								  }else{
								    $message = "Did not upload successfully";
								    echo $fileTmpName;
								    echo exec('whoami');
								    echo "<script type = 'text/javascript'>alert('$message')</script>";
								  }

								  //Entering details into database
								  $sql = "UPDATE menulist SET imagePath = '$imagePath' WHERE itemID = '$itemID'";
								  if ($conn->query($sql) === TRUE){
								    echo '<script type = text/javascript>alert("Menu Updated!");</script>';
								  }else{
								    echo "Error: " . $sql . "<br>" . $conn->error;
								  }

								  //Check user and details before entering database

								}else{
								  $message = "Your File is too BIG!";
								  echo "<script type = 'text/javascript'>alert('$message')</script>";
								}
							}else{
								$message = "Error in uploading file please try again";
								echo "<script type = 'text/javascript'>alert('$message')</script>";
							}
						}else{
							$message = "You cannot upload files of this type";
							echo "<script type = 'text/javascript'>alert('$message')</script>";
						}
		  //end of file update
					}else{
					}
					if(isset($_POST['itemName'])){
						if($productName!=$_POST['itemName']){
							$productName = $_POST['itemName'];
							$sql = "UPDATE menulist SET productName = '$productName' WHERE productID = '$itemID'";
							if($conn->query($sql)==true){
								//name Updated
								unset($productName);
							}else{
								echo $conn->error;
							}
						}
					}else{
						//user did not enter for name of the product
						$message = "Please Enter the Name";
						echo "<script type = 'text/javascript'>alert('$message')</script>";
					}//End for checking name change
					if(isset($_POST['itemDesc'])){
						if($productDesc!=$_POST['itemDesc']){
							$productDesc = $_POST['itemDesc'];
							$sql = "UPDATE menulist SET productDesc = '$productDesc' WHERE productID = '$itemID'";
							if($conn->query($sql)==true){
								//desc Updated
							}else{
								echo $conn->error;
							}
						}
					}else{
						//user did not enter for desc of the product
						$message = "Please Enter the Description";
						echo "<script type = 'text/javascript'>alert('$message')</script>";
					}//End for checking desc change
					if(isset($_POST['itemPrice'])){
						if($productPrice!=$_POST['itemPrice']){
							$productPrice = $_POST['itemPrice'];
							$sql = "UPDATE menulist SET productPrice = '$productPrice' WHERE productID = '$itemID'";
							if($conn->query($sql)==true){
								//price Updated
							}else{
								echo $conn->error;
							}
						}
					}else{
						//user did not enter for price of the product
						$message = "Please Enter the Price";
						echo "<script type = 'text/javascript'>alert('$message')</script>";
					}//End for checking price change								
				}//End of check for whether EditVendor set exist
			}
		}else{
				$userID = $_GET['user'];
				if(isset($_SESSION['whoIsIt'])){
				if($_SESSION['whoIsIt'] == 'admin' OR 'vendor' ){
					?>
						<body onload = "checkLogin()">
							<div class = "menuRegister">
								<form method = "post" action = "editMenu.php?user=<?php echo $_GET['user'];?>" enctype="multipart/form-data">
								<input type = "file" name = "imgFile" value = "imgFile">
								<p>Name Of the Product</p>
								<input type = "text" name = "itemName" placeholder="Enter the name of the Product">
								<p>Product Description</p>
								<input type = "text" name = "itemDesc" placeholder="Tell us more about it">
								<p>Product Price</p>
								<input type = "text" name = "itemPrice" placeholder="How much does it cost">
								<input type = "submit" name="regVendor" value = "Submit" >
								</form>	
							</div>
						</body>							
					<?php
				}else{
					?>
						<body onload = "checkLogin()">
							<h1>ERROR: UNAUTHORIZED ACCESS</h1>
						</body>
					<?php
				}
			}else{
				//User has not logged in
				?>
					<body onload = "checkLogin()">
							<h1>ERROR: UNAUTHORIZED ACCESS</h1>
						</body>
				<?php
			}
			if(isset($_POST['regVendor'])){
		  //Start of menu registration
		  $files = $_FILES['imgFile'];
		  //Example: Array ( [name] => DSC_0053jpg.JPG [type] => image/jpeg
		  //[tmp_name] => C:\xampp\tmp\php2AD4.tmp [error] => 0 [size] => 1074154 )
		  $fileName = $_FILES['imgFile']['name'];
		  $fileType = $_FILES['imgFile']['type'];
		  $fileTmpName = $_FILES['imgFile']['tmp_name'];
		  $fileError = $_FILES['imgFile']['error'];
		  $fileSize = $_FILES['imgFile']['size'];

		  //Get the type from the name and lowercase it
		  $fileExt = explode('.', $fileName);
		  $fileRealExt = strtolower(end($fileExt));
		  //Check for ext to see whether is allowed
		  $allowed  = array('jpg' , 'jpeg','png');
		  if(in_array($fileRealExt, $allowed)){
		    if($fileError===0){
		      if($fileSize < 2000000000000){
		        $itemName = mysqli_real_escape_string($conn, $_POST['itemName']);
		        $itemDesc = mysqli_real_escape_string($conn, $_POST['itemDesc']);
		        $itemPrice = mysqli_real_escape_string($conn, $_POST['itemPrice']);

		        //Move item from temp file to designated area
		        $fileNewName  = uniqid('',true).".".$fileRealExt;
		        $imagePath = 'images/'.$fileNewName;
		        if(move_uploaded_file($fileTmpName, $imagePath)){
		        }else{
		          $message = "Did not upload successfully";
		          echo $fileTmpName;
		          echo exec('whoami');
		          echo "<script type = 'text/javascript'>alert('$message')</script>";
		        }

		        //Entering details into database
		        $sql = "INSERT INTO menulist (productName,productDesc,productPrice,
		          imagePath,vendorID) VALUES ('$itemName','$itemDesc','$itemPrice','$imagePath','$userID')";
		        if ($conn->query($sql) === TRUE){
		          echo '<script type = text/javascript>alert("Menu Updated!");</script>';
		        }else{
		          echo "Error: " . $sql . "<br>" . $conn->error;
		        }

		        //Check user and details before entering database

		      }else{
		        $message = "Your File is too BIG!";
		        echo "<script type = 'text/javascript'>alert('$message')</script>";
		      }
		    }else{
		      $message = "Error in uploading file please try again";
		      echo "<script type = 'text/javascript'>alert('$message')</script>";
		    }
		  }else{
		    $message = "You cannot upload files of this type";
		    echo "<script type = 'text/javascript'>alert('$message')</script>";
		  }
			}
		}
	}
	
	
	
?>


