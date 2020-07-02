<?php
session_start();
$username = $_SESSION['email'];
$answer_X = $_SESSION['answerOne'];
$answer_Y = $_SESSION['answerTwo'];
$answer_Z = $_POST['answerThree'];
?>
<!doctype html>
<html lang="en">
	<head>
		<title>PAMM Cube</title>
		<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="styles/result.css">
	</head>
	<body>
		<!--div id="cubescene"></div-->
		<!-- include javascript files -->
		<script type="text/javascript" src="scripts/three.min.js"></script>
		<script type="text/javascript" src="scripts/Detector.js"></script>
		<script type="text/javascript" src="scripts/fonts/optimer_regular.typeface.js"></script>
		<script type="text/javascript" src="scripts/fonts/optimer_bold.typeface.js"></script>
		<script type="text/javascript" src="scripts/postprocessing/EffectComposer.js"></script>
		<script type="text/javascript" src="scripts/postprocessing/MaskPass.js"></script>
		<script type="text/javascript" src="scripts/postprocessing/RenderPass.js"></script>
		<script type="text/javascript" src="scripts/postprocessing/ShaderPass.js"></script>
		<script type="text/javascript" src="scripts/postprocessing/BloomPass.js"></script>
		<script type="text/javascript" src="scripts/shaders/CopyShader.js"></script>
		<script type="text/javascript" src="scripts/shaders/HorizontalBlurShader.js"></script>
		<script type="text/javascript" src="scripts/shaders/VerticalBlurShader.js"></script>
		<script type="text/javascript" src="scripts/shaders/AdditiveBlendShader.js"></script>
		<script type="text/javascript" src="scripts/jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="scripts/jquery-ui.min.js"></script>
		<script type="text/javascript" src="scripts/jquery.ui.touch-punch.min.js"></script>
		<script type="text/javascript" src="scripts/TrackballControls.js"></script>
		<script type="text/javascript">var answer_X = "<?= $answer_X ?>";</script>
		<script type="text/javascript">var answer_Y = "<?= $answer_Y ?>";</script>
		<script type="text/javascript">var answer_Z = "<?= $answer_Z ?>";</script>
		<script type="text/javascript">var username = "<?= $username ?>";</script>
		<!-- Code for initializing all the variables generated on runtime -->
		<script type="text/javascript" src="scripts/cube1.js"></script>
		<script type="text/javascript">
		  $(function() {
			$( "#creditbutton" )
			  .click(function( event ) {
				$("#dialog").dialog("open");
			  });
			 $("#dialog").dialog({
					create: function (event, ui) {
						$('.ui-dialog-titlebar').css({'background':'none','border':'none'});
						$(".ui-dialog-titlebar").html('<a href="#" role="button"><span class="myClose">close</span></a>');
						$("#dialog").css({ 'font-family': 'Helvetica', 'padding': '0', 'font-size': '12px' });
					},
					autoOpen: false,
					position: 'top' ,
					title: 'CREDITS',
					draggable: false,
					resizeable: false,
					width : 740,
					height : 500, 
					modal : true,
				});
			$( "#whatsthis" ).accordion({
				header: "h3",
				active: false,
				collapsible: true,
				heightStyle: "content",
				autoHeight: false,
				clearStyle: true,
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

			$("span.myClose").click(function() {
				$( "#dialog" ).dialog( "close" );
			});
		   
		  });
		</script>
		<div id='credits'>
		 <button id="creditbutton">Credits</button>
		</div>
		<div id="dialog">
			<iframe width="695" height="530" src="credits.html">
			</iframe>
		</div>
		<div id="helpcontainer">
			<div id="whatsthis">
			<h3>Help on the menu</h3>
			<div style="font:normal 14px Verdana, sans-serif;">
			You can use the Interact with PAMM menu on the far left by clicking on the corresponding tabs. Following is the information
			on each one of them.
			<ul>
			<li>Demographic: This will show you the data corresponding to survey filled by people from different countries.</li>
			<li>Aesthetic Result: This will show you the data corresponding to each of the aesthetic result which has been collected till date.</li>
			<li>User's Data: This will show you the data collected from you for different objects at different point in time.</li>
			<li>Object's Result: This will show you the data corresponding to the cumulative result obtained for an object for all the surveys given.</li>
			<li>All: Gives all the data collected till date.</li>
			</ul>
			</div>
			<h3>Instructions</h3>
			<div style="font:normal 12px Verdana, sans-serif;">
			<ul>
			<li>Choose one of the nine aesthetic expressions to map by clicking on one square.</li>
			<li>Use the slider to answer the next three questions about that item. Remember to click submit after you have made your choice. Is this item non functional or functional? Did this item take mental prowess or physical prowess to make? It this item experienced more as thinking experience or direct sensory experience?</li>
			<li>A rendered 3-D revelation made from your decisions will be plotted in the cube.</li>
			<li>You will require WebGL support on the browser. Also, you will require a device with decent graphics rendering capability. The browsers supported are IE11, Chrome (all devices), Firefox (all devices), Safari 5.1 onwards, Opera 15 onwards, Blackberry Browser 10, Opera Mobile 16.</li>
			</ul>
			</div>
			<h3>About</h3>
			<div style="font:normal 12px Verdana, sans-serif;">
			<p>
			This application is designed as a survey tool to map a variety of aesthetic expressions. <br>The results are displayed within a computer generated three-dimensional Cartesian coordinate model – a cube. The viewer can see the difference between how they judge the aesthetic category of a certain expression and compare that to the group demographics for the same expression.<br>By challenging the definitions of aesthetics and how we normally look at it, this mapping will help assist artists and scientists as well as non-artists and scientists to understand the nature of their personal aesthetic and how it relates to science, art and other aesthetic expressions.
			</p>
			</div>
			<h3>Retake the Survey</h3>
				<div id="loadlinks">
				<div style="position: relative; left: 10px; top: 20px; border:0;height:48px;width:48px;background: url('images/start.png') 0 0 no-repeat;cursor: pointer;" id="home" class="clickable"></div>
				<div style="position: relative; left: 70px; top: -67px; border:0;height:48px;width:48px;background: url('images/reload.png') 0 0 no-repeat;cursor: pointer;" id="reload" class="clickable"></div>
				</div>
			</div>
		</div>
		<div id="usingdirection">
			<div>"Swipe to rotate the cube. Use labeled "+" and "-" buttons above to zoom in and out"</div>
		</div>
		<div id="PAMMlogotext"></div>
		<div id="interactPAMM">Interact with PAMM</div>
		<div id="menuforPAMM">
		<ul>
		   <li><a href='#' id="demographybtn" class="clickable"><span>Demographic Data</span></a></li>
		   <li><a href='#' id="aestheticsbtn"><span>Aesthetic Result</span></a></li>
		   <li><a href='#' id="usersbtn"><span>Users Data</span></a></li>
		   <li><a href='#' id="objectbtn"><span>Objectwise Result</span></a></li>
		   <li class='last' id="allbtn"><a href='#'><span>All</span></a></li>
		</ul>
		</div>
		<div id="zoomin" class="clickable">+</div>
		<div id="zoomout" class="clickable">-</div>
		<div id="museopted"></div>
	</body>
</html>
