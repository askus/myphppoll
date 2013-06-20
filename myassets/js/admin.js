function destroy_poll( poll_id ,  row_id ){
	var title =  $("#row_"+row_id+" .title" ).html();

	if( confirm( "您確定要刪除'" +title +"'嗎？" ) ){
		$.get( "destroy_poll.php", {'poll_id': poll_id },
					function( returnMsg ){
						console.log( returnMsg.errMsg );
						$("#row_"+row_id).remove();
					}
			);
	}

}