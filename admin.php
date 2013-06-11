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
						foreach( $polls as $poll ){
							echo '<tr>';
							echo sprintf('<td>%s</td>', $poll->getTitle()) ;
							echo sprintf('<td>%s</td>', $poll->getDescription());
							echo sprintf('<td>%s</td>', $poll->getDepartment());
							echo sprintf('<td>%s</td>', format_datetime( $poll->getStartDate()) );
							echo sprintf('<td>%s</td>', format_datetime( $poll->getDueDate()) ) ;
							$imgurl = sprintf("%s/%s", $LOGO_DIR, $poll->getImgFilename() ) ;
							echo sprintf('<td class="img_logo"><a href="%s" target="blank"><img src="%s"></a></td>',  $imgurl , $imgurl );
							echo '<td><a class="btn btn-small" href="update_poll.php?poll_id='.$poll->getPollId().'"> &nbsp;<i class="icon-edit"></i>&nbsp;</a> 
								<a class="btn btn-small" href="remove_poll.php?poll_id='.$poll->getPollId().'"> &nbsp;<i class="icon-remove"> </i>&nbsp;</a>

								</td>'; 
							echo '</tr>';
						}

					?>
				</tbody>
			</table>
		</div>
	</div>

</div>



<?php require("bottom.php"); ?>
