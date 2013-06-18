
<?php
	require_once( 'utility.php' );
	require_once( 'models.php');
	check_login();
	$poll_id = $_GET['poll_id'];
	$option_id = $_GET['option_id'];

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
			$optionDao->destroyOption( $option );
		}
		$optionDao->close();
	}
	echo sprintf(" { success: %d ,errMsg: '%s' }", $isSuccess, $errMsg );

?>