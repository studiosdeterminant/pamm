<?php
//File to send the coordinates for all the objects data collected
require('database.php');
require('DatabaseClass.php');

//Function for updating the DB with the already logged in user data
function getalldata() {
 $dbObject = new DatabaseClass(DB_USER, DB_PASS, DB_SERVER);
 $dbObject->dbConnect(DB_DATABASE);
 
 $sql = "SELECT cumulative_aes_val_x, cumulative_aes_val_y, cumulative_aes_val_z FROM `".TABLE_USERS."`;";
 $dbObject->query($sql);

 $rowArray = array("cumulative_aes_val_x", "cumulative_aes_val_y", "cumulative_aes_val_z");
 $retarray = $dbObject->getDataSerially($rowArray);
 if(!$retarray){
	return "error";
 }
 return json_encode($retarray);
}
echo getalldata();
?>