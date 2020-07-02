<?php
//File to send the coordinates for all the objects data collected
require('database.php');
require('DatabaseClass.php');
	
//Function for getting the object data
function get_object_coordinates() {
 $dbObject = new DatabaseClass(DB_USER, DB_PASS, DB_SERVER);
 $dbObject->dbConnect(DB_DATABASE);

 $sql = "SELECT object_name, objXcoor, objYcoor, objZcoor FROM `".TABLE_OBJECTS."`;";
 $dbObject->query($sql);

 if(!$dbObject->getResult()){
	echo "Error in updating database";
 }
 $rowArray = array("object_name", "objXcoor", "objYcoor", "objZcoor");
 $retarray = $dbObject->getDataSerially($rowArray);
 if(!$retarray){
	return "error";
 }
 return json_encode($retarray);
}
echo get_object_coordinates();
?>