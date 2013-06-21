<?php
require_once("models.php");
require_once("utility.php");

$poll_id = $_GET['poll_id'];
$pollDao = new PollDAO();

$poll = $pollDao->getPollByPollId( $poll_id  ); 
// count vote 
$tmp_option_array = array();
foreach( $poll->getOptions() as $option ){

	$tmp_option_text = sprintf( '{"description" : "%s", "count": %d}' , $option->getDescription(), count( $option->getVotes() ) );
	$tmp_option_array[] = $tmp_option_text; 
}
$tmp_option_array_json = "[". join(" , ", $tmp_option_array ). "]";



echo '{';
echo '	"title": "'. $poll->getTitle().'", ';
echo '  "description" : "'. $poll->getDescription().'", ';
echo '	"options":'. $tmp_option_array_json ;
echo '}';

//$polls = $pollDao->getPollBeforeDatetime( new DateTime(null, new DateTimeZone('Asia/Taipei')) , $start, $length  ); 

/*
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
*/
?>