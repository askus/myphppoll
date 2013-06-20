<?php
	require_once('utility.php');
	session_start();
	session_destroy();
	redirect_to('index.php');

?>