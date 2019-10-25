<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Task 3 - details.php</title>
<link href="StyleSheet.css" rel="stylesheet" type="text/css">
</head>

<body>
	<h>Hannah Marks - B810836</h>
	<h1>Task 3 - details.php</h1>
	<div class="table_task1">
		<?php
		queryDateOfBirth();
		//calls function to output the json data structure
		?>
	</div>
</body>
</html>

<?php

function queryDateOfBirth(){
	
	include 'functions.php';
	include 'database_log_in.php';
	
	$noError=errorCheckDetails();
	//if there are no input errors then:
	if ($noError==true){
		$userDate1=$_GET["date_1"];
		$userDate2=$_GET["date_2"];
		//gets user input
		
		list($d1,$m1,$y1)=explode('/', $userDate1);
		list($d2,$m2,$y2)=explode('/', $userDate2);
		//uses explode function to get the day, month and year of the user input so that the format can be changed for the database query
		
		$queryDate1=$y1."-".$m1."-".$d1;
		$queryDate2=$y2."-".$m2."-".$d2;
		
		//querys the database for all the cyclists born between the user input dates inclusive
		$sqlQuery="SELECT Cyclist.name, Country.country_name, Country.gdp, Country.population FROM Cyclist INNER JOIN Country ON Cyclist.ISO_id=Country.ISO_id WHERE dob BETWEEN '".$queryDate1."' AND '".$queryDate2."'";
		
		$results =& $db->query($sqlQuery);
		
		if (PEAR::isError($results)){
			die($results->getMessage());
			//generates a message if the database connection fails
		}
		else{
			//uses json_encode function to convert the query results to a json data structure for output
			echo json_encode($results->fetchAll());
		}
		
	}
}

?>
