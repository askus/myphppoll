<?php
	require_once( 'utility.php' );
	require_once( 'models.php');
	check_login();
	$option_id =  $_GET['option_id'];
	$poll_id = $_GET['poll_id'];

	if( !isset( $option_id)  ){ 
		$errMsg = "Not found option id.";
		$isSuccess = 0; 
	}else{ 
		$optionDao = new OptionDAO();
		$option = $optionDao->getOptionByOptionId( $option_id );

		$isSuccess= 0;

		if( $option->getPollId() != $poll_id ){
			$errMsg= "The option is not belong to the poll.";	
		}else{
			$option->setImgFilename("");
			$optionDao->updateOption( $option );
			$isSuccess = 1;
		}
		$optionDao->close();
	}
	echo sprintf(" { success: %d ,errMsg: '%s' }", $isSuccess, $errMsg );
?>