<?
	require_once('template/headerTemplate.php');
	require_once('template/databaseConnection.php');
	//prepare the array for chart
	
	//get value for total sales in satria
	$address = 'satria';
	$sql="SELECT COUNT(archivedOID) FROM archivedOrder WHERE address LIKE '%$address%'";
	$result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_assoc($result);
	$satria = $row['COUNT(archivedOID)'];
	
	//get value for total sales in lestari
	$address = 'lestari';
	$sql="SELECT COUNT(archivedOID) FROM archivedOrder WHERE address LIKE '%$address%'";
	$result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_assoc($result);
	$lestari = $row['COUNT(archivedOID)'];
	
	$address = "tuah";
	$sql="SELECT COUNT(archivedOID) FROM archivedOrder WHERE address LIKE '%$address%'";
	$result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_assoc($result);
	$tuah = $row['COUNT(archivedOID)'];
	
	$address = "jebat";
	$sql="SELECT COUNT(archivedOID) FROM archivedOrder WHERE address LIKE '%$address%'";
	$result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_assoc($result);
	$jebat = $row['COUNT(archivedOID)'];
	
	$address = "kasturi";
	$sql="SELECT COUNT(archivedOID) FROM archivedOrder WHERE address LIKE '%$address%'";
	$result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_assoc($result);
	$kasturi = $row['COUNT(archivedOID)'];
	
	$address = "lekir";
	$sql="SELECT COUNT(archivedOID) FROM archivedOrder WHERE address LIKE '%$address%'";
	$result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_assoc($result);
	$lekir = $row['COUNT(archivedOID)'];
	
	$address = "lekiu";
	$sql="SELECT COUNT(archivedOID) FROM archivedOrder WHERE address LIKE '%$address%'";
	$result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_assoc($result);
	$lekiu = $row['COUNT(archivedOID)'];
	
	$address = "A";
	$sql="SELECT COUNT(archivedOID) FROM archivedOrder WHERE address LIKE '%$address%'";
	$result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_assoc($result);
	$blockA = $row['COUNT(archivedOID)'];
	
	$address = "B";
	$sql="SELECT COUNT(archivedOID) FROM archivedOrder WHERE address LIKE '%$address%'";
	$result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_assoc($result);
	$blockB = $row['COUNT(archivedOID)'];
	
?>
<body onload = "checkLogin()">
	<div class = "chartButtonPanel">
		<input type = "button" class = "chartButton" value = "Hostel View" onclick = "changeChart('hostel')"/>
		<input type = "button" class = "chartButton" value = "Block View(Satria)" onclick = "changeChart('satria')"/>
		<input type = "button" class = "chartButton" value = "Block View(Lestari)" onclick = "changeChart('lestari')"/>
	</div>
  <div class = "chart1Wrap" id="chart_div"></div>
  <div class = "chart2Wrap" id="chart_div2"></div>
  <div class = "chart3Wrap" id="chart_div3"></div>
</body>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart1);
			google.charts.setOnLoadCallback(drawChart2);
			google.charts.setOnLoadCallback(drawChart3);
      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart1() { // total sales comparison between hostel
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Hostel');
        data.addColumn('number', 'Orders');
        data.addRows([['Satria',<?echo $satria;?>],['Lestari',<?echo $lestari;?>]]);
        var options = {'title':'Total sales in terms of hostel',
                       'width':700,
                       'height':800};
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
      
      function drawChart2() { //total sales comparison between block satria
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Block');
        data.addColumn('number', 'Orders');
        data.addRows([['Tuah',<?echo $tuah;?>],['Jebat',<?echo $jebat;?>],['Kasturi',<?echo $kasturi;?>],['Lekir',<?echo $lekir;?>],['Lekiu',<?echo $lekiu;?>]]);
        var options = {'title':'Total sales in terms of Blocks (Satria)',
                       'width':700,
                       'height':800};
        var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));
        chart.draw(data, options);
      }
      
      function drawChart3() { // total sales comparison between hostel
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Block');
        data.addColumn('number', 'Orders');
        data.addRows([['Block A',<?echo $blockA;?>],['Block B',<?echo $blockB;?>]]);
        var options = {'title':'Total sales in terms of Blocks (Lestari)',
                       'width':700,
                       'height':800};
        var chart = new google.visualization.PieChart(document.getElementById('chart_div3'));
        chart.draw(data, options);
      }
    </script>

