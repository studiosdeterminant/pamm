<?php
	session_start();
	$is_new_post = true;
    if (isset($_SESSION["pamm_key"]) && isset($_POST["pamm_key"])) { 
      if($_POST["pamm_key"] == $_SESSION["pamm_key"] ){
        $is_new_post = false;
      } 
    }
	if($is_new_post){
		//if(isset($_POST['answerTwo']) && !empty($_POST['answerTwo'])){
			$_SESSION['answerTwo'] = $_POST['answerTwo'];
		//}
		header('Location: questions-3.php');
		exit();
	}
	else{
		header('Location: questions-2.php');
		exit();
	}
?>