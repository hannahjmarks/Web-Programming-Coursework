<?php

include 'database_log_in.php';
//include file to access database


$q=strtoupper($_REQUEST["q"]);
//gets the value entered into the input on the form in view.php
$suggestion='';

if(!empty($q)){
	//if the input is not empty:
	
	$sqlQuery="SELECT ISO_id FROM Country WHERE ISO_id LIKE '$q%'";
	//find all the entries in the Country table whose ISO_id's begin with the value input
	
	$results =& $db->query($sqlQuery);

	
	$row=$results->fetchRow();
	$suggestion=$row[0];
	//gets only the first row as too many suggestions can become unhelpful
	
	echo $suggestion;
	//uses echo to return the suggestion to view.php
}

?>