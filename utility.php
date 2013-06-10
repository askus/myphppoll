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

?>