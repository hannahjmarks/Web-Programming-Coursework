<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>athletes</title>
<link href="StyleSheet.css" rel="stylesheet" type="text/css">
</head>
<body>
	<h>Hannah Marks - B810836</h>
	<h1>Task 2 - athletes.php</h1>
	<div class="table_task1">
	
	<table cellpadding="10" rules="all">
		<tr><th colspan="3">Cyclists</th></tr><tr><th>Name</th><th>Gender</th><th>BMI</th></tr>
		<!-- sets table headers and title -->
		<?php
		
		include 'functions.php';
		//includes error checking function for input and the bmi calculation for later use.
		
		$noError=errorCheckAthletes();
		//if there are no input errors then:
		if ($noError==true){
			$countryID=strtoupper($_GET["country_id"]);
			$partName=$_GET["part_name"];
			
			queryCyclists($countryID, $partName);
			//calls function to get table content
		}
		
		?>
	</table>
	</div>
</body>
</html>


<?php

	function queryCyclists($countryID, $partName){
		//function generates table content from database
		
		include 'database_log_in.php';
		//include external php file to connect to the database

		//query searches the Cyclist table and retrieves the results whose name field contains the part name the user has submitted
		$sql_query="SELECT name, gender, weight, height FROM Cyclist WHERE name LIKE '%$partName%' AND ISO_id = '$countryID'";
		$results =& $db->query($sql_query);
		if (PEAR::isError($results)){
			die($results->getMessage());
		}
		else{
			while ($row=$results->fetchRow()){
				//loops through the results, calculates the bmi for each row and outputs the table content
				$bmi=bmiCalc($row[2], $row[3]);
				echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".number_format($bmi, 3)."</td></tr>";
			}
		}
		
	}

?>