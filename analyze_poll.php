<?php 
$page_title ="分析投票";
$page = "admin";


require_once( 'utility.php');
require_once( 'models.php');
require_once( 'url.php');

check_login();
$poll_id = $_POST['poll_id'];
$user = $_SESSION['user']; 

// check user_id
$pollDao = new PollDAO();
$poll = $pollDao->getPollBy 

?>

<?php require("bottom.php"); ?>
