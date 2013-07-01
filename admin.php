<?php 
$page_title ="後台-投票";
$page = "admin";


require_once( 'utility.php');
require_once( 'models.php');
require_once( 'url.php');

check_login();

?>
<?php require( "menu.php"); ?>
<div class="container">
	<div class="row">
		<div class="span12">
			<h3>近期投票</h3>
			<table class="table">
				<thead>
					<th>標題</th>
					<th>內容</th>
					<th>科室</th>
					<th>截止日期</th>
					<th>開始日期</th>
					<th>標頭照片</th>
					<th>&nbsp;</th>
				</thead>
				<tbody>
					<?php 
						$user = $_SESSION["user"];
						$pollDao = new PollDAO();
						$polls = $pollDao->getPollByUserId( $user->getUserId());
						$row_id = 0;
						foreach( $polls as $poll ){
							echo '<tr id="row_'.$row_id.'">';
							echo sprintf('<td class="title">%s</td>', $poll->getTitle()) ;
							echo sprintf('<td>%s</td>', $poll->getDescription());
							echo sprintf('<td>%s</td>', $poll->getDepartment());
							echo sprintf('<td>%s</td>', format_datetime( $poll->getStartDate()) );
							echo sprintf('<td>%s</td>', format_datetime( $poll->getDueDate()) ) ;
							
							if( $poll->getImgFilename() != null ){
								$imgurl = sprintf("%s/%s", $LOGO_DIR, $poll->getImgFilename() ) ;
								echo sprintf('<td class="img_logo"><a href="%s" target="blank"><img src="%s"></a></td>',  $imgurl , $imgurl );
							}else{
								echo '<td class="img_logo">[無]</td>';
							}
							echo '<td>
									<a class="btn btn-small" href="analyze_poll.php?poll_id='.$poll->getPollId().'"> <i class="icon-eye-open"></i></a><br> 
									<a class="btn btn-small" href="update_poll.php?poll_id='.$poll->getPollId().'"> <i class="icon-edit"></i></a> <br>
									<a class="btn btn-small btn-danger" onclick="destroy_poll('.$poll->getPollId().', '. $row_id.')" > <i class="icon-remove"> </i></a>

								</td>'; 
							echo '</tr>';
							$row_id++;
						}
					?>
				</tbody>
			</table>
			<a class="btn btn-success" type="button" id="new_row_btn" href="create_poll.php">
				<i class="icon-plus"></i>增加新的票選活動
			</a>
		</div>
	</div>

</div>



<?php require("bottom.php"); ?>
