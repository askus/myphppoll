<?php 
	$LOGO_DIR = "myassets/img/logo/"; 
	$OPTION_DIR = "myassets/img/option/";
	$IMG_DIR = "myassets/img/";
	function logo_path( $logo_filename ){
		global $LOGO_DIR;
	 	return sprintf( '%s%s', $LOGO_DIR, $logo_filename ) ;
	}

	function option_path( $option_filename ){
		global $OPTION_DIR;
		return sprintf( '%s%s', $OPTION_DIR, $option_filename);
	}
	function img_path( $filename ){
		global $IMG_DIR;
		return sprintf('%s%s', $IMG_DIR, $filename );
	}
?>