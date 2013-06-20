<?php
	//$errMsgId = $_GET['errMsgId'];
	$poll_id = $_GET['poll_id'];
	$page_title ="投票成功";
	$page = "success";

	////$errMsgs = array("您之前已經投過了喔，請等一等再投票。");
	require( "utility.php");
	require( "models.php");
	require( "url.php");

	$pollDao = new PollDAO();
	$poll = $pollDao->getPollByPollId( $poll_id );


?>
<?php require( "menu.php"); ?>

<div class="carousel slide">
	<img class="logo" src="<?= logo_path( $poll->getImgFilenameOrDefault() ) ?>" >
	<div class="container">
		<div class="carousel-caption">
			<h1><?= $poll->getTitle() ?></h1>
		</div>
	</div>
</div>

<p></p>
<div class="row">
	<div class="span2"></div>
	<div class="span8">
		<h2 >投票成功！感謝您的一票！</h2>
		<a href="index.php" class="btn"><i class="icon-arrow-left"></i>回到首頁</a>
	</div>
	<div class="span2"></div>
</div>

<?php require("bottom.php"); ?>