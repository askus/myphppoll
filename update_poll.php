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
		$pollDao->close();
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
				render_poll_form( $poll ); ?>

		</div>
		<!--<div class="span2">&nbsp;</div> -->
	</div>
</div>


<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/vendor/jquery.ui.widget.js"></script>
<script src="assets/js/jquery.iframe-transport.js"></script>
<script src="assets/js/jquery.fileupload.js"></script>
<script>
	function destroy_row( id ){
		$("#option_table #"+id).remove();
	}
	
	$( function(){


			$("#new_row_btn").click( 
	
				function(){ 
					//console.log( $('input[name="option[rank][]"]').map( function(){ return parseInt( this.value) ; }).get() );
					var next_rank = Math.max.apply( null,  $('input[name="option[rank][]"]').map( function(){ return parseInt( this.value); }).get() ) +1;
					//console.log( max_rank ); 
					var next_row_id = Math.max.apply( null, $('.row_tr').map( function(){ console.log( parseInt(this.id) ) ; return parseInt( this.id ); } ).get() ) +1; 
					$("#option_table tr:last").after(
					'<tr id="'+next_row_id +'" class="row_tr" >'
					+'	<td><input class="span1" type="text" name="option[rank][]" value="'+ (next_rank)+'"></td>'
					+'	<td><textarea class="span5" rows="5" name="option[description][]"></textarea></td>'
					+'	<td><input type="hidden" name="option[option_id][]" value=""><input class="fileupload" name="option[img_filename][]" type="file"></td>'
					+'	<td><a onclick="destroy_row('+next_row_id+' )" class="btn btn-danger remove_row"><i class="icon-remove"></i></button></td>'
					+'</tr>')});
			
	} );

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