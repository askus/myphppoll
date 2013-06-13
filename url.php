<?php 
	$LOGO_DIR = "myassets/img/logo/"; 
	$OPTION_DIR = "myassets/img/option/";
	function logo_path( $logo_filename ){
		global $LOGO_DIR;
	 	return sprintf( '%s%s', $LOGO_DIR, $logo_filename ) ;
	}

	function option_path( $option_filename ){
		global $OPTION_DIR;
		return sprintf( '%s%s', $OPTION_DIR, $option_filename);
	}
?>