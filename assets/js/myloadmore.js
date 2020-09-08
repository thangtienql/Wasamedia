// jQuery(function($){
//   $('#misha_loadmore').click(function(){
//
//       var button = $(this),
//           data = {
//             'action' : 'loadmore',
//             'query' : misha_loadmore_params.posts,
//             'page'  : misha_loadmore_params.current_page
//           };
//           console.log(misha_loadmore_params.ajaxurl);
//           $.ajax({
//             url: misha_loadmore_params.ajaxurl,
//             data : data,
//             type : 'POST',
//             beforeSend : function (xhr){
//                 button.text('Loading.........');
//             },
//             success : function(data){
//                 if(data){
//                     button.text('More Post').prev().before(data);
//                     misha_loadmore_params.current_page++;
//
//                     if(misha_loadmore_params.current_page == misha_loadmore_params.max_page)
//                         button.remove();
//                 }else {
//                   button.remove();
//                 }
//             }
//           });
//         });
// });

jQuery(function($){
	// we will remove the button and load its new copy with AJAX, that's why $('body').on()
	$('body').on('click', '#misha_loadmore', function(){
		$.ajax({
			url : misha_loadmore_params.ajaxurl,
			data : {
				'action': 'loadmore',
				'query': misha_loadmore_params.posts,
				'page' : misha_loadmore_params.current_page,
				'first_page' : misha_loadmore_params.first_page // here is the new parameter
			},
			type : 'POST',
			beforeSend : function ( xhr ) {
				$('#misha_loadmore').text('Loading...');
			},
			success : function( data ){

				$('#misha_loadmore').remove(); // remove button
				$('#misha_pagination').before(data).remove(); // add new posts and remove pagination links
				misha_loadmore_params.current_page++;


			}
		});
		return false;
	});
});
