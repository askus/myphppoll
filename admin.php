<?php 
$page_title ="後台-投票";
$page = "admin.php";
require_once( 'utility.php');
check_login();

?>
<?php require( "menu.php"); ?>
<div class="container">
	<div class="row">
		<div class="span12">
			<h1>投票相關</h1>
			<table class="table">
				<thead>
					<th>標題</th>
					<th>內容</th>
					<th>截止日期</th>
					<th>開始日期</th>
					<th>標頭照片</th>
					<th>&nbsp;</th>
				</thead>
				<tbody>

				</tbody>
			</table>
		</div>
	</div>

</div>



<?php require("bottom.php"); ?>
