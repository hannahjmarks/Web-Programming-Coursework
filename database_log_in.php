<?php 

//login details for the database
$host="localhost";
$dbName="coa123cdb";
$username="coa123cycle";
$password="bgt87awx";
$dsn="mysql://$username:$password@$host/$dbName";

require_once('MDB2.php');

$db =& MDB2::connect($dsn);
//establishes connection to database
		
//checks connection
if (PEAR::isError($db)){
	die($db->getMessage());
	//if the connection fails then a message is displayed
}
?>