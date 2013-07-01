
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/vendor/jquery.ui.widget.js"></script>
	<script src="assets/js/jquery.iframe-transport.js"></script>
	<script src="assets/js/jquery.fileupload.js"></script>
	<script src="myassets/js/basic.js"></script>
	<?php 
		if( isset( $LOAD_JS_ARRAY )){
			foreach( $LOAD_JS_ARRAY as $js_file ){
				$js_filepath = "myassets/js/".$js_file;
				echo '<script src="'.$js_filepath.'"></script>';
			}
		}

		$js_filepath = "myassets/js/".$page.".js";
		if( file_exists( $js_filepath ) ){
			echo '<script src="'.$js_filepath.'"></script>' ;
		}

	?>
	<?php 
		if( isset( $LAST_CODE_BLOCK  ) ) {
			echo $LAST_CODE_BLOCK ; 
		}
	?>
</body>
</html>