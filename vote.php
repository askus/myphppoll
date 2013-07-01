<?php 
session_start(); // for captcha

$poll_id= $_GET['poll_id'];
$page_title ="社會局票選系統";
$page = "vote";

$VOTE_INTERVAL = 24;  // hour

require( "utility.php");
require( "models.php");
require( "url.php");


// check id 
if( !isset( $poll_id )){ redirect_to("index.php") ; }

$pollDao = new PollDAO();
$poll = $pollDao->getPollByPollId( $poll_id );
// check poll_id is correct 
if( is_null( $poll) ){ redirect_to("index.php");}

// set title and img 
$site_img =  "http://".$_SERVER['SERVER_NAME']. dirname( $_SERVER['REQUEST_URI'] )."/".logo_path( $poll->getImgFilenameOrDefault() );
$page_title = $poll->getTitle();
$page_description = $poll->getDescription();

// new a vote 
$vote= new Vote();
$vote->setOptionId( $_POST['choice_option_id']);
$vote->setIp( $_SERVER['REMOTE_ADDR']);

// check if voted
$voteDao = new VoteDAO();
$lastVotes = $voteDao->getVoteByIpAndPollId( $vote->getIp() , $poll->getPollId() );

if( count( $lastVotes ) > 0 && abs( time() - strtotime( $lastVotes[0]->getLastVote() ) ) < $VOTE_INTERVAL * 60 * 60    ) {
//if( count( $lastVotes ) > 0 && abs( time() - strtotime( $lastVotes[0]->getLastVote() ) ) <  60    ) {

	redirect_to("error.php?errMsgId=0");
	$errMsgs[] = "您已經投過票囉。";
}

//error handling
$errMsgs = array();

if( isset($_POST['updating']) && $_POST['updating'] == 1 ) {
	$isOk = true ;

	//print_r( $vote );
	if( !isset($_POST['choice_option_id']) || is_null( $vote->getOptionId() ) ) {
		$errMsg ="請選擇一個選項。";
		$errMsgs[] = $errMsg;
		$isOk = false; 
	}else{
		//$choice_option_id = $_POST['choice_option_id'];
		$optionDao = new OptionDAO();
		$option = $optionDao->getOptionByOptionId( $vote->getOptionId() );
		if( $option->getPollId() != $poll->getPollId() ){
			$errMsg ="請確認票選頁面是否正確。";
			$errMsgs[] = $errMsg;
			$isOk = false;  
		}
	}



	if( isset( $_POST['captcha_code'])){
		//include_once( $_SERVER['DOCUMENT_ROOT'] . 'myassets/lib/securimage/securimage.php' );
		include_once( 'myassets/lib/securimage/securimage.php');
		$securimage = new Securimage();
		if ($securimage->check($_POST['captcha_code']) == false) {
			$errMsg= "驗證碼有誤，請重新輸入。";
    		$errMsgs[] = $errMsg;
	  		$isOk= false;
		}
	}else{
		$errMsg = "請輸入驗證碼。";
		$errMsgs[] = $errMsg;
		$isOk=false; 
	}

	// submit one vote 
	if( $isOk ){
		$voteDao->insertVote( $vote ); 
		redirect_to( "success.php?poll_id=".$poll->getPollId() );
	}

	$pollDao->close();
	$voteDao->close();
}
?>

<?php require( "menu.php"); ?>
<div class="carousel slide">
	<div class="carousel-inner">
		<img class="logo" src="<?= logo_path( $poll->getImgFilenameOrDefault() ) ?>" >
		<div class="container">
			<div class="carousel-caption">
				<h1><?= $poll->getTitle() ?></h1>
			</div>
		</div>
	</div>
</div>

<div class="container">

	<div class="row">
		<span>
		<div class="span1">　</div>
		<div class="span10">
			<h3><?= $poll->getDescription() ?></h3><p>舉辦單位：<?= $poll->getDepartment() ?> </p>
			<p>開始時間：<?= $poll->getStartDate()->format('Y-m-d H:i') ?>&nbsp;&nbsp;&nbsp;&nbsp;
			截止時間：<?= $poll->getDueDate()->format('Y-m-d H:i') ?> </p>
		</div>
		<div class="span1">　</div>
	</div>
<?php
	if( count($errMsgs ) > 0 ){
		echo '<div class="row">';
		echo '<div class="span1"></div>';
		echo '<div class="span10 error">';
		foreach( $errMsgs as $errMsg ){
			echo '<p class="text-error">' . $errMsg . "</p>";
		}
		echo '</div>';
		echo '<div class="span1"></div>';
		echo '</div>';
	}

 ?>

<br> 

<div class="row">
	<div class="span1">　</div>
	<div class="span10">
		<form action="vote.php?poll_id=<?= $poll->getPollId() ?>" method="post">
			<input type="hidden" name="updating" value="1">
				<table class="table table-hover">
					<?php 
						$row_id= 0; 
						foreach( $poll->getOptions() as $option ){
							echo "<tr>";
							echo '	<td class="span1 controls table-radio"><input type="radio" id="choice_'.$row_id.'" name="choice_option_id" value='.$option->getOptionId().'></td>';
							echo '	<td class="span9 table-choice">';
							echo '		<label class="control-label" for="choice_'.$row_id.'">';
							echo '			<div class="table-img">';
							if( !is_null( $option->getImgFilename() ) ){
											echo '<img class="img-polaroid choice-img" src="'.option_path($option->getImgFilename()).'" ></img>';
							}
							echo '			</div>';
							echo '			<div class="table-caption"><p>'.$option->getDescription().'</p></div>';
							echo '		</label>';
							echo '	</td>';
							echo "</tr>";
							$row_id++; 
						}
					?>			
		
				</table>
				<center>
				<table class="table-condensed captcha" >
								<tr > 
									<td></td>
									<td><img id="captcha" src="myassets/lib/securimage/securimage_show.php" alt="CAPTCHA Image" />
									<a href="#" onclick="document.getElementById('captcha').src = 'myassets/lib/securimage/securimage_show.php?' + Math.random(); return false" class="btn btn-success"><i class="icon-refresh"></i></a></td>
								</tr>
								<tr>
									<td>請輸入驗證碼：</td>
									<td><input type="text" name="captcha_code" size="10" maxlength="6"/></td>
								</tr>
								</table>
								<?php
								/*
          							require_once('myassets/lib/recaptcha/recaptchalib.php');
          							$publickey = "6LeAneISAAAAAJh2QnABfvQ4hiIHyPZZRWged_k5"; // you got this from the signup page
          							echo recaptcha_get_html($publickey);
        						*/
        						?>
								<br><input type="submit" class="btn btn-large btn-primary" value="送出">
				</center>
		</form>
	</div>
	<div class="span1">　</div>
</div>

</div>


<?php require("bottom.php"); ?>