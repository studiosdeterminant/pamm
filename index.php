<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>PAMM Survey</title>
<link rel="stylesheet" type="text/css" href="styles/loginbypass.css">
<link rel="stylesheet" type="text/css" href="styles/jquery-ui.css">
<script src="scripts/jquery-1.10.2.min.js"></script>
<script src="scripts/jquery-ui.min.js"></script>
<script>
/* Function to validate the email entered */
function checkvalue() 
{ 
    var boxValue = document.getElementById('email').value; 
    if(!boxValue.match(/\S/)) {
        alert ('Please fill in your email address!');
        return false;
    } else {
        return true;
    }
}
</script>
</head>
<body>
<script type="text/javascript">
$(function() {
	$("#inscontent").dialog({
		modal: true,
		autoOpen: false,
		draggable: false,
		resizable: false,
		title: "Instructions",
		position: ['center', 'center'],
		show: 'blind',
		width: 400,
		height: 300,
	});
	$('#instruction').bind('click', function(e) {
        e.preventDefault();
		$("#inscontent").dialog("open");
    });
});
</script>
<div id="mainContent">
<form name="form1" method="post" action="login.php">
<label id="muses">Poly Aesthetic Mapping: The Muses</label>
<div id="pammimage">
<img src="images/PAMM-login-logo.jpg" alt="PAMM">
</div>
<table id="logintable">
<tr>
<td>
<label id="pammtext">PAMM</label>
</td>
</tr>
<tr>
<td>
<label id="useremail">Survey for OMA</label>
</td>
<tr>
<td>
<input type="email" name="email" id="email" value="pamm@oma-online.org"/>
</td>
</tr>
<tr>
<td>
<label id="interest">Please choose the area of your expertise</label>
</td>
</tr>
<tr>
<td>
<select name="aesinterest" id="aesinterest">
  <option value="appliedscience">Applied Science</option>
  <option value="formalscience">Formal Science</option>
  <option value="interart">Interdisciplinary Art</option>
  <option value="langart">Language Arts</option>
  <option value="natscience">Natural Science</option>
  <option value="perfart">Performing Arts</option>
  <option value="social">Social Science</option>
  <option value="visarts">Visual Arts</option>
  <option value="other">Other</option>
</select>
</td>
</tr>
</table>
<button id="submit">Next</button>
<div id="instruction" class="clickable">Instructions</div>
<div id="inscontent">
<p>
This application is designed as a survey tool to map a variety of aesthetic expressions. The results are displayed within a computer generated three-dimensional Cartesian coordinate model – a cube. The viewer can see the difference between how they judge the aesthetic category of a certain expression and compare that to the group demographics for the same expression.   By challenging the definitions of aesthetics and how we normally look at it, this mapping will help assist artists and scientists as well as non-artists and scientists to understand the nature of their personal aesthetic and how it relates to science, art and other aesthetic expressions.
<br>
<br>
To use this app:
<br>
<br>
1. Choose one of the nine aesthetic expressions to map by clicking on one square
<br>2. Use the slider to answer the next three questions about that item. Remember to click submit after you have made your choice. Is this item non functional or functional? Did this item take mental prowess or physical prowess to make? It this item experienced more as thinking experience or direct sensory experience?
<br>3. A rendered 3-D revelation made from your decisions will be plotted in the cube.
<br><br>You may explore a number of demographic comparison results as well
<br>You will require WebGL support on the browser. Also, you will require a device with decent graphics rendering capability. The browsers supported are IE11, Chrome (all devices), Firefox (all devices), Safari 5.1 onwards, Opera 15 onwards, Blackberry Browser 10, Opera Mobile 16.
</p>
</div>
</form>
</div>
</body>
</html>