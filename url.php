<?php 
	$LOGO_DIR = "myassets/img/logo/"; 
	function logo_path( $logo_filename ){
		global $LOGO_DIR;
	 	return sprintf( '%s%s', $LOGO_DIR, $logo_filename ) ;
	}
?>