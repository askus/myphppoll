	function destroy_poll_img( poll_id ){
		if( confirm("您確定要刪除標頭照片嗎？") ){
			$.get( "destroy_poll_img.php", {'poll_id': poll_id },
					function( returnMsg ){
						console.log( returnMsg.errMsg );
						$(".poll_img").hide();
						$("#destroy_poll_img_btn").replaceWith('<input class="fileupload" name="poll_img" type="file"></input>');
						$("input[name=img_filename]").val("");
					}
			);
		}
	}
	function destroy_option_img( option_id, poll_id, row_id  ){
		var text = $("#"+row_id+" textarea").html();
		if( confirm("您確定要刪除: '"+text+"' 的照片嗎？")){
			$.get( "destroy_option_img.php", { 'option_id': option_id, 'poll_id': poll_id },
					function( returnMsg ){
						console.log( returnMsg.errMsg );
						$("#"+row_id+" img");
						//.replaceWith('<input name="option[option_img][]" class="fileupload" type="file"></input>');
						$("#"+row_id+" .destroy_opition_img_btn").remove();
						$("#"+row_id+" .hidden_option_img_filename").val("");
					}
			);

		}

	}

	function destroy_row( row_id, option_id ,poll_id  ){
		var text = $("#"+row_id+" textarea").html();
		//console.log( text );
		if( confirm( "您確定要刪除: '"+ text + "' 嗎？" )){
			if( option_id != null && poll_id != null ){
				$.get("destroy_option.php", {'option_id': option_id, 'poll_id': poll_id }, 
						function( returnMsg ){
							console.log( returnMsg.errMsg );
							
						}
				)
			}
			$("#option_table #"+row_id).remove();
		}
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
					+'	<td><input type="hidden" name="option[option_id][]" value=""><input class="fileupload" name="option[option_img][]" type="file"></td>'
					+'	<td><a onclick="destroy_row('+next_row_id+' )" class="btn btn-danger remove_row"><i class="icon-remove"></i></a></td>'
					+'</tr>')});
			
	} );

	