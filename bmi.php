<!doctype html>

<?php

	include('functions.php');
	
	$noError=errorCheckBmiInput();
	if ($noError==true){
		//if there are no input errors then get the user input
		$minWeight=getMinWeight();
		$maxWeight=getMaxWeight();
		$minHeight=getMinHeight();
		$maxHeight=getMaxHeight();
	}
?>

<html>
<head>
<meta charset="utf-8">
<title>bmi</title>
<link href="StyleSheet.css" rel="stylesheet" type="text/css">
</head>

<body>
	<h>Hannah Marks - B810836</h>
	<h1>Task 1 - bmi.php</h1>
	<div class="table_task1" id="bmi_table">
		
		<table cellpadding="10" rules="all">
			<!-- sets the colspan and row span for the table headers and rotates the row header to make the table less bulky -->
		<tr><th></th><th align="center" colspan=<?php echo getNumberCol() ?>>Height (m)</th></tr>
		<tr><th valign="middle" rowspan=<?php echo getNumberRow() ?>><div class="rotate">Weight (kg)</div></th><th></th>
		
		<?php
			$i=$minHeight;
			
			//generates the column sub-headers from the minimum to the maximum height in increments of 5
			while ($i<=$maxHeight){
				echo "<th align=\"center\">".$i."</th>";
				$i+=5;
			}
		?>
		</tr>
		<?php
			$i=$minWeight;
			
			while($i<=$maxWeight){
				echo "<tr><th>".$i."</th>";
				$j=$minHeight;
				//generates row sub-header
				
				while ($j<=$maxHeight){
					//nested loop uses the bmiCalc function to get the table content row by row
					$bmi=bmiCalc($i, $j);
					echo "<td>".number_format($bmi, 3)."</td>";
					$j+=5;
				}
				echo "</tr>";
				$i+=5;
			}
		?>
	</table></div>
</body>
</html>

<?php
	function getMinWeight(){
		//gets the minimum weight user input
		$minWeight=(int)$_GET["min_weight"];
		return $minWeight;
	}

	function getMaxWeight(){
		//gets the maximum weight user input
		$maxWeight=(int)$_GET["max_weight"];
		return $maxWeight;
	}

	function getMinHeight(){
		//gets the minimum height user input
		$minHeight=(int)$_GET["min_height"];
		return $minHeight;
	}

	function getMaxHeight(){
		//gets the maximum height user input
		$maxHeight=(int)$_GET["max_height"];
		return $maxHeight;
	}
								
	function getNumberRow(){
		//calculates the number of rows in the table by dividing the difference between the minimum and maximum weight by 5 and adding 2 for the minimum and maximum
		//will be used to set the number of rows the header will span
		$minWeight=getMinWeight();
		$maxWeight=getMaxWeight();
		$rows=2+(($maxWeight-$minWeight)/5);
		return $rows;
	}
								
	function getNumberCol(){
		//calculates the number of columns in the table by dividing the difference between the minimum and maximum height by 5 and adding 2 for the minimum and maximum
		//will be used to set the number of columns the header will span
		$minHeight=getMinHeight();
		$maxHeight=getMaxHeight();
		$columns=2+(($maxHeight-$minHeight)/5);
		return $columns;
	}
?>		