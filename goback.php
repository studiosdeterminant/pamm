<?php
	session_start();
	$_SESSION['answerOne'] = $_SESSION['answerOne'];
	$page = $_POST['page'];
	$page="Location: ".$page;
	header($page);
?>