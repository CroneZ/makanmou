<?php
	require_once("template/databaseConnection.php");
	require_once("template/headerTemplate.php");
	
	if(isset($_GET['user'])){
		$userID = $_GET['user'];
			if(isset($_SESSION['whoIsIt'])){
			if($_SESSION['whoIsIt'] == 'admin' ){
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
	
	
	
?>


