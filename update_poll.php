<?php
	$page_title ="後台-修改票選";
	$page = "update_poll";
	$LOAD_JS_ARRAY=array("_form.js");

	require_once( 'utility.php' );
	require_once( 'models.php' );
	require_once( 'form_utility.php'); 
	require_once( 'url.php');
	require_once( 'upload_utility.php');

	check_login();
	// check if exist poll_id 
	if( !isset( $_GET['poll_id'])  ){ redirect_to('admin.php'); }
	// check is the author's poll
	$pollDao = new PollDAO();
	$poll = $pollDao->getPollByPollId( $_GET['poll_id']);
	if( is_null( $poll ) ){ redirect_to('admin.php'); }

	// check updating 
	if( isset($_POST["updating"]) && $_POST["updating"]== 1 ){
		
		$option_array = array();
		//concate option
		$raw_option_array = array();
		foreach( $_POST['option']['option_id'] as $key => $id ){
			$raw_option = array();
			$raw_option['option_id']= $id ;
			$raw_option['poll_id'] = $poll->getPollId();
			$raw_option['rank'] =  $_POST['option']['rank'][$key];
			$raw_option['description'] = $_POST['option']['description'][$key];
			$raw_option['img_filename'] = $_POST['option']['img_filename'][$key];
			//process img file
			$option_file = array();
			$option_file['name'] = $_FILES['option']['name']['option_img'][$key];
			$option_file['type'] = $_FILES['option']['type']['option_img'][$key];
			$option_file['tmp_name'] = $_FILES['option']['tmp_name']['option_img'][$key];
			$option_file['error'] = $_FILES['option']['error']['option_img'][$key ];
			$option_file['size'] = $_FILES['option']['size']['option_img'][$key ];
			$raw_option['option_img'] = $option_file ;

			$raw_option_array[] = $raw_option ;
		}
		//update poll
		$poll = new Poll();
		$poll->setPollId( $_POST["poll_id"]);
		$poll->setTitle( $_POST['title']);
		$poll->setDescription( $_POST['description']);
		$poll->setDepartment( $_POST['department']);
		$poll->setStartDate( concate_datetime( $_POST['start_date'])  );
		$poll->setDueDate( concate_datetime( $_POST['due_date']));
		$poll->setImgFilename( $_POST['img_filename']);
		$poll->setUserId( $_POST['user_id']);

		//process for image uploading
		$errMsg= "";
		if( check_upload_img( $_FILES["poll_img"] , $errMsg  )  ){
			$poll_img_filename = move_to_place( $_FILES["poll_img"], $LOGO_DIR, $poll->getPollId() );
			$poll->setImgFilename( $poll_img_filename );
		}

		$optionDao = new OptionDAO();
		foreach( $raw_option_array as $raw_option ){
			$option = new Option();
			$option->setRank( $raw_option['rank']);
			$option->setDescription( $raw_option['description']);
			$option->setImgFilename( $raw_option['img_filename']);
			
			if( !isset( $raw_option['option_id'] ) or $raw_option['option_id'] =="" or $raw_option['option_id'] ==null ){
				$tmp_poll_id= -1;
				$option->setPollId( $tmp_poll_id );
				$option_id = $optionDao->insertOption( $option);
				$option->setOptionId( $option_id );
			}else{
				$option->setOptionId( $raw_option['option_id']) ; 
			}

			if( check_upload_img( $raw_option['option_img'], $errMsg ) ){
				$option_img_filename = move_to_place( $raw_option['option_img'], $OPTION_DIR, $option->getOptionId() );
				$option->setImgFilename( $option_img_filename );
			}
			$option_array[] = $option;
		}
		$poll->setOptions( $option_array );
		
		$pollDao->updatePoll( $poll );
		$pollDao->close();

		redirect_to("admin.php");
	}

?>
<?php require( "menu.php"); ?>
<div class="container">
	<div class="row">
		<!-- <div class="span">&nbsp;</div> -->
		<div class="span12">
			<h3>修改票選內容</h3>
			<?php 
				require_once('_poll_form.php');
				render_update_poll_form( $poll ); ?>

		</div>
		<!--<div class="span2">&nbsp;</div> -->
	</div>
</div>

<?php require("bottom.php"); ?>
