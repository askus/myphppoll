<?php 
$page_title ="臺中市政府社會局票選系統";
$page = "index";

require_once("models.php");
require_once("utility.php");
require_once("url.php");
$pollDao = new PollDAO();
$all_latest_polls = $pollDao->getPollBeforeDatetime(  new DateTime(null, new DateTimeZone('Asia/Taipei'))); 
$select_polls = array();
$MAX_NUM_SHOW_POLL= 5;
for( $i =0 ; $i< $MAX_NUM_SHOW_POLL && $i < count( $all_latest_polls); $i++ ){ $select_polls[]= $all_latest_polls[$i];}
//print_r( $select_polls );
shuffle( $select_polls  );
$MAX_STR_LEN=100;


?>


<?php require( "menu.php"); ?>
<!-- Carousel-->
<div id="myCarousel" class="carousel slide">
	<div class= "carousel-inner">
		<?php
			$isFirst =true; 
			foreach( $select_polls as $poll ){
				if( $isFirst ){
					echo '<div class="item active">';
					$isFirst = false; 
				}else{
					echo '<div class="item">';
				}
				echo '	<img src="'.logo_path( $poll->getImgFilenameOrDefault() ).'">';
				echo '	<div class="container">';
				echo '		<div class="carousel-caption">';
				echo '			<h1>'.$poll->getTitle().'</h1>';
				echo '			<p class="lead">'.trim_str( $poll->getDescription(), $MAX_STR_LEN).'</p>';
				echo '			<a class="btn btn-large btn-primary" href="vote.php?poll_id='.$poll->getPollId().'">參與投票</a>'; 
				echo '		</div>';
				echo '	</div>';
				echo '</div>';
			}

		?>
	</div>
	<a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
</div>

 <div class="container marketing">
      <!-- Three columns of text below the carousel -->
      
</div>

<?php require("bottom.php"); ?>