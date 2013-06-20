<?php
	$allowedExts = array("gif", "jpeg", "jpg", "png");

	function check_upload_img( $file , $errMsg){
		global $allowedExts; 
		$retCheckCode = 1;
		$extension = end(explode(".", $file["name"]));

		if( is_null( $file) ){
			$retCheckCode = 0;
			return $retCheckCode;
		}

		if ((($file["type"] == "image/gif")
			|| ($file["type"] == "image/jpeg")
			|| ($file["type"] == "image/jpg")
			|| ($file["type"] == "image/pjpeg")
			|| ($file["type"] == "image/x-png")
			|| ($file["type"] == "image/png"))
			&& ($file["size"] < 5000000)
			&& in_array($extension, $allowedExts)){
			
			if ($file["error"] > 0){
				$errMsg = $file; 
				$retCheckCode =0;
			}
  		}else{
  			$errMsg = "Invalid file";
			$retCheckCode =0;
  		}
  		//echo '<h1>'.$retCheckCode.'</h1> <h2>'.$errMsg.'</h2>';
  		return $retCheckCode;
	}
	function move_to_place( $file , $url_prefix , $filename_prefix ){

		$extension = end(explode(".", $file["name"]));
		$new_filename = sprintf("%s.%s", $filename_prefix, $extension );
		$new_filepath = sprintf("%s/%s", $url_prefix, $new_filename );
		move_uploaded_file( $file["tmp_name"], $new_filepath );

		return $new_filename ;
	}


?>