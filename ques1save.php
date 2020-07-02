<?php
	session_start();
	$is_new_post = true;
    if (isset($_SESSION["pamm_key"]) && isset($_POST["pamm_key"])) { 
      if($_POST["pamm_key"] == $_SESSION["pamm_key"] ){
        $is_new_post = false;
      } 
    }
	//$_SESSION['answerOne'] = $_POST['answerone'];
	if($is_new_post){
		//if(isset($_POST['answerone']) && !empty($_POST['answerone'])){
			$_SESSION['answerOne'] = $_POST['answerone'];
		//}
		header('Location: questions-2.php');
		exit();
	}
	else{
		header('Location: login_success.php');
		exit();
	}
?>