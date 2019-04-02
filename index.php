<?php include_once("template/headerTemplate.php");
      include_once("template/databaseConnection.php");
	
	if(isset($_SESSION['whoIsIt'])){
		if($_SESSION['whoIsIt'] == "vendor"){
		
		}elseif($_SESSION['whoIsIt']=="admin"){
			?>
			<body onload = "checkLogin()">
			<div class = "mainWrap">
				<div class = "leftContainer">
					<div class = "switchView">
						<h1 id="current">Currently Viewing:</h1>
						<div class = "viewButtonPanel">
							<input type = "button" name = "user" value = "user" onclick = "changeCurrent('user');"/>
							<input type = "button" name = "vendor" value = "vendor" onclick = "changeCurrent('vendor');"/> 
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
										<td><form class = "editDetails" method ="post" action = "edit.php?user=<?php echo $userID; ?>"><input type = "submit" name = "edit" value = "edit"/>
																																											 <input type = "submit" name = "delete" value = "delete"/></form></td>					
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
										<td><form class = "editDetails" method ="post" action = "edit.php?user=<?php echo $userID; ?>"><input type = "submit" name = "edit" value = "edit"/>
																																											 <input type = "submit" name = "delete" value = "delete"/></form></td>		
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
