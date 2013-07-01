

<?php 
require_once( 'form_utility.php');
require_once( 'url.php');
	function fileupload_html( $name ){
		return '<input class="fileupload" name="'.$name.'" type="file"></input>';
		/* return  ' 		<span class="btn btn-success fileinput-button" >'
				.'			<i class="icon-plus icon-white"> </i>'
				.'			<span>選擇檔案</span>'
				.'			<input class="fileupload" name="'.$name.'" type="file"></input>'
				.'		</span>'
				.'	<div class="progress progress-success progress-striped">
        				<div class="bar" style="width: 0%;"></div>
    				</div>'
    			.'  <div id="files" class="files"></div>'
				;
		*/
	}
	function render_create_poll_form( ){
		echo '<form action="create_poll.php" enctype="multipart/form-data" method="POST">';
		$poll = new Poll();
		$poll->setStartDate( new DateTime( null,new DateTimeZone('Asia/Taipei') ) );
		$tomorrow = new DateTime(null, new DateTimeZone('Asia/Taipei'));
		$tomorrow->modify("+1 day");
		$poll->setDueDate( $tomorrow );

		$firstOption = new Option();
		$firstOption->setRank(1);
		$poll->setOptions( array( $firstOption) );
		render_poll_form( $poll );
	}
	function render_update_poll_form( $poll ){
		echo '<form action="update_poll.php?poll_id='.$poll->getPollId().'" enctype="multipart/form-data" method="POST">';
		render_poll_form( $poll );
	}
	function render_poll_form( $poll ){
		//echo '<form action="update_poll.php?poll_id='.$poll->getPollId().'" enctype="multipart/form-data" method="POST">';
		echo '<table>';
		echo '	<input type="hidden" name="updating" value=1>';
		if( is_null( $poll->getPollId() ) ){
			$poll_id = "";		
		}else{
			$poll_id = $poll->getPollId();
		}
		echo '	<input type="hidden" name="poll_id" value="'.$poll_id.'"></input>';
		if( is_null( $poll->getUserId())){	$user_id= 1	;}else{ $user_id = $poll->getUserId();  }
		echo '	<input type="hidden" name="user_id" value="'.$user_id.'"></input>';
		echo '	<tr><td><label>標題</label></td><td>'.short_text( "title", $poll->getTitle(), 4  ).' </td></tr>';
		echo '	<tr><td><label>內容</label></td><td>'.long_text( "description", $poll->getDescription()) .'</td></tr>';
		echo '	<tr><td><label>科室</label></td><td>'.short_text("department", $poll->getDepartment(), 3 ).'</td></tr>';
		echo '	<tr><td><label>開始日期</label></td><td>'.datetime("start_date", $poll->getStartDate()).'</td></tr>';
		echo '	<tr><td><label>截止日期</label></td><td>'.datetime("due_date", $poll->getDueDate( )).'</td></tr>';
		echo '	<tr>';
		echo '		<td>';
		echo '			<label>標頭照片</label>';
		echo '		</td>';
		echo '		<td>';
		if( !is_null( $poll->getImgFilename()) ){ 
			echo '<img src="'.logo_path( $poll->getImgFilename()).'" class="img-rounded poll_img" > ' ;
			echo '<a id="destroy_poll_img_btn" onclick="destroy_poll_img( '. $poll->getPollId(). ' )" class="btn btn-danger"><i class="icon-remove"></i>刪除圖片</a>';
			$poll_img_filename = $poll->getImgFilename();
		}else{
			echo fileupload_html( "poll_img");
			$poll_img_filename = "";
		}
		echo '<input type="hidden" name="img_filename" value="'.$poll_img_filename.'"></input>';
		echo '<br>';
		echo '		<span class="help-block">建議上傳圖片大小：1500 x 300。僅支援 .jpg .png 格式</span>';
		echo '		</td>';
		echo '	</tr>';	
		echo '</table>';
		echo '<h4>選項</h4>';
		echo '<table class="table" id="option_table">';
		echo '	<tr><th class="span1">排序</th><th class="span5">說明</th><th class="span5">附加圖片</th><th class="span1"></th></tr>';
				$row_id = 0;
				foreach( $poll->getOptions() as $option){
					echo '<tr id="'.$row_id.'" class="row_tr">';
					echo '<td>'.short_text( 'option[rank][]', $option->getRank(), 1).'</td>';
					echo '<td>'.long_text('option[description][]', $option->getDescription()).'</td>';
					echo '<td>';
					echo hidden( 'option[option_id][]', $option->getOptionId() ) ;
					if( !is_null( $option->getImgFilename())){ 
						echo '<img src="'.option_path( $option->getImgFilename()).'" class="img_rounded" >';
						echo '<br><a onclick="destroy_option_img( '. $option->getOptionId(). ', '.$option->getPollId().', '. $row_id.' )" class="btn btn-danger destroy_opition_img_btn"><i class="icon-remove"></i>刪除圖片</a>';				
						echo '<br>';
						echo fileupload_html( 'option[option_img][]');
						$option_img_filename = $option->getImgFilename();
					}else{ 
						echo fileupload_html( 'option[option_img][]');
						$option_img_filename = ""; 
					}
					echo '<input type="hidden" class="hidden_option_img_filename" name="option[img_filename][]" value="'.$option_img_filename.'"></input>';
					//echo '<input  class="fileupload" name="option[][img_filename]" type="file"></input>';
					echo '</td>';
					echo '<td><a onclick="destroy_row('.$row_id.','.$option->getOptionId().','.$option->getPollId().')" class="btn btn-danger remove_row"><i class="icon-remove"></i></a></td>';
					echo '</tr>';
					$row_id += 1;
				}
		echo '</table>';

		echo '<table>';
		echo ' <tr><td></td><td><button class="btn btn-success" type="button" id="new_row_btn"><i class="icon-plus"></i>增加新的欄位</button></td>';
		echo ' <tr><td colspan=2>&nbsp;</td></tr>';
		echo '	<tr><td></td><td><input class="btn btn-primary" type="submit" value="更新"> &nbsp; <a class="btn" href="admin.php">放棄修改</a></input></td></tr>'; 
		echo '</table>';
		echo '</form>';




		}

?>