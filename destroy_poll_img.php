<?php
	require_once( 'utility.php' );
	require_once( 'models.php');
	check_login();
	$poll_id =  $_GET['poll_id'];
	$user = $_SESSION['user'];

	if( !isset( $poll_id)  ){ 
		$errMsg = "Not found poll id.";
		$isSuccess = 0; 
	} else { 

		$pollDao = new PollDAO();
		$poll = $pollDao->getPollByPollId( $poll_id );
		$isSuccess= 0;

		if( $user->getUserId() != $poll->getUserId() ){
			$errMsg= "The poll is not belong to the user.";	
		}else{
			$poll->setImgFilename("");
			$pollDao->updatePoll( $poll );
			$isSuccess = 1;
		}
		$pollDao->close();
	}
	echo sprintf(" { success: %d ,errMsg: '%s' }", $isSuccess, $errMsg );
?>