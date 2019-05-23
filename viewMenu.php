<?
	include_once("template/headerTemplate.php");
	include_once("template/databaseConnection.php");
	
	if($_GET['action']){
		if($_GET['action']=='view'){
			if($_GET['user']){
			$vendorID = $_GET['user'];
			$mSql = "SELECT * FROM menulist WHERE vendorID = '$vendorID'";
					if(isset($_POST['search'])){
						$keyword = $_POST['keyword'];
						$mSql = "SELECT * FROM menulist WHERE productName LIKE '%$keyword%'";
					}
					$result = mysqli_query($conn,$mSql);
					while($row = mysqli_fetch_array($result)){
          ?>
          <body onload = "checkLogin();">
          <div class = "menuWrap">
            <div class = "images">
              <div class = "diagram">
                <img class = "diagramBox" src = <?php echo $row["imagePath"]; ?> />
              </div>
              <div class = "imgName">
              <h2><?php echo $row["productName"]; ?></h2>
              <p><?php echo $row["productDesc"]; ?></p>
              <p>RM<?php echo $row["productPrice"];?></p>
            </div>
            <div class = "orderForm">
              <form class = "editDetailsVENDOR" action = "editMenu.php?action=edit&user=<?php echo $vendorID; ?>&itemID=<? $itemID = $row['productID']; echo $itemID ?>" method="post" >
							<input type = "submit" name = "edit" value = "EDIT" onclick = "checkUser();"/>
              </form>
            </div>
          </div>
          </body>
          <?php
        }
			}
		}
	}
?>
