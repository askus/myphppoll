<?php
	$page_title ="後台-修改票選";
	$page = "update_poll";
	require_once( 'utility.php' );
	require_once( 'models.php' );
	require_once( 'form_utility.php'); 
	require_once( 'url.php');


	check_login();
	// check if exist poll_id 
	if( !isset( $_GET['poll_id'])  ){ redirect_to('admin.php'); }
	// check is the author's poll
	$pollDao = new PollDAO();
	$poll = $pollDao->getPollByPollId( $_GET['poll_id']);
	if( is_null( $poll ) ){ redirect_to('admin.php'); }

	// check updating 
	if( isset($_POST["updating"]) && $_POST["updating"]== 1 ){
			

		

		$poll = new Poll();
		$poll->setPollId( $_POST["poll_id"]);
		$poll->setTitle( $_POST['title']);
		$poll->setDescription( $_POST['description']);
		$poll->setDepartment( $_POST['department']);
		$poll->setStartDate( concate_datetime( $_POST['start_date'])  );
		$poll->setDueDate( concate_datetime( $_POST['due_date']));

		//print_r($poll );

		//echo "<br><br><br>";
		//print_r( $_POST["option"]);

		$option_array = array();

		//concate option
		$raw_option_array = array();
		foreach( $_POST['option']['poll_id'] as $key => $id ){
			$raw_option = array();
			$raw_option['poll_id']= $id ;
			$raw_option['rank'] =  $_POST['option']['rank'][$key];
			$raw_option['description'] = $_POST['option']['description'][$key];
			$raw_option['img_filename'] = $_POST['option']['img_filename'][$key];
			$raw_option_array[] = $raw_option ;
		}

		foreach( $raw_option_array as $raw_option ){
			$option = new Option();
			$option->setRank( $raw_option['rank']);
			$option->setDescription( $raw_option['description']);
			if( isset( $raw_option['option_id']) ){ $option->setOptionId( $raw_option['option_id']) ; }
			$option_array[] = $option;
		}
		$poll->setOptions( $option_array );
		$pollDao->updatePoll( $poll );

	}


?>
<?php require( "menu.php"); ?>
<div class="container">
	<div class="row">
	<div class="span2"></div>
	<div class="span8">
		<h3>修改票選內容</h3>
		<?php 
			require_once('_poll_form.php');
			render_poll_form( $poll ); ?>

	</div>
	<div class="span2"></div>
	</div>
</div>


<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/vendor/jquery.ui.widget.js"></script>
<script src="assets/js/jquery.iframe-transport.js"></script>
<script src="assets/js/jquery.fileupload.js"></script>
<script>
	/*
	$( function () {
		'use strict';
		var url = 'server/php/';
		$('.fileupload').fileupload({
			url: url,
    		dataType: 'json',
       		done: function (e, data) {
     	 		$.each(data.result.files, function (index, file) {
       		 		$('<p/>').text(file.name).appendTo( $(this) );
   				});
   				},
    		progressall: function (e, data) {
        		var progress = parseInt(data.loaded / data.total * 100, 10);
        		$(this).parent().next('.progress').find('.bar').css(
        			'width',
           			progress + '%'
           		);
        	}
    	});
   	});
   	*/
</script>
</body>
</html>