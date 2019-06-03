<?
	include_once("template/headerTemplate.php");
	include_once("template/databaseConnection.php");
	
	if(isset($_GET['detail'])){
			if($_GET['detail']=='false'){
				if(isset($_POST['satria'])){
				//clicked on satria	
				?>
					<body onload = "checkLogin();">
					<div class = "pageWrap">
					<div class = "formPanel">
						<form method = "post" action = "getAddress.php?detail=true&zone=satria">
							<p>Block: </p>
							<select name = "category1">
								<option value = "tuah">tuah</option>
								<option value = "jebat">jebat</option>
								<option value = "kasturi">kasturi</option>
								<option value = "lekir">lekir</option>
								<option value = "lekiu">lekiu</option>
							</select>
							<p>Floor: </p>
							<select name = "category2">
								<?
									for($i=1;$i<10;$i++){
										?>
										<option value = <?echo $i;?>><?echo $i;?></option>
										<?
									}
								?>
							</select>
							<p>Unit: </p>
							<select name = "category3">
								<?
									for($i=1;$i<13;$i++){
										?>
										<option value = <?echo $i;?>><?echo $i;?></option>
										<?
									}
								?>
							</select>
							<p>Room: </p>
								<select name = "category4">
									<option value = "a">a</option>
									<option value = "b">b</option>
									<option value = "c">c</option>
									<option value = "d">d</option>
									<option value = "e">e</option>
								</select>
							<input type = "submit" value = "submit" name = "detail"/>
						</form>
						</div></div>
					</body>
				<?
			}elseif(isset($_POST['lestari'])){
				//clicked on lestari
				?>
					<body onload = "checkLogin();">
						<div class = "pageWrap">
							<div class = "formPanel">
							<form method = "post" action = "getAddress.php?detail=true&zone=lestari">
							<p>Block</p>
							<select name = "category1">
								<option value = "a">a</option>
								<option value = "b">b</option>
							</select>
							<p>Section</p>
							<select name = "category2">
								<option value = "1">1</option>
								<option value = "2">2</option>
								<option value = "3">2</option>
								<option value = "4">4</option>
							</select>
							<p>Floor: </p>
							<select name = "category3">
								<option value = "G">G</option>
								<option value = "1">1</option>
								<option value = "2">2</option>
								<option value = "3">3</option>
							</select>
							<p>Room: </p>
							<select name = "category4">
								<?
									for($i=1;$i<21;$i++){
										?>
										<option value = <?echo $i;?>><?echo $i;?></option>
										<?
									}
								?>
							</select>
						<input type = "submit" value = "submit" name = "detail"/>
							
						</form>
						</div></div>
					</body>
				<?
			}else{
				//error handling
			}
		}elseif($_GET['detail']=='true'){
			//done with data collecting
			if(isset($_GET['zone'])){
				if($_GET['zone']=='satria'){
					if(isset($_POST['detail'])){
						$array = array('satria',$_POST['category1'],$_POST['category2'],$_POST['category3'],$_POST['category4']);
						$address = implode('-',$array);
						$url = "cart.php?action=order&address=$address";
						echo "<script type = 'text/javascript'>window.location = '$url'</script>";
					}
				}elseif($_GET['zone']=='lestari'){
					$array = array('lestari',$_POST['category1'],$_POST['category2'],$_POST['category3'],$_POST['category4']);
					$address = implode('-',$array);
					$url = "cart.php?action=order&address=$address";
					echo "<script type = 'text/javascript'>window.location = '$url'</script>";
				}
			}
		}
	}else{
		?>
			<body onload = "checkLogin();">
				<div class = "pageWrap">
					<div class = "formPanel">
				<form method = "post" action = "getAddress.php?detail=false">
					<h2>Where do you live:</p>
					<input type = "submit" value = "SATRIA" name = "satria"/>
					<input type = "submit" value = "LESTARI" name = "lestari"/>
				</form>
				</div></div>
			</body>
		<?
	}
	
	

?>


