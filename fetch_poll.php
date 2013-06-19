<?php
require_once("models.php");

$start = $_GET['start'];
$length = $_GET['length'];

$pollDao = new PollDAO();

$polls = $pollDao->getPollBeforeDatetime( new DateTime(null, new DateTimeZone('Asia/Taipei')) , $start, $length  ); 

echo "[";
$is_first = true ;

foreach( $polls as $poll ){
	if( ! $is_first ){
		echo ",";	
	}else{
		$is_first = false;
	}
	echo "{";
		echo "\"title\": \"". $poll->getTitle()."\", ";
		echo "\"description\": \"". $poll->getDescription()."\", ";
		echo "\"department\": \"". $poll->getDepartment()."\",";
		echo "\"poll_id\": ". $poll->getPollId() .", ";
		echo "\"img_filename\": \"".$poll->getImgFilenameOrDefault()."\"";
	echo "}";
}
echo "]";
?>