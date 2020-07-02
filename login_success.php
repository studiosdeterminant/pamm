<?php
ini_set('session.gc_maxlifetime', 100*60*60*24); //100 days
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > (2*60*60*24))) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
session_start();
$user = $_SESSION['email'];
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Lets get it started...</title>
<link rel="stylesheet" type="text/css" href="styles/explain-style.css">
<link rel="stylesheet" href="styles/jquery-ui.css" />
<script src="scripts/jquery-1.10.2.min.js"></script>
<script src="scripts/jquery-ui.min.js"></script>

<style type="text/css">
#objectslist .ui-selected {
    background: red;
    color: white;
    font-weight: bold;
}

#objectslist {
    list-style-type: none;
    margin: 0;
    padding: 0;
    width: 280px;
	height: 240px;
    position: relative;
    left: 110px;
    top: 70px;
}

#objectslist li {
    margin: 2px;
    padding: 2px;
	float: left;
    font-size: 0.75em;
	width: 80px;
    height: 75px;
	text-align: center;
	font-family:Gill Sans, sans-serif;
}
</style>
<script>
	var length = 0;
	$(document).ready(function(){
    $( "#objectslist" ).selectable({
	selected: function(ev, ui) {
		document.getElementById('objectid').value = $(ui.selected).text();
		$(ui.selected).siblings().removeClass("ui-selected");
		length = $(ui.selected).text().length;
		}
	});
	
		$( document ).tooltip({
		  items: "li",
		  content: function() {
			var element = $( this );
			if ( element.is( "li" ) ) {
				var text = element.text();
				var num = $("li").index(this) + 1;
				return "<img alt='" + text +
				"' src='images/"+num+".jpg?" +
				text + "'>";
			}
		  },
		});
	
		jQuery('#choice').bind('submit',function(e){
			if (length == 0)
				alert("Please select a choice!");
			else
				$("#choice").submit();
		});
		
		$('#back').bind('click', function(e) {
            e.preventDefault();
			window.history.back();
		});
	});
	
</script>
</head>
<body>
<form id="choice" method="post" action="loginsave.php">
<div id="mainContent">
<div id="pammimage2">
<img src="images/PAMM-logo-small.jpg" alt="PAMM"/>
</div>
<table id="objecttable">
<tr>
<td>
<label id="explanation">Hi <?php echo $user; ?>,<br>You'll be asked 3 questions and you have to answer them on the aesthetic feeling you get about the object which you can choose from the following list</label>
</td>
</tr>
<tr>
<td>
<ol id="objectslist">
<?php
function get_object_data() {
	require('database.php');
	require('DatabaseClass.php');
	$dbObject = new DatabaseClass(DB_USER, DB_PASS, DB_SERVER);
	$dbObject->dbConnect(DB_DATABASE);
	$sql = "SELECT object_name FROM `".TABLE_OBJECTS."`";
	$dbObject->query($sql);
	$arr = $dbObject->getDataInArray();
	if($arr==null){
		return "Error getting objects!";
	}
	return $arr;
}

function ol_tree(){
	$objects = get_object_data();
	$out = '';
	foreach($objects as $obj){
		$out .= '<li class="ui-state-default">';
		$out .= $obj;
		$out .= '</li>';
	}
	return $out;
}
$temp = ol_tree();
echo $temp;
?>
</ol>
</td>
</tr>
<tr>
<td>
<div id="back" title="Back" class="clickable"></div>
<input type="hidden" id="objectid" name="objectChosen">
<input type="hidden" name="pamm_key" value="<?php echo md5("PAMMisaboutPOLYAESTHETICS"); ?>" />
<button id="go">Next</button>
</td>
</tr>
</table>
</div>
</form>
</body>
</html>