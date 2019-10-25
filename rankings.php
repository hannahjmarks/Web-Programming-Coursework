<!doctype html>

<!-- I have made the images used for the rank numbers and the borders myself and they are therefore not subject to copyright -->

<html>
<head>
<meta charset="utf-8">
<title>Rankings</title>
	<link href="StyleSheetTask4.css" rel=stylesheet type="text/css">
</head>

<body>
	
	<?php
		include 'functions.php';
		include 'database_log_in.php';
		//includes the file containing all the functions and the database connection

		//gets the user input
		$countryID1=strtoupper($_GET["country_id_1"]);
		$countryID2=strtoupper($_GET["country_id_2"]);
		$countryID3=strtoupper($_GET["country_id_3"]);
		$countryID4=strtoupper($_GET["country_id_4"]);
	
		$noError=errorCheckViewInput();
		
		//if there are no input errors then:
		if ($noError==true){
			
			//gets the rankings 2-dimensional array and the number of countries input
			$rankings=rankCountries($countryID1, $countryID2, $countryID3, $countryID4);
			$numCountry=getNumCountry();
			
			//the remaining code in this php section sets the content of the rankings array to separate variables so that they can be more easily accessed and so that the following code is as self commenting and as easy to understand as possible
			$country1=$rankings[0];
			$country2=$rankings[1];
			
			$countryID1=$country1["countryId"];
			$countryID2=$country2["countryId"];
			
			//checks how many countries have been input and sets arrays accordingly
			if($numCountry>3){
				$country3=$rankings[2];
				$countryID3=$country3["countryId"];
				
				$country4=$rankings[3];
				$countryID4=$country4["countryId"];
			}else if($numCountry>2){
				$country3=$rankings[2];
				$countryID3=$country3["countryId"];
			}
		}
			
	?>
	
	<!-- generates and displays the back button to take the user back to view.php -->
	<div class="backButton">
		<form action="view.php" method="get" id="view">
			<button class="button"><span>Back</span></button>
		</form>
	</div>
	
	<!-- generates the outer div and table for layout purposes -->
	<div class="rankOuter"><table>
		<tr><td>
			
			<!-- generates rank div using the hideRank function (declared at the bottom) to set the display css -->
			<div class="rank" style="display: <?php echo hideRank(1);?>">
				<table class="rank">
					<tr valign="top">
						<td valign="middle" align="center">
							<!-- loads the appropriate rank number image -->
							<img src="1.png" alt="1" width="80">
						</td>
						
						<td align="center" width="100%">
							<!-- uses php script to get country name -->
							<p class="countryName"><?php echo $country1["countryName"];?>
							</p>
						</td>
						
						<td align="right">
							
							<!-- loads medal table -->
							<div class="medal">
								<table class="medal" cellpadding="10" rules="rows">
									<tr align="center">
										<th>Gold</th>
										<th>Silver</th>
										<th>Bronze</th>
										<th>Total</th>
									</tr>
									<tr align="center">
										<!-- table content is loaded using the global php country arrays at the beginning of the file -->
										<th><?php echo $country1["gold"];?></th>
										<th><?php echo $country1["silver"];?></th>
										<th><?php echo $country1["bronze"];?></th>
										<th><?php echo $country1["total"];?></th>
									</tr>
								</table>
							</div>
							
							
						</td>
					</tr>
					
					<tr>
						<!-- displays the country's gdp and population -->
						<td align="right" width="100%" colspan="2">GDP: <?php echo $country1["gdp"];?></td>
						<td align="center">Population: <?php echo $country1["population"];?></td>
					</tr>
					
					<tr>
						<td>Cyclists</td>
					</tr>
					
					<tr>
						<!-- loads the table displaying the country's cyclists (if there are any) -->
						<td colspan="3" width="100%">
						<table id="cyclistTable1" class="cyclists" cellpadding="10" align="center">
						
							<tr>
								<!-- for each of the following table headers when clicked sort the table by that particular column and toggle ascending and descending order -->
								<th onclick="sortTable('cyclistTable1', 0)">Name</th>
								<th id="bmi" onclick="sortTable('cyclistTable1', 1)">BMI</th>
								<th id="dob" onclick="sortTable('cyclistTable1', 2)">DOB</th>
								<th id="gender" onclick="sortTable('cyclistTable1', 3)">Gender</th>
								<th id="event" width="100%" onclick="sortTable('cyclistTable1', 4)">Event</th>
							</tr>
								<?php
									//uses php function in functions.php to generate the table content
									getCyclists($countryID1);
								?>
						</table>
						</td>
					</tr>
				</table>
			</div>
			</td>
		</tr>
		
		
		<!-- generates rank div using the hideRank function (declared at the bottom) to set the display css -->
		<tr><td>
			<div class="rank" style="display: <?php echo hideRank(2);?>">
				<table class="rank">
					<tr valign="top">
						<td valign="middle" align="center">
							<!-- loads the appropriate rank number image -->
							<img src="2.png" alt="2" width="80">
						</td>
						
						<td align="center" width="100%">
							<!-- uses php script to get country name -->
							<p class="countryName"><?php echo $country2["countryName"];?></p>
						</td>
						
						<!-- loads medal table -->
						<td align="right">
							<div class="medal">
								
								
								<table class="medal" cellpadding="10" rules="rows">
									<tr align="center">
										<th>Gold</th>
										<th>Silver</th>
										<th>Bronze</th>
										<th>Total</th>
									</tr>
									
									<tr align="center">
										<!-- table content is loaded using the global php country arrays at the beginning of the file -->
										<th><?php echo $country2["gold"];?></th>
										<th><?php echo $country2["silver"];?></th>
										<th><?php echo $country2["bronze"];?></th>
										<th><?php echo $country2["total"];?></th>
									</tr>
								</table>
								
				
							</div>
						</td>
					</tr>
					
	
					<tr>
						<!-- displays the country's gdp and population -->
						<td align="right" width="100%" colspan="2">GDP: <?php echo $country2["gdp"];?></td>
						<td align="center">Population: <?php echo $country2["population"];?></td>
					</tr>
					
					<tr>
						<td>Cyclists</td>
					</tr>
					
					<tr>
						<!-- loads the table displaying the country's cyclists (if there are any) -->
						<td colspan="3" width="100%">
					
						<table id="cyclistTable2" class="cyclists" cellpadding="10" align="center">
						
							<tr>
								<!-- for each of the following table headers when clicked sort the table by that particular column and toggle ascending and descending order -->
								<th id="name" onclick="sortTable('cyclistTable2', 0)">Name</th>
								<th id="bmi" onclick="sortTable('cyclistTable2', 1)">BMI</th>
								<th id="dob" onclick="sortTable('cyclistTable2', 2)">DOB</th>
								<th id="gender" onclick="sortTable('cyclistTable2', 3)">Gender</th>
								<th id="event" width="100%" onclick="sortTable('cyclistTable2', 4)">Event</th>
							</tr>
								<?php
									//uses php function in functions.php to generate the table content
									getCyclists($countryID2);
								?>
						</table>
						</td>
					</tr>
				</table>
			</div>
			</td>
		</tr>
		
		<!-- generates rank div using the hideRank function (declared at the bottom) to set the display css -->
		<tr><td>
			<div class="rank" style="display: <?php echo hideRank(3);?>">
				<table class="rank">
					<tr valign="top">
						<td valign="middle" align="center">
							<!-- loads the appropriate rank number image -->
							<img src="3.png" alt="3" width="80">
						</td>
						
						<td align="center" width="100%">
							<!-- uses php script to get country name -->
							<p class="countryName"><?php echo $country3["countryName"];?></p>
						</td>
						
						<!-- loads medal table -->
						<td align="right">
							<div class="medal">
								
								
								<table class="medal" cellpadding="10" rules="rows">
									<tr align="center">
										<th>Gold</th>
										<th>Silver</th>
										<th>Bronze</th>
										<th>Total</th>
									</tr>
									
									<tr align="center">
										<!-- table content is loaded using the global php country arrays at the beginning of the file -->
										<th><?php echo $country3["gold"];?></th>
										<th><?php echo $country3["silver"];?></th>
										<th><?php echo $country3["bronze"];?></th>
										<th><?php echo $country3["total"];?></th>
									</tr>
								</table>
								
								
							</div>
						</td>
					</tr>
					
					
					<tr>
						<!-- displays the country's gdp and population -->
						<td align="right" width="100%" colspan="2">GDP: <?php echo $country3["gdp"];?></td>
						<td align="center">Population: <?php echo $country3["population"];?></td>
					</tr>
					
					<tr>
						<td>Cyclists</td>
					</tr>
					
					<tr>
						<!-- loads the table displaying the country's cyclists (if there are any) -->
						<td colspan="3" width="100%">
					
						<table id="cyclistTable3" class="cyclists" cellpadding="10" align="center">
						
							<tr>
								<!-- for each of the following table headers when clicked sort the table by that particular column and toggle ascending and descending order -->
								<th id="name" onclick="sortTable('cyclistTable3', 0)">Name</th>
								<th id="bmi" onclick="sortTable('cyclistTable3', 1)">BMI</th>
								<th id="dob" onclick="sortTable('cyclistTable3', 2)">DOB</th>
								<th id="gender" onclick="sortTable('cyclistTable3', 3)">Gender</th>
								<th id="event" width="100%" onclick="sortTable('cyclistTable3', 4)">Event</th></tr>
								<?php
									//uses php function in functions.php to generate the table content
									getCyclists($countryID3);
								?>
						</table>
						</td>
					</tr>
				</table>
			</div>
			</td>
		</tr>
		
		
		<!-- generates rank div using the hideRank function (declared at the bottom) to set the display css -->
		<tr><td>
			<div class="rank" style="display: <?php echo hideRank(4);?>">
				<table class="rank">
					<tr valign="top">
						<td valign="middle" align="center">
							<!-- loads the appropriate rank number image -->
							<img src="4.png" alt="4" width="80">
						</td>
						
						<td align="center" width="100%">
							<!-- uses php script to get country name -->
							<p class="countryName"><?php echo $country4["countryName"];?></p>
						</td>
						
						<!-- loads medal table -->
						<td align="right">
							<div class="medal">
								
								
								<table class="medal" cellpadding="10" rules="rows">
									<tr align="center">
										<th>Gold</th>
										<th>Silver</th>
										<th>Bronze</th>
										<th>Total</th>
									</tr>
									
									<tr align="center">
										<!-- table content is loaded using the global php country arrays at the beginning of the file -->
										<th><?php echo $country4["gold"];?></th>
										<th><?php echo $country4["silver"];?></th>
										<th><?php echo $country4["bronze"];?></th>
										<th><?php echo $country4["total"];?></th>
									</tr>
								</table>
								
								
							</div>
						</td>
					</tr>
					
					
					<tr>
						<!-- displays the country's gdp and population -->
						<td align="right" width="100%" colspan="2">GDP: <?php echo $country4["gdp"];?></td>
						<td align="center">Population: <?php echo $country4["population"];?></td>
					</tr>
					
					<tr>
						<td>Cyclists</td>
					</tr>
					
					<tr>
						<!-- loads the table displaying the country's cyclists (if there are any) -->
						<td colspan="3" width="100%">
					
						<table id="cyclistTable4" class="cyclists" cellpadding="10" align="center">
						
							<tr>
								<!-- for each of the following table headers when clicked sort the table by that particular column and toggle ascending and descending order -->
								<th id="name" onclick="sortTable('cyclistTable4', 0)">Name</th>
								<th id="bmi" onclick="sortTable('cyclistTable4', 1)">BMI</th>
								<th id="dob" onclick="sortTable('cyclistTable4', 2)">DOB</th>
								<th id="gender" onclick="sortTable('cyclistTable4', 3)">Gender</th>
								<th id="event" width="100%" onclick="sortTable('cyclistTable4', 4)">Event</th>
							</tr>
								<?php
									//uses php function in functions.php to generate the table content
									getCyclists($countryID4);
								?>
						</table>
						</td>
					</tr>
				</table>
			</div>
			</td>
		</tr>
	</table>
</div>
		
	<script>

		function sortTable(tableID, n){
			//function used to sort the cyclist tables by column in ascending and descending (toggle) order
			//takes the table id and the column index as inputs
			
			var table, rows, switching, i, a, b, shouldSwap, order, swapCount=0;
			//declare all variables
			
			table=document.getElementById(tableID);
			//gets table by id
			
			switching=true;
			order="ASC"
			//order is initially set to ascending
			
			//while there are still rows switching places:
			while (switching){
				switching=false;
				rows=table.rows;
				//gets the table rows as an array
				
				//starts loop at index 1 so that the table headers are not affected
				for (i=1;i<rows.length-1;i++){
					shouldSwap=false;
					a=rows[i].getElementsByTagName("td")[n];
					b=rows[i+1].getElementsByTagName("td")[n];
					//gets the value in column n for the current and next table row
					
					
					
					//the following if statements dictate how the table is to be sorted i.e.
					//n=0 -> by name
					//n=1 -> by bmi
					//n=2 -> by date of birth
					//n=3 -> by gender
					//n=4 -> by event
					
					//the nested if statements decide if the rows need to be swapped based on the sort order (ascending or descending)
					if(n==0){
					   if (order=="ASC"){
							if(a.innerHTML.toLowerCase()>b.innerHTML.toLowerCase()){
							   shouldSwap=true;
								break;
							}
						}else if(order=="DESC"){
							 if(a.innerHTML.toLowerCase()<b.innerHTML.toLowerCase()){
							   shouldSwap=true;
								 break;
							}
						}
					}else if(n==1){
						if (order=="ASC"){
							if(parseInt(a.innerHTML)>parseInt(a.innerHTML)){
							   shouldSwap=true;
								break;
							}
						}else if(order=="DESC"){
							 if(parseInt(a.innerHTML)<parseInt(b.innerHTML)){
							   shouldSwap=true;
								 break;
							}
						}	 
					}else if(n==2){
						if (order=="ASC"){
							//converts to dates to compare
							if(Date.parse(a.innerHTML)>Date.parse(b.innerHTML)){
							   shouldSwap=true;
								break;
							}
						}else if(order=="DESC"){
							 //converts to dates to compare
							 if(Date.parse(a.innerHTML)<Date.parse(b.innerHTML)){
							   shouldSwap=true;
								 break;
							}
						}	 
					}else if(n==3){
						if (order=="ASC"){
							if(a.innerHTML>b.innerHTML){
							   shouldSwap=true;
								break;
							}
						}else if(order=="DESC"){
							 if(a.innerHTML<b.innerHTML){
							   shouldSwap=true;
								break;
							}
						}	 
					}else if(n==4){
						if (order=="ASC"){
							if(a.innerHTML.toLowerCase()>b.innerHTML.toLowerCase()){
							   shouldSwap=true;
								break;
							}
						}else if(order=="DESC"){
							 if(a.innerHTML.toLowerCase()<b.innerHTML.toLowerCase()){
							   shouldSwap=true;
								 break;
							}
						}	 
					}
				}
				//if shouldSwap is true then the rows are swapped and the swapCount is increased by 1
				if (shouldSwap){
					rows[i].parentNode.insertBefore(rows[i+1], rows[i]);
					switching=true;
					swapCount++;
				}else{
					//if shouldSwap is false and the swapCount is 0 then the order is toggled switching is set to true so that the while loop won't break
					if(swapCount==0 && order=="ASC"){
					   order="DESC";
						switching=true;
					}
				}
			}
		}
	
	</script>
		
		
	<?php		
		function hideRank($rank){
		//function used to determine whether or not to display a particular rank div depending on the number of countries input
			
			//gets number of input countries
			$numCountries=getNumCountry();
			
			//if the rank of the div is greater than the number of countries then the display is set to "none", otherwise it is set to "block"
			if($rank>$numCountries){
				return "none;";
			}else{
				return "block;";
			}
		}
	?>
</body>
</html>