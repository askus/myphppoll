function update_poll(  ){
	var start = g_start;
	var length = g_length ;

	if( g_start < 0 ){return 0;}

	//console.log( g_start );

	$(".img-loader").show();
	$.get( "fetch_poll.php",{ start: start, length : length } ,
		function( data ){
			data = $.parseJSON( data );

			if( data.length < g_length ){
				g_start = -1 ;
				g_length = 0 ;
			}else{
				g_start += g_length ;
			}

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



var g_start= 0;
var g_length =6; 

update_poll( );


var is_loading =false;
$(window).scroll(function() {
    if($(window).scrollTop() + $(window).height() > $(document).height() - 10) {

 
           // ajax call get data from server and append to the div
        	$(window).unbind('scroll');
        	if( !is_loading){
        		is_loading =true;
    			update_poll();
    			is_loading = false;
    		}
    		$(window).bind('scroll', update_poll);
    }
});


/*
$(document).ready( function(){
	console.log("Hello Test");
	update_poll( 0, 6 );
});
*/