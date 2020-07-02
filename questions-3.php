<?php
session_start();
$user = $_SESSION['email'];
$path=$_SESSION['objectPath'];
$object = $_SESSION['objectChosen'];
$objectid = $_SESSION['objectId'];
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>PAMM Survey</title>
<link rel="stylesheet" type="text/css" href="styles/questions-3-style.css">
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
var valx =($( "#slider-range-max" ).slider('value'))*2 - 100;
if(valx > 0){
tooltip.css('left', valx+265).text("Direct Sensory");
}else{
tooltip.css('left', valx+265).text("Thinking");
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

                // Prevents the default action to be triggered. 
                e.preventDefault();

                // Triggering bPopup when click event is fired
                $('#helpcontent').bPopup({
					follow: [false, false],
					position: [600, 300]
				});

            });
			
			$('#home').bind('click', function(e) {
                // Prevents the default action to be triggered. 
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
                // Prevents the default action to be triggered. 
                e.preventDefault();
				window.location.replace("login_success.php");
           });

			$('#back').bind('click', function(e) {
                // Prevents the default action to be triggered. 
                e.preventDefault();
				window.history.back();
           });
			
$(document).ajaxStart(function () {
	$("#loading").dialog({
		modal: true,
		draggable: false,
		resizable: false,
		position: ['center', 'center'],
		show: 'blind',
		width: 300,
		height: 100
	});
    $("#loading").show();
});

$(document).ajaxComplete(function () {
    $("#loading").hide();
});

$(document).ready(function () {
    $("#loading").hide();
});

$( "#go" )
      .button()
      .click(function( event ) {
	  event.preventDefault();
	var valx=<?php echo $_SESSION['answerOne']; ?>;
	var valy=<?php echo $_SESSION['answerTwo']; ?>;
	var valz=document.getElementById('answer').value;
	var objectid=<?php echo $objectid; ?>;
	var objectname = '<?php echo $object; ?>';
	var username = '<?php echo $user; ?>';
		$.ajax({
			url: 'updatedata.php',
			type: 'POST',
			dataType: 'html',
			data : {'email':username, 'valx':valx, 'valy':valy, 'valz':valz, 'objectid': objectid, 'objectname':objectname},
			success: function(data){
					console.log("%s", data);
					document.getElementById("finalform").submit();
				},
			error: function(xhr, ajaxOptions, thrownError){
					console.log("Error "+xhr.responseText);
				}
		});
      });
}); //End of function()
</script>

</head>

<body>
<form method="post" id="finalform" action="Pamm-cube.php">
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
<img src="
<?php
echo $path;
?>"
 alt="object">
</div>
</td>
</tr>
<tr>
<td>
<div id="objectname" style="margin: 0 auto; text-align: center;">
<label style="font: bold 16px arial,sans-serif; position: relative; top: 40px;">
<?php echo $object; ?>
</label>
</div>
</td>
</tr>
<tr style="margin: 0 auto; text-align: center;">
<td>
<label id="question">When experiencing "<?php echo $object;?>", please rate the experience from 1-100 when 1 is acknowledging "<?php echo $object;?>" as only a thinking experience and 100 is acknowledging  "<?php echo $object;?>" only as a direct sensory experience.</label>
</td>
</tr>
</table>
<span class="tooltip" id="mytooltip"></span>
<div id="slider-range-max"></div> <!-- the Slider -->
<input type="text" id="answer" name="answerThree" readonly/>
<input type="hidden" name="pamm_key" value="<?php echo md5("PAMMisaboutPOLYAESTHETICS"); ?>" />
<button id="go">Next</button>
<div id="help" title="Help" class="clickable"></div>
<div id="helpcontent">
<p>
Thinking: Aesthetics of Thinking.<br>Direct Sensory: Little to No Effort in Thinking.
</p>
</div>
</div>
<div id="loading" title="Loading PAMM Cube">
  <p>Loading PAMM Cube...</p>
</div>
</form>
</body>
</html>