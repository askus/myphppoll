
<?php 
$id= $_GET['id'];
$page_title ="社會局票選系統";
$page = "vote";

if( isset($_POST["recaptcha_challenge_field"]) ){
require_once('myassets/lib/recaptcha/recaptchalib.php');
  $privatekey = "6LeAneISAAAAAHiTJDo03tDNonmOecBfTizlcxG7";
  $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);



  if (!$resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly
    die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
         "(reCAPTCHA said: " . $resp->error . ")");
  } else {
    // Your code here to handle a successful verification
  	//echo "GOOD!";
  }
}
?>


<?php require( "menu.php"); ?>
<div class="carousel slide">
	<img class="logo" src="myassets/img/1.jpg" >
	<div class="container">
		<div class="carousel-caption">
			<h1>婦少科LOGO票選</h1>
		</div>
	</div>
</div>

<div class="container">

	<div class="row">
		<span>
		<div class="span1">　</div>
		<!-- <div class="span2"><img class="img-circle" src="myassets/img/depart-3.png"></div> -->
		<div class="span10"><h3>因為前途還是不減啟程時的渺茫，可愛，他會拉，小書你媽曾經件件的指給我看，扮一個漁翁
參與投票</h3><p>舉辦單位：婦少科</p></div>

		<div class="span1">　</div>
	</div>



<div class="row">
	<div class="span1">　</div>
	<div class="span10">

		<form action="vote.php" method="post">
				<table class="table">
					<tr>
						<td class="table-radio"><input type="radio" name="choice" value=0> </td>
						<td class="table-choice">
							<div class="img"><img class="img-circle" src="myassets/img/options/option.png"></div>
							<div class="caption">選我選我選項</div>
						</td>		
					</tr>
					<tr>
						<td class="table-radio"> <input type="radio" name="choice" value=1> </td>
						<td class="table-choice">
							<div class="img"><img class="img-circle" src="myassets/img/options/option.png"></div>
							<div class="caption">選我選我選項</div>
						</td>			
					</tr>
					<tr>
						<td class="table-radio"> <input type="radio" name="choice" value=2> </td>
						<td class="table-choice">
							<div class="img"><img class="img-circle" src="myassets/img/options/option.png"></div>
							<div class="caption">選我選我選項</div>
						</td>				
					</tr>
					<tr>
						<td class="table-radio"> <input type="radio" name="choice" value=3> </td>
						
						<td class="table-choice">
							<div class="img"><img class="img-circle" src="myassets/img/options/option.png"></div>
							<div class="caption">選我選我選項</div>
						</td>				
					</tr>					
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