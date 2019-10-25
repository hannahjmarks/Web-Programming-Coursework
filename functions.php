<?php
	function bmiCalc($weight, $height){
		//function used to calculate the bmi for an individual 
		$result=0;
		if ($height!=0){
			//used in case there is dummy data in the database
			$height=$height/100;
			$result=$weight/($height*$height);
		}
		return $result;
		//returns the calculated bmi
	}



	function getNumCountry(){
		//function gets the number of country ids the user has input for use when loading the rankings.php file and error checking the input
		
		//gets user input
		$country1=strtoupper($_GET["country_id_1"]);
		$country2=strtoupper($_GET["country_id_2"]);
		$country3=strtoupper($_GET["country_id_3"]);
		$country4=strtoupper($_GET["country_id_4"]);
		
		$numCountry=0;
		//initial value is 0, each input is checked to see whether it is empty or has a null value and the sum is calculated accordingly
		if($country1!=null||!empty($country1)){
			$numCountry+=1;
		}
		if($country2!=null||!empty($country2)){
			$numCountry+=1;
		}
		if($country3!=null||!empty($country3)){
			$numCountry+=1;
		}
		if($country4!=null||!empty($country4)){
			$numCountry+=1;
		}
		return $numCountry;
	}



	function getCountry($countryID){
	//function used to retrive the data for a single country from the database using the ISO id
		
		include 'database_log_in.php';
		//connect to database
		
		$sqlQuery="SELECT country_name, gold, silver, bronze, total, gdp, population FROM Country WHERE ISO_id='$countryID'";
		
		$results =& $db->query($sqlQuery);
		//query database
		
		if (PEAR::isError($results)){
			die($results->getMessage());
		}
		else{
			//get results as array and return
			$row=$results->fetchRow();
		}
		return $row;
	}




	function rankCountries($country1, $country2, $country3, $country4){
	//function used to rank the input countries and append all the relevant data to the array for use throughout rankings.php
		
		//gets the point totals for each country and if the input is empty sets the point total to -1000 so that they will be ranked last
		if (!empty($country1)||$country1!=null){
			$country1Points=getPointTotal($country1);
		}else{
			$country1Points=-1000;
		}
		if (!empty($country2)||$country2!=null){
			$country2Points=getPointTotal($country2);
		}else{
			$country2Points=-1000;
		}
		if (!empty($country3)||$country3!=null){
			$country3Points=getPointTotal($country3);
		}else{
			$country3Points=-1000;
		}
		if (!empty($country4)||$country4!=null){
			$country4Points=getPointTotal($country4);
		}else{
			$country4Points=-1000;
		}
		
		//sorts the countries by points in descending order
		$pointRank=array($country1=>$country1Points, $country2=>$country2Points, $country3=>$country3Points, $country4=>$country4Points);
		arsort($pointRank);
		
		$rankings=array();
		$i=1;
		
		//for each item in the points array the country is appended to the 2 dimensional rankings array with all the relevant data
		foreach($pointRank as $x=>$x_points){
			if(!empty($x)||$x!=null){
				$row=getCountry($x);
				
				//associative array for each country
				$country = array(
					"countryId"=>$x,
					"countryName"=>$row[0],
					"gold"=>$row[1],
					"silver"=>$row[2],
					"bronze"=>$row[3],
					"total"=>$row[4],
					"gdp"=>$row[5],
					"population"=>$row[6],
					"rank"=>$i
				);
				//adds country to the array
				array_push($rankings, $country);
				$i=$i+1;
			}
			
		}
		return $rankings;
	}




	function getPointTotal($countryID){
		//calculates the point total for a single country (used when ranking countries)
		
		$total=0;//initial value set to 0
		$row=getCountry($countryID);
		
		$totalMedals=$row[4];
		
		if ($totalMedals==0){
		//if the country has won no medals at all then the receive a 50 point penalty
			$total=$total-50;
		}else{
			$total=$total+((int)$row[1]*5);
			//5 points per gold medal
		
			$total=$total+((int)$row[2]*3);
			//3 points per silver medal
			
			$total=$total+(int)$row[3];
			//1 point per bronze medal
		}
		
		//takes the gdp and population into account as better funded and more populated countries have an advantage
		$total=$total-2*(log((int)$row[5], M_E));
		//lose 2ln(gdp) points
		$total=$total-2*(log((int)$row[6], M_E));
		//lose 2ln(population) points
		
		return $total;
	}




	function getCyclists($countryID){
	//gets all the cyclists and their relevant data from the database to display in the correct table in rankings.php
		
		include 'database_log_in.php';
		//connect to database
		
		$sqlQuery="SELECT name, weight, height, dob, gender, Event FROM Cyclist WHERE ISO_id='$countryID' ORDER BY name ASC";
		
		$results =& $db->query($sqlQuery);
		//query database for all cyclists from the country with the ISO id $countryID
		
		if (PEAR::isError($results)){
			die($results->getMessage());
		}
		else{
			$existCyclists=hasCyclists($countryID);
			
			//if the country has any cyclists then:
			if($existCyclists!=0){
				while($row=$results->fetchRow()){
					
					//echos the results complete with html tags if there are any results
					echo'<tr><td>'.$row[0].'</td>
						<td>'.number_format(bmiCalc($row[1], $row[2]), 2).'</td>
						<td>'.$row[3].'</td>
						<td>'.$row[4].'</td>
						<td>'.$row[5].'</td>
						</tr>' ;
				}
			}else{
					//if there are no results then the table will simply consist of the term "No Cyclists"
					echo '<tr><td colspan="5">No Cyclists</td></tr>';
				}
		}
	}




	function checkCountryIdExists($countryID){
	//function that checks whether the user input country id actually exists
		
		include 'database_log_in.php';
		//connect to database
		
		$exists=1;
		//sets the initial value to 1 (true)
		
		$sqlQuery="SELECT ISO_id FROM Country WHERE ISO_id='$countryID'";
		//query database for ISO id matching $countryID
		
		$results =& $db->query($sqlQuery);
		
		if (PEAR::isError($results)){
			die($results->getMessage());
		}
		else{
			//if there are no results then the row will be empty
			$row=$results->fetchRow();
			if (empty($row)){
				
				//this therefore means that there exist no country with the ISO id matching the user input so $exists is set to 0 (false)
				$exists=0;
				
				//alert message is shown to the user telling them which input id is incorrect
				echo '<script language="javascript">';
				echo 'alert("The Country ID '.$countryID.' does not Exist\nPlease Try Again")';
				echo '</script>';
			}
		}
		return $exists;
	}




	function hasCyclists($countryID){
	//accesses the database to find out if a country has any cyclists
		
		include 'database_log_in.php';
		//connect to database
		
		$exists=1;
		//initially set to 1 (true)
		
		$sqlQuery="SELECT name FROM Cyclist WHERE ISO_id='$countryID'";
		//query database for all cyclists from the input country
		
		$results =& $db->query($sqlQuery);
		
		if (PEAR::isError($results)){
			die($results->getMessage());
		}
		else{
			
			//if the row is empty then this country does not have any cyclists and $exists is therefore set to 0 (false)
			$row=$results->fetchRow();
			if (empty($row)){
				$exists=0;
			}
		}
		return $exists;
	}




	function errorCheckBmiInput(){
	//error checks the user input for task 1
		
		$noError=true;
		//assumed initially that there are no input errors
		
		//get user input
		$minWeight=$_GET["min_weight"];
		$maxWeight=$_GET["max_weight"];
		$minHeight=$_GET["min_height"];
		$maxHeight=$_GET["max_height"];
		
		//if any of the inputs are empty then a message is displayed to the user
		if (empty($minWeight)||empty($maxWeight)||empty($minHeight)||empty($maxHeight)){
			echo '<script language="javascript">';
			echo 'alert("Please Enter all Fields")';
			echo '</script>';
			$noError=false;
		}
		//if any of the inputs are not a number then a message is displayed to the user
		else if(!is_numeric($minWeight)||!is_numeric($maxWeight)||!is_numeric($minHeight)||!is_numeric($maxHeight)){
			echo '<script language="javascript">';
			echo 'alert("The input should be integers only")';
			echo '</script>';
			$noError=false;
		}
		//if the minimum weight is greater than the maximum weight then a message is displayed to the user
		else if($minWeight>$maxWeight){
			echo '<script language="javascript">';
			echo 'alert("The minimum weight should be smaller than the maximum weight")';
			echo '</script>';
			$noError=false;
		}
		//if the minimum height is greater than the maximum height then a message is displayed to the user
		else if($minHeight>$maxHeight){
			echo '<script language="javascript">';
			echo 'alert("The minimum height should be smaller than the maximum height")';
			echo '</script>';
			$noError=false;
		}
		
		return $noError;
	}





	function errorCheckAthletes(){
	//checks the user input for task 2
		
		$noError=true;
		//initially assumes that there are no input errors
		
		//gets user input
		$countryID=$_GET["country_id"];
		$partName=$_GET["part_name"];
		
		$countryExists=checkCountryIdExists($countryID);
		
		//if the country id input is empty then a message is displayed to the user
		//also if the partial name input is empty then all the cyclists from that country will be displayed
		if (empty($countryID)){
			echo '<script language="javascript">';
			echo 'alert("Please Enter a country id")';
			echo '</script>';
			$noError=false;
		}
		//if the country id does not exist in the database then a message is displayed to the user
		//also this indirectly checks the format of the input as if the format is incorrect then there will not be a matching entry in the database
		else if($countryExists==0){
			echo '<script language="javascript">';
			echo 'alert("This is an invalid Country id\nPlease Try Again")';
			echo '</script>';
			$noError=false;
		}
		//if the inputs for either the country id or the partial name contain numbers then a message is displayed to the user
		else if(ctype_alpha($countryID)==false||ctype_alpha($partName)==false){
			echo '<script language="javascript">';
			echo 'alert("The Country ID and partial Name should contain only letters")';
			echo '</script>';
			$noError=false;
		}
		return $noError;
	}




	function errorCheckDetails(){
	//checks the user input for task 3
		
		$noError=true;
		//initially assumes that there are no input errors
		
		//gets user input
		$userDate1=$_GET["date_1"];
		$userDate2=$_GET["date_2"];
		
		//uses explode function to get the day, month and year for both inputs as separate variables
		list($d1,$m1,$y1)=explode('/',$userDate1);
		list($d2,$m2,$y2)=explode('/',$userDate2);
		
		//if either of the inputs are empty then $noError is set to false
		if (empty($userDate1)||empty($userDate2)){
			$noError=false;
		}
		//if the length of either input is incorrect then the date format must also be incorrect so then $noError is set to false
		else if(strlen($userDate1)!=10||strlen($userDate2)!=10){
			$noError=false;
		}
		//if any of the date aspects are not numbers then $noError is set to false
		else if(!is_numeric($d1)||!is_numeric($d2)||!is_numeric($m1)||!is_numeric($m2)||!is_numeric($y1)||!is_numeric($y2)){
			$noError=false;
		}
		else{
			//makes sure that the variables are integers
			$d1=(int)$d1;
			$m1=(int)$m1;
			$y1=(int)$y1;
			$d2=(int)$d2;
			$m2=(int)$m2;
			$y2=(int)$y2;
			
			//the following nested if statements are used to "sanity" check the input dates
			//this should prevent the user from being able to input fake dates such as 30/feb or 32/jan etc
			//triggering any of these if statements will set $noError to false
			
			if($d1>31||$d2>31||$m1>12||$m2>12||$y1>9999||$y2>9999){
				$noError=false;
			}
			else if($d1<1||$d2<1||$m1<1||$m2<1||$y1<1||$y2<1){
				$noError=false;
			}
			else if($d1>28 && $m1==2 && $y1%4!=0){
				$noError=false;
			}
			else if($d2>28 && $m2==2 && $y2%4!=0){
				$noError=false;
			}
			else if($d1>29 && $m1==2){
				$noError=false;
			}
			else if($d2>28 && $m2==2){
				$noError=false;
			}
			else if($d1>30||$d2>30){
				if($m1==1||$m1==3||$m1==5||$m1==7||$m1==8||$m1==10||$m1==12){
					$noError=false;
				}
				else if($m2==1||$m2==3||$m2==5||$m2==7||$m2==8||$m2==10||$m2==12){
					$noError=false;
				}
			}
		}
		
		//if there is an input error then a message is displayed to the user
		if($noError==false){
			echo '<script language="javascript">';
			echo 'alert("Please input 2 valid dates")';
			echo '</script>';
		}
		
		return $noError;
	}





	function errorCheckViewInput(){
	//error checks the user input for task 4
		
		//gets user input
		$country1=strtoupper($_GET["country_id_1"]);
		$country2=strtoupper($_GET["country_id_2"]);
		$country3=strtoupper($_GET["country_id_3"]);
		$country4=strtoupper($_GET["country_id_4"]);
		
		$noError=true;
		//initially assumes that there are no input errors
		
		//gets the number of countries input
		$numCountry=getNumCountry();
		
		//if there are less than 2 countries input then $noError is set to false
		if ($numCountry>=2){
			
			//if there is a repeated country id then $noError is set to false
			$repeat=noRepeats($country1, $country2, $country3, $country4);
			if($repeat==false){
				
				//the following for if statements (and their nested statements) check if the input country id actually exist in the database
				//if any of them do not then $noError is set to false
				if(!empty($country1)){
					$country1Exist=checkCountryIdExists($country1);
					if($country1Exist==0){
						$noError=false;
					}
				}
				if(!empty($country2)){
					$country2Exist=checkCountryIdExists($country2);
					if($country2Exist==0){
						$noError=false;
					}
				}
				if(!empty($country3)){
					$country3Exist=checkCountryIdExists($country3);
					if($country3Exist==0){
						$noError=false;
					}
				}
				if(!empty($country4)){
					$country4Exist=checkCountryIdExists($country4);
					if($country4Exist==0){
						$noError=false;
					}
				}
			}else{
				$noError=false;
			}
		}else{
			$noError=false;
			
			//displays a message to the user if there are less than 2 input ids
			//(all other if statements contain functions that display their own messages so there is no need to add any in here)
			echo '<script language="javascript">';
			echo 'alert("Please enter at least 2 Country Id\'s")';
			echo '</script>';
		}
		return $noError;
	}






	function noRepeats($country1, $country2, $country3, $country4){
	//checks to see if there are any repeated country ids in the input for view.php
		
		$repeat=false;
		//initially assumes that there are no repeated ids
		
		//the country id variables are using the global variables declared at the beggining of this file
		//the country id variables are all set to upper case to prevent any missed errors/repeated ids
		
		//the following 4 if statements compare each of the non-empty inputs to the others to check for repeats
		if (!empty($country1)){
			if ($country1==$country2||$country1==$country3||$country1==$country4){
				$repeat=true;
			}
		}
		if (!empty($country2)){
			if ($country1==$country2||$country2==$country3||$country2==$country4){
				$repeat=true;
			}
		}
		if (!empty($country3)){
			if ($country3==$country2||$country1==$country3||$country3==$country4){
				$repeat=true;
			}
		}
		if (!empty($country4)){
			if ($country4==$country2||$country4==$country3||$country1==$country4){
				$repeat=true;
			}
		}
		
		//if there is a repeated id then a message is displayed to the user
		if($repeat==true){
			echo '<script language="javascript">';
			echo 'alert("There is at least 1 repeated country id\nPlease Try Again")';
			echo '</script>';
		}
		return $repeat;
	}
?>