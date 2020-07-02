<?php
	session_start();
	$is_new_post = true;
    if (isset($_SESSION["pamm_key"]) && isset($_POST["pamm_key"])) { 
      if($_POST["pamm_key"] == $_SESSION["pamm_key"] ){
        $is_new_post = false;
      } 
    }
	if($is_new_post){
		if(isset($_POST['objectChosen']) && !empty($_POST['objectChosen'])){
			$_SESSION['objectChosen'] = $_POST['objectChosen'];
		}
		header('Location: questions.php');
		exit();
	}
	else{
		header('Location: login_success.php');
		exit();
	}
?>