<?php include_once("template/headerTemplate.php");
      include_once("template/databaseConnection.php");
	
	if(isset($_SESSION['whoIsIt'])){
		if($_SESSION['whoIsIt'] == "vendor"){
		?>
		<body onload = "checkLogin();">
			<div class = "pageWrap">
				<div class = "profileContainer">
					<?
						$userID = $_SESSION['userID'];
						$imgSql = "SELECT * FROM user WHERE userID = '$userID'";
						$result = mysqli_query($conn,$imgSql);
						$row = mysqli_fetch_assoc($result);
						?>
						<h1><? echo $row['userID'] ?></h1>
						<h2>Your Menu</h2>
						<?
if($_SESSION['userID']){//module for show certain user
	$vendorID = $_SESSION['userID'];
?>
		<div>
				<?php
					$mSql = "SELECT * FROM menulist WHERE vendorID = '$vendorID'";
					if(isset($_POST['search'])){
						$keyword = $_POST['keyword'];
						$mSql = "SELECT * FROM menulist WHERE productName LIKE '%$keyword%'";
					}
					$result = mysqli_query($conn,$mSql);
					while($row = mysqli_fetch_array($result)){
          ?>
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
              <form class = "editDetailsVENDOR" action = "editMenu.php?action=edit&user=<?php echo $userID; ?>&itemID=<? $itemID = $row['productID']; echo $itemID ?>" method="post" >
							<input type = "submit" name = "edit" value = "EDIT" onclick = "checkUser();"/>
              </form>
            </div>
          </div>
          <?php
        }
				?>
				</div>
<?
}
					?>
				</div>
			</div>
			</body>
		<?
		}elseif($_SESSION['whoIsIt']=="admin"){
			?>
			<body onload = "checkLogin()">
			<div class = "mainWrap">
				<div class = "leftContainer">
					<div class = "switchView">
						<h1 id="current">Currently Viewing: User</h1>
						<div class = "viewButtonPanel">
							<input type = "button" name = "user" value = "user" onclick = "changeCurrent('user');"/>
							<input type = "button" name = "vendor" value = "vendor" onclick = "changeCurrent('vendor');"/> 
							<input type = "button" name = "verify" value = "verify" onclick = "changeCurrent('verify');"/> 
						</div>
						<div id = "table" class  = "tableGeneral">
							<table id = "tableUser" class ="tableUser">
							<tr>
								<th>userID</th>
								<th>email</th>
								<th>status</th>
								<th></th>
							</tr>
								<?php
								$query = "SELECT * FROM user WHERE identity = 'user'";
								$result = mysqli_query($conn,$query);
								while($row = mysqli_fetch_assoc($result)){
								$userID = $row['userID'];
								$email = $row['email'];
								$status = $row['status'];
								?>
									<tr>
										<td><?php echo $userID;?></td>
										<td><?php echo $email;?></td>
										<td><?php echo $status;?></td>
										<td><form class = "editDetails" method ="post" action = "edit.php?action=edit&user=<?php echo $userID; ?>"><input type = "submit" name = "edit" value = "edit"/></form>
										<form class = "editDetails" method ="post" action = "edit.php?action=delete&user=<?php echo $userID; ?>"><input type = "submit" name = "delete" value = "delete"/></form></td>					
									</tr>								
								<?php
								}
								?>
							</table>
							<table id = "tableVendor" class = "tableVendor">
							<tr>
								<th>userID</th>
								<th>email</th>
								<th>status</th>
								<th></th>
							</tr>
								<?php
								$query = "SELECT * FROM user WHERE identity = 'vendor'";
								$result = mysqli_query($conn,$query);
								while($row = mysqli_fetch_assoc($result)){
								$userID = $row['userID'];
								$email = $row['email'];
								$status = $row['status'];
								?>
									<tr>
										<td><?php echo $userID;?></td>
										<td><?php echo $email;?></td>
										<td><?php echo $status;?></td>
										<td><form class = "editDetails" method ="post" action = "edit.php?action=edit&user=<?php echo $userID; ?>"><input type = "submit" name = "edit" value = "edit"/></form>
								<form class = "editDetails" method ="post" action = "edit.php?action=delete&user=<?php echo $userID; ?>"><input type = "submit" name = "delete" value = "delete"/></form>
								<form class = "editDetails" method ="post" action = "editMenu.php?user=<? echo $userID;?>"><input type = "submit" name = "menu" value = " add menu"/></form>
								<form class = "editDetails" method = "post" action = "viewMenu.php?action=view&user=<?echo $userID;?>"><input type = "submit" name  =" editMenu "	value = "viewMenu"/></td>	
									</tr>
								<?php
								}
								?>
							</table>
							<table id = "tableVerify" class = "tableVerify">
							<tr>
								<th>userID</th>
								<th>email</th>
								<th></th>
							</tr>
								<?php
								$query = "SELECT * FROM waitingList";
								$result = mysqli_query($conn,$query);
								while($row = mysqli_fetch_assoc($result)){
								$userID = $row['userID'];
								$email = $row['email'];
								$waitingID = $row['waitingID'];
								?>
									<tr>
										<td><?php echo $userID;?></td>
										<td><?php echo $email;?></td>
										<td><form class = "editDetails" method ="post" action = "edit.php?action=verifyW&user=<?php echo $waitingID; ?>"><input type = "submit" name = "verify" value = "verify"/></form>
								<form class = "editDetails" method ="post" action = "edit.php?action=deleteW&user=<?php echo $waitingID; ?>"><input type = "submit" name = "delete" value = "delete"/></form></td>		
									</tr>
								<?php
								}
								?>
							</table>
						</div>	
					</div>				
				</div>				
				<div class = "registerPanel">
					<h1>Register</h1>
					<input type = "button" name = "user" value = "user" onclick = "registerUser('user')"/>
					<input type = "button" name = "vendor" value = "vendor" onclick = "registerUser('vendor')"/> 
				</div>
			</div>			
			</body>
			<?php
		}else{
			include_once("menuBody.php");
		}
	}else{
			include_once("menuBody.php");	
	}       
       
?>
