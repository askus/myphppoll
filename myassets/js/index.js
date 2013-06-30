function update_poll( start, length ){
	$(".img-loader").show();
	$.get( "fetch_poll.php",{ start: start, length : length } ,
		function( data ){
			console.log(data );
			data = $.parseJSON( data );
			console.log( data);

			var html_text ="";
			for( var i = 0 ;i < data.length; i++ ){
				if( i % 3 == 0 ){
					html_text += '<div class="row">';
				}
				var block_html= '<div class="span4"><img class="img-circle" src="myassets/img/logo/'+data[i].img_filename+'"><h2>'+data[i].title+'</h2><p>'+data[i].description+'</p><p><a class="btn" href="vote.php?poll_id='+data[i].poll_id+'">前往投票</a></p></div>'
				html_text += block_html ;

				if( i%3 == (3-1) || i == data.length-1  ){
					html_text += '</div>';
				}
			}	
			$(".marketing .img-loader").before( html_text);
			$(".img-loader").hide();
		} 
	); 
}



$(document).ready( function(){
	console.log("Hello Test");
	update_poll( 0, 6 );
});