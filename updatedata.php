<?php
//File to send the coordinates for all the objects data collected
require('database.php');
require('DatabaseClass.php');

//Function for updating the DB with the already logged in user data
function update_user_login() {
 $ret = '';
 $email = $_POST['email'];
 $valx = $_POST['valx'];
 $valy = $_POST['valy'];
 $valz = $_POST['valz'];
 $objectid = $_POST['objectid'];
 $objectname = $_POST['objectname'];
 $dbObject = new DatabaseClass(DB_USER, DB_PASS, DB_SERVER);
 $dbObject->dbConnect(DB_DATABASE);
 
 $sql_userlogindata = "UPDATE `".TABLE_USERS."` SET survey_attempted = (survey_attempted+1),cumulative_aes_val_x=((cumulative_aes_val_x*(survey_attempted-1))+($valx))/(survey_attempted),cumulative_aes_val_y=((cumulative_aes_val_y*(survey_attempted-1))+($valy))/(survey_attempted),cumulative_aes_val_z=((cumulative_aes_val_z*(survey_attempted-1))+($valz))/(survey_attempted) WHERE username='$email';";
 $ret.= $sql_userlogindata;
 $dbObject->query($sql_userlogindata);
 $ret .= $sql_userlogindata;
 return $ret;
}

function update_object_table() {
 $ret = '';
 $valx = $_POST['valx'];
 $valy = $_POST['valy'];
 $valz = $_POST['valz'];
 $objectname = $_POST['objectname'];
 $dbObject = new DatabaseClass(DB_USER, DB_PASS, DB_SERVER);
 $dbObject->dbConnect(DB_DATABASE);
 
 $sql_objectdata = "UPDATE `".TABLE_OBJECTS."` SET count=count+1,objXcoor=((objXcoor*(count-1))+$valx)/(count),objYcoor=((objYcoor*(count-1))+$valy)/(count),objZcoor=((objZcoor*(count-1))+$valz)/(count) WHERE object_name='$objectname'";
 $dbObject->query($sql_objectdata);
  $ret .= $sql_objectdata;
 return $ret;
}

function update_question_data() {
 $ret ='';
 $valx = $_POST['valx'];
 $valy = $_POST['valy'];
 $valz = $_POST['valz'];
 $objectid = $_POST['objectid'];
 $dbObject = new DatabaseClass(DB_USER, DB_PASS, DB_SERVER);
 $dbObject->dbConnect(DB_DATABASE);
 
 $sql_questiondata = "INSERT INTO `".TABLE_QUESTIONS."` (question_one,question_two,question_three,object_id) VALUES ($valx, $valy, $valz, $objectid)";
 $dbObject->query($sql_questiondata);
 $ret .= $sql_questiondata;
 return $ret;
}
$ret = '<html><head></head><body>';
$ret = update_user_login();
$ret .= update_object_table();
$ret .= update_question_data();
$ret .= '</body></html>';
echo $ret;
?>