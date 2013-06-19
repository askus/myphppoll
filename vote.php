
<?php 
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

//error handling
$errMsgs = array();

if( isset($_POST['updating']) && $_POST['updating'] == 1 ) {
	$isOk = true ;
	if( !isset($_POST['choice_option_id']) || is_null($_POST['choice_option_id'])  ) {
		$errMsg ="請選擇一個選項。";
		$errMsgs[] = $errMsg;
		$isOk = false; 
	}else{
		$choice_option_id = $_POST['choice_option_id'];
		$optionDao = new OptionDAO();
		$option = $optionDao->getOptionByOptionId( $choice_option_id );
		if( $option->getPollId() != $poll->getPollId() ){
			$errMsg ="請確認票選頁面是否正確。";
			$errMsgs[] = $errMsg;
			$isOk = false;  
		}
	}

	$voteDao = new VoteDAO();
	$ip = $_SERVER['REMOTE_ADDR']; 
	$lastVotes = $voteDao->getVoteByIpAndPollId( $ip, $poll->getPollId() );
	// the user cannot vote again in the time interval 
	if( count( $lastVotes )>1 && ($lastVotes[0]->getLastVote()  - time() ) < $VOTE_INTERVAL * 60 * 60    ) {
		redirect_to("error.php?errMsgId=0");
	}
	if( isset($_POST["recaptcha_challenge_field"]) ){
			require_once('myassets/lib/recaptcha/recaptchalib.php');
			$privatekey = "6LeAneISAAAAAHiTJDo03tDNonmOecBfTizlcxG7";
			$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
  			if (!$resp->is_valid) {
    			$errMsg= "驗證碼有誤，請重新輸入。";
    			$errMsgs[] = $errMsg;
	  			$isOk= false;
	  		}
		}
	// submit one vote 
	if( $isOk ){
		
	}
}
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

<div class="container">

	<div class="row">
		<span>
		<div class="span1">　</div>
		<div class="span10"><h3><?= $poll->getDescription() ?></h3><p>舉辦單位：<?= $poll->getDepartment() ?> </p></div>
		<div class="span1">　</div>
	</div>
<?php
	if( count($errMsgs ) > 1 ){
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


<div class="row">
	<div class="span1">　</div>
	<div class="span10">
		<form action="vote.php?poll_id=<?= $poll->getPollId() ?>" method="post">
			<input type="hidden" name="updating" value="1">
				<table class="table">
					<?php 
						$row_id= 0; 
						foreach( $poll->getOptions() as $option ){
							echo "<tr>";
							echo '	<td class="controls table-radio"><input type="radio" id="choice_'.$row_id.'" name="choice_option_id" value='.$option->getOptionId().'></td>';
							echo '	<td class="table-choice">';
							echo '		<label class="control-label" for="choice_'.$row_id.'">';
							echo '			<div class="img">';
							if( !is_null( $option->getImgFilename() ) ){
											echo '<img class="img-polaroid" src="'.option_path($option->getImgFilename()).'"></div>';
							}
							echo '			</div>';
							echo '			<div class="caption">'.$option->getDescription().'</div>';
							echo '		</label>';
							echo '	</td>';
							echo "</tr>";
							$row_id++; 
						}
					?>			
					<tr>
						<td colspan="2">
							<center>
								<?php
          							require_once('myassets/lib/recaptcha/recaptchalib.php');
          							$publickey = "6LeAneISAAAAAJh2QnABfvQ4hiIHyPZZRWged_k5"; // you got this from the signup page
          							echo recaptcha_get_html($publickey);
        						?>
								<input type="submit" class="btn btn-large btn-primary">
							</center>
						</td>
					</tr>
				</table>
		</form>
	</div>
	<div class="span1">　</div>
</div>

</div>


<?php require("bottom.php"); ?>