<?php
require('database.php');
require('DatabaseClass.php');
session_start();
ob_start();

$dbObject = new DatabaseClass(DB_USER, DB_PASS, DB_SERVER);
$dbObject->dbConnect(DB_DATABASE);
$myemail=$_POST['email'];
$myinterest=$_POST['aesinterest'];

// To protect MySQL injection (more detail about MySQL injection)
$myemail = stripslashes($myemail);
$myinterest = stripslashes($myinterest);
$myemail = mysql_real_escape_string($myemail);
$myinterest = mysql_real_escape_string($myinterest);

$sql="SELECT * FROM `".TABLE_USERS."` WHERE username='$myemail'";
$dbObject->query($sql);
$count=$dbObject->getNumOfRows()?1:0;

if($count>0){ //User exists
	$_SESSION['email']=$myemail;
	header("location:login_success.php");
}
else {
//Add this email to database after validating
	$country = visitor_country();
	if (filter_var($myemail, FILTER_VALIDATE_EMAIL)) {
    	$sql = "INSERT INTO `".TABLE_USERS."` (username , interest, country, survey_attempted) VALUES ('$myemail', '$myinterest', '$country' , 1)";
		$dbObject->query($sql);
		if($dbObject->getResult()){
		//Successful adding user name
			$_SESSION['email']=$myemail;
			header("location:login_success.php");
		}
		else
		{
			echo "Database error";
		}
	}
	else{
		echo "Invalid Email";
	}
}//count
ob_end_flush();

function visitor_country()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];
    $result  = "Unknown";
    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));

    if($ip_data && $ip_data->geoplugin_countryName != null)
    {
        $result = $ip_data->geoplugin_countryName;
    }

    return $result;
};
?>
