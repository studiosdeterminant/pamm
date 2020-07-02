<?php
session_start();
$user = $_SESSION['email'];
$object = $_SESSION['objectChosen'];
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>PAMM Survey</title>
<link rel="stylesheet" type="text/css" href="styles/questions-style.css">
<script src="scripts/jquery-1.10.2.min.js"></script>
<script src="scripts/jquery-ui.min.js"></script>
<script src="scripts/jquery.ui.touch-punch.min.js"></script>
<script src="scripts/jquery.bpopup.min.js"></script>

<script>
$(function() {

var tooltip = $('.tooltip');
tooltip.hide();

$( "#slider-range-max" ).slider({
range: "max",
min: 0,
max: 100,
value: 0,
slide: function( event, ui ) {
var valx =($( "#slider-range-max" ).slider('value'))*2-100;
if(valx > 0){
tooltip.css('left', valx+265).text("Function");
}else{
tooltip.css('left', valx+265).text("Non Function");
}
$( "#answer" ).val( ui.value ); 
},
start: function(event,ui) {  
          tooltip.fadeIn('fast');  
        },
stop: function(event,ui) {  
          tooltip.fadeOut('fast');  
        }
});
$( "#answer" ).val( $( "#slider-range-max" ).slider( "value" ) );
				
$('#help').bind('click', function(e) {
                e.preventDefault();
                $('#helpcontent').bPopup({
					follow: [false, false],
					position: [600, 300]
				});

            });

		$('#home').bind('click', function(e) {
                e.preventDefault();
				$.ajax({
					url: 'restart.php',
					type: 'POST',
					success: function(data){
							window.location="index.php";
						},
					error: function(xhr, ajaxOptions, thrownError){
							alert("Error: "+xhr.responseText);
						}
				});
           });
		   
			$('#reload').bind('click', function(e) {
                e.preventDefault();
				window.location.replace("login_success.php");
           });

			$('#back').bind('click', function(e) {
                e.preventDefault();
				window.history.back();
           });

}); //End of function()
</script>

</head>
<body>
<form method="post" action="ques1save.php">
<div id="mainContent">
<div id="pammlogo">
<img src="images/PAMM-logo-small.jpg" alt="PAMM">
</div>
<div id="back" title="Back" class="clickable"></div>
<div id="reload" title="Retake the test" class="clickable"></div>
<div id="home" title="Home" class="clickable"></div>
<table id="questiontable">
<tr>
<td>
<div id="objectpic">
<img src=
<?php
function get_object_picture() {
 require('database.php');
 require('DatabaseClass.php');
 $dbObject = new DatabaseClass(DB_USER, DB_PASS, DB_SERVER);
 $dbObject->dbConnect(DB_DATABASE);
 $ret = '"';
 $obj = $_SESSION['objectChosen'];
 $obj = stripslashes($obj);
 $obj = mysql_real_escape_string($obj);
 $sql = "SELECT object_id, object_image_src FROM `".TABLE_OBJECTS."` WHERE object_name='$obj'";
 $dbObject->query($sql);
 $row = $dbObject->getRow();
 $_SESSION['objectId']=$row[0];
 $_SESSION['objectPath']=$row[1];
 $ret .= $row[1].'" ';
 return $ret;
}
echo get_object_picture();
?>
 alt="object">
</div>
</td>
</tr>
<tr>
<td>
<div id="objectname"  style="margin: 0 auto; text-align: center;">
<label style="font: bold 16px arial,sans-serif; position: relative; top: 40px;">
<?php echo $object; ?>
</label>
</div>
</td>
</tr>
<tr style="margin: 0 auto; text-align: center;">
<td>
<label id="question">When experiencing "<?php echo $object;?>", please rate the experience from 1-100 when 1 is rating "<?php echo $object;?>" only as a non- functional choice and 100 is rating "<?php echo $object;?>" only as a functional choice.</label>
</td>
</tr>
</table>
<span class="tooltip" id="mytooltip"></span>
<div id="slider-range-max"></div> <!-- the Slider -->
<input type="text" id="answer" name="answerone" readonly/>
<input type="hidden" name="pamm_key" value="<?php echo md5("PAMMisaboutPOLYAESTHETICS"); ?>" />
<button id="go">Next</button>
<div id="help" title="Help" class="clickable"></div>
<div id="helpcontent">
<p>
Function of Utility: The Object of Expression.<br>Non Function: No Utility other than its beauty.
</p>
</div>
</div>
</form>
</body>
</html>