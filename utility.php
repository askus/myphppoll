<?php

function redirect_to( $url ){
	header( sprintf( "Location: %s", $url )  );
}

function is_login( ){
	session_start();
	return isset( $_SESSION['user']);
}

function check_login(){
	if( !is_login() ){
		redirect_to('login.php');
	}
}


function format_datetime( $dt ){
	return date_format($dt , 'Y-m-d H:i:s');
}

function trim_str( $str, $max_len){
	if( mb_strlen($str)> $max_len ){
		return mb_substr( $str, 0, $max_len, "utf8") ."...";
	}
	return $str;
}

?>