<?php
//File to send the coordinates for all the objects data collected
require('database.php');
require('DatabaseClass.php');

//Function for updating the DB with the already logged in user data
function getUserAestheticData() {
 $dbObject = new DatabaseClass(DB_USER, DB_PASS, DB_SERVER);
 $dbObject->dbConnect(DB_DATABASE);
 
 $sql = "SELECT interest, AVG(cumulative_aes_val_x), AVG(cumulative_aes_val_y), AVG(cumulative_aes_val_z) FROM `".TABLE_USERS."` GROUP BY interest;";
 $dbObject->query($sql);

 $rowArray = array("interest", "AVG(cumulative_aes_val_x)", "AVG(cumulative_aes_val_x)", "AVG(cumulative_aes_val_x)");
 $retarray = $dbObject->getDataSerially($rowArray);
 if(!$retarray){
	return $dbObject->result;
 }
 return json_encode($retarray);
}
echo getUserAestheticData();
?>