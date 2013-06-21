<?php 
$page_title ="分析投票";
$page = "analyze_poll";

$LOAD_JS_ARRAY= array( 'd3.v3.min.js'); 

require_once( 'utility.php');
require_once( 'models.php');
require_once( 'url.php');

check_login();
$poll_id = $_GET['poll_id'];
$user = $_SESSION['user']; 

// check user_id
$pollDao = new PollDAO();
$poll = $pollDao->getPollByPollId($poll_id ); 
if( $poll->getUserId() != $user->getUserId() ){
	redirect_to( "admin.php" );
}


$LAST_CODE_BLOCK = "<script>query_chart(".$poll->getPollId() .");</script>";

// summarize poll result  
$sorted_poll_result_array = array();
$i =0;
foreach( $poll->getOptions() as $option ){
	$sorted_poll_result_array[$i] = count( $option->getVotes()  ) ;
	$i++ ; 
}
arsort( $sorted_poll_result_array );

$total_count = 0;
$option_array = $poll->getOptions();
$poll_result_array = array();
foreach( $sorted_poll_result_array as $index => $count  ){
	$total_count += $count ;
	$poll_result_array [] = array( 'option'=> $option_array[$index] , 'count'=> $count );
}
if( $total_count == 0){ $total_count = 1 ;} // avoid zero dividing problem


?>
<?php require("menu.php"); ?>
<div class="carousel slide">
	<img class="logo" src="<?= logo_path( $poll->getImgFilenameOrDefault() ) ?>" >
	<div class="container">
		<div class="carousel-caption">
			<h1><?= $poll->getTitle() ?></h1>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
	
		<div class="span1">　</div>
		<div class="span10"><h3><?= $poll->getDescription() ?></h3><p>舉辦單位：<?= $poll->getDepartment() ?> </p></div>
		<div class="span1">　</div>
	</div>

	<center><h3>目前開票結果</h3></center>
	<div class="row">
		<div class="span1">　</div>
		<div id="poll_result_table" class="span10" >
			<table class="table">	
				<tr>
					<th class="span1">順序</td>
					<th>項目</th>
					<th class="span2">票數</th>
				</tr>	
				<?php
					$i = 1; 
					foreach( $poll_result_array as $poll_row ){
						$option = $poll_row['option'];
						$count = $poll_row['count'];

						echo "<tr>";
							echo "<td>".$i."</td>";
							echo "<td>";
							echo '		<div class="img">';
							if( !is_null( $option->getImgFilename() ) ){
									echo '<img class="img-polaroid" src="'.option_path($option->getImgFilename()).'"></div>';
							}else{
								echo '</div>';
							}
							echo '		 <div class="caption">'.$option->getDescription().'</div>';
							echo '	</td>';
							echo '<td>';
							echo sprintf('%d [ %.2f %%]', $count, $count/ $total_count );
							echo '</td>';
						echo "</tr>";
						$i++;
					}
				?>
			</table>
		</div>
		<div class="span1">　</div>
	</div>


</div>

<?php require("bottom.php"); ?>
