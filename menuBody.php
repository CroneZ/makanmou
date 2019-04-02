<body onload = "checkLogin()">
				<div class = "orderWrap">
					<div class = "content">
						<h1 class = "title">MAKANMOU</h1>
						<form class = "form" method = "post" action = "index.php">
						  <input type = "text" name = "keyword" placeholder="Search By Typing"/>
						  <input type = "submit" name = "search" style = "display:none;"/>
						</form>
					</div>
				</div>
				<div>
				<?php
					$mSql = "SELECT * FROM menulist";
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
              <form class = "addtoCart" action = "menu_db.php?action=add&id=<?php echo $row['productID'];?>" method="post" >
                <input type = "text" name = "quantity" placeholder = "Enter Amount"/>
                <input type = "submit" name = "add" value = "Add to Cart" onclick = "checkUser();"/>
              </form>
            </div>
          </div>
          <?php
        }
				?>

				</div>
				
			</body>
