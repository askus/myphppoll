<?php
	$errMsgId = $_GET['errMsgId'];
	$page_title ="錯誤";
	$page = "error";

	$errMsgs = array("您之前已經投過了喔，請等一等再投票。");

	require( "utility.php");
	require( "models.php");
	require( "url.php");

?>
<?php require( "menu.php"); ?>
<p></p>
<div class="row">
	<div class="span2"></div>
	<div class="span8">
		<h1>錯誤</h1>
		<p class="text-error"><?= $errMsgs[$errMsgId] ?></p>
		<a href="index.php" class="btn"><i class="icon-arrow-left"></i>回到首頁</a>
	</div>
	<div class="span2"></div>
</div>

<?php require("bottom.php"); ?>