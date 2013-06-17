<?php 
	function short_text( $name,  $value, $size=1 ){
		return '<input class="span'.$size.'" type="text" name="'.$name.'" value="'.$value.'"></input>';
	}
	function long_text( $name, $value, $size=5, $row=5 ){
		return '<textarea class="span'.$size.'" rows='.$row.' name="'.$name.'">'.$value.'</textarea>'; 
	}

	function datetime( $name, $value ){
		return sprintf( "%s年%s月%s日  %s時%s分%s秒", 
		short_text( $name."[Y]", date_format( $value, "Y" )),
		short_text( $name."[m]", date_format( $value, "m" )),
		short_text( $name."[d]", date_format( $value, "d" )),
		short_text( $name."[H]", date_format( $value, "H" )),
		short_text( $name."[i]", date_format( $value, "i" )),
		short_text( $name."[s]", date_format( $value, "s" )) );
	}

	function concate_datetime( $date_var ){
		return	new DateTime(sprintf("%s-%s-%s %s:%s:%s", $date_var['Y'], $date_var['m'],  $date_var['d'],  $date_var['H'],  $date_var['i'],  $date_var['s']) ); 

	}
	function hidden( $name, $value ){
		return "<input type='hidden' name='".$name."' value='".$value."'>";
	}

	//function uploadFile( )
?>