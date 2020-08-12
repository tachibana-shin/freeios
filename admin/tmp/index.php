<?php
   
   include "../../php/init_mysql.php";
   $VIEWS = [];
   $DOWNLOADS = [];
   
   $result = $sql -> query($qr = "select downloads, views, timeupload from Apps where timeupload > ".strtotime("-30days"));
   $sql -> error;
   echo $qr;
   if ( $result -> num_rows > 0 ) {
      while ( $row = $result -> fetch_array() ) {
		array_push($VIEWS, [
			"y" => $row["views"],
			"x" => $row["timeupload"]
		]);
		array_push($DOWNLOADS, [
			"y" => $row["downloads"],
			"x" => $row["timeupload"]
		]);
	  }
   }
   
   $result -> free_result();
   
   print_r($VIEWS);
   print_r($DOWNLOADS);
?>

<!doctype html>
<html>
	<head>
		<title> Page title </title>
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">

	</head>
	<body>
		<div id="chartContainer"></div>
	 	<script src="lib/canvasjs.min.js"></script>
		<script type="text/javascript">window.onload = function () {
		
		var chart = new CanvasJS.Chart("chartContainer", { 
		theme: "light2",
		animationEnabled: true,
		title:{
			text: "Daily High Temperature at Different Beaches"
		},
		axisX: {
			//valueFormatString: "DD MMM,YY"
		},
		axisY: {
			title: "Tương tác",
			includeZero: false,
				suffix: ""
			},
			legend: {
				cursor: "pointer",
				fontSize: 16,
				itemclick: toggleDataSeries
			},
			toolTip:{
				shared: true
			},
			data: [{
				type: "spline",
				name: "Xem",
				showInLegend: true,
				//visible: false,
				yValueFormatString: "#,##0 lượt",
				dataPoints: <?= json_encode($VIEWS); ?>
			}, {
				type: "spline",
				name: "Tải xuống",
				showInLegend: true,
				yValueFormatString: "#,##0 lượt",
				dataPoints: _<?= json_encode($DOWNLOADS); ?>
			}]
		})
		
		chart.render();
		
		function toggleDataSeries(e){
			if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
				e.dataSeries.visible = false;
			}
			else{
				e.dataSeries.visible = true;
			}
			chart.render();
		}
		
	}
		</script>
	</body>
</html>