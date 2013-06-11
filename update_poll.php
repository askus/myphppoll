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

	// check is updating 
	if( isset($_POST["updating"]) && $_POST["updating"]== 1 ){
		$poll = new Poll();
		$poll->setPollId( $_POST["poll_id"]);

	}

?>
<?php require( "menu.php"); ?>
<div class="container">
	<div class="row">
	<div class="span2"></div>
	<div class="span8">
		<h3>修改票選內容</h3>
		<form action="update_poll.php?poll_id=<?= $poll->getPollId(); ?>" enctype="multipart/form-data" method="POST">
		<table>

			<input type="hidden" name="updating" value=1>
			<input type="hidden" name="poll_id" value="<?= $poll->getPollId() ?>"></input>
			<tr><td><label>標題</label></td><td><?php echo short_text( "title", $poll->getTitle(), 4  ); ?> </td></tr>
			<tr><td><label>內容</label></td><td><?php echo long_text( "description", $poll->getDescription() ); ?></td></tr>
			<tr><td><label>科室</label></td><td><?php echo short_text("department", $poll->getDepartment(), 3 ); ?></td></tr>
			<tr><td><label>開始日期</label></td><td><?php echo datetime("start_date", $poll->getStartDate()); ?></td></tr>
			<tr><td><label>截止日期</label></td><td><?php echo datetime("due_date", $poll->getDueDate( )); ?></td></tr>
			<tr>
				<td>
					<label>標頭照片</label>
				</td>
				<td>
					<? if( !is_null( $poll->getImgFilename()) ){ echo '<img src="'.logo_path( $poll->getImgFilename()).'" class="img-rounded" >' ;}?>
					<input name="imgFile" type="file"></input>
					<span class="help-block">建議上傳圖片大小：1500 x 300。僅支援 .jpg .png 格式</span>
				</td>
			</tr>	
		</table>
		<h4>選項</h4>
		<table>
			<tr><th>排序</th><th>說明</th><th>附加圖片</th></tr>
			<?php 
				foreach( $poll->getOptions() as $option){
					echo '<tr>';
					echo '<td>1</td>';
					echo '<td>1</td>';
					echo '<td>1</td>';
					echo '</tr>';
				}
			?>
		</table>
		<table>
			<tr><td></td><td><input class="btn btn-primary" type="submit"> &nbsp; <a class="btn" href="admin.php">放棄修改</a></input></td></tr> 
		</table>
		</form>
	</div>
	<div class="span2"></div>
	</div>
</div>
<?php require("bottom.php"); ?>
