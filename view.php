<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="robots" content="noindex, nofollow" />
<title>View Task</title>
	<link href="StyleSheetTask4.css" rel=stylesheet type="text/css">
	

	<script>
		function getSuggest(partID, suggestID){
		//function used to call the suggestion.php file and set the output to the table cell on key up 
			
			if(partID.length==0){
				//if the input field contains no value then clear the suggestion
				document.getElementById(suggestID).innerHTML ='';
				return;
			}else{
				var xml=new XMLHttpRequest();
				xml.onreadystatechange=function(){
					if(this.readyState==4 && this.status==200){
					//if the element is ready and there are no load errors
						
					   document.getElementById(suggestID).innerHTML=this.responseText;
						//sets the text of the table cell to the response text of suggestion.php
					}
				};
				xml.open("GET", "suggestion.php?q="+partID, true);
				xml.send();
				//passes the input data to suggestion.php via the GET method
			}
		}
	</script>
	
	
</head>

<body>
	<h>Hannah Marks - B810836</h>
	<h1>Task 4 - view.php</h1>
	<div class="form">
		
		<!-- generates the input form using the get method to pass the input data to rankings.php on submit, table is used for layout -->
		<form class="form" action="rankings.php" method="get" id="rankings">
			<table><tr><td colspan="3">
			<p class="form" align="center">Enter up to 4 Country ID codes to compare</p></td></tr>
				
			<tr><td align="right">
				<label for="country_id">1st:</label></td>
				
				<td>
				<!-- generates input field which clears on focus and calls the getSuggest function on key up -->
				<input name="country_id_1" type="text" id="country_id_1" value="e.g. GBR" onfocus="this.value=''" onKeyUp="getSuggest(this.value, 'suggest_1')" style="width: 200px; height: 30px; font-size: 16pt; font-family: 'Gill Sans', 'Gill Sans MT', 'Myriad Pro', 'DejaVu Sans Condensed', Helvetica, Arial, 'sans-serif'"/></td>
				
				<!-- table cell used to display the suggested country id based on user input -->
				<td width="300px">
				Suggestion: <span id="suggest_1"></span></td></tr>

			<tr><td align="right">
				<label for="country_id_2">2nd:</label></td>
				
				<td>
				<!-- generates input field which clears on focus and calls the getSuggest function on key up -->
				<input name="country_id_2" type="text" id="country_id_2" onfocus="this.value=''" onKeyUp="getSuggest(this.value, 'suggest_2')" style="width: 200px; height: 30px; font-size: 16pt; font-family: 'Gill Sans', 'Gill Sans MT', 'Myriad Pro', 'DejaVu Sans Condensed', Helvetica, Arial, 'sans-serif'"/></td>
				
				<!-- table cell used to display the suggested country id based on user input -->
				<td width="300px">
				Suggestion: <span id="suggest_2"></span></td></tr>
					
			<tr><td align="right">
				<label for="country_id_3">3rd:</label></td>
				
				<td>
				<!-- generates input field which clears on focus and calls the getSuggest function on key up -->
				<input name="country_id_3" type="text" id="country_id_3" onfocus="this.value=''" onKeyUp="getSuggest(this.value, 'suggest_3')" style="width: 200px; height: 30px; font-size: 16pt; font-family: 'Gill Sans', 'Gill Sans MT', 'Myriad Pro', 'DejaVu Sans Condensed', Helvetica, Arial, 'sans-serif'"/></td>
				
				<!-- table cell used to display the suggested country id based on user input -->
				<td width="300px">
				Suggestion: <span id="suggest_3"></span></td></tr>

			<tr><td align="right">
				<label for="country_id_4">4th:</label></td>
				
				<td>
				<!-- generates input field which clears on focus and calls the getSuggest function on key up -->
				<input name="country_id_4" type="text" id="country_id_4" onfocus="this.value=''" onKeyUp="getSuggest(this.value, 'suggest_4')" style="width: 200px; height: 30px; font-size: 16pt; font-family: 'Gill Sans', 'Gill Sans MT', 'Myriad Pro', 'DejaVu Sans Condensed', Helvetica, Arial, 'sans-serif'"/></td>
				
				<!-- table cell used to display the suggested country id based on user input -->
				<td width="300px">
				Suggestion: <span id="suggest_4"></span></td></tr>

			<tr><td colspan="3" align="center">
			<p align="center">
				<button class="button"><span>Compare</span></button>
			</p>
		</table></form>
	
	</div>
</body>
</html>