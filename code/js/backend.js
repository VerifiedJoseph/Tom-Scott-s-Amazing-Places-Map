$(document).ready(function () {
	var markers = []; // Array of map markers  
	var loadMap = $("#map-container").attr("data-map-load");
	var url = $("#map-container").attr("data-url");
	
	$.ajaxSetup({dataType:'json'}); // set data type
	
	$.getJSON(url + "/file")
	
	.done(function(data) {
		console.log( "Video list fetched : true" );
		console.log(data);
		
		if(loadMap == 'false') {
			console.log( "Load Map : false ");
			$("#map-container").hide();	
		}
		
		videoGrid(data['videos']); // Create video gird
			
		$(".caption").dotdotdot({
			ellipsis: '... ',
			wrap: 'word',
			watch: "window"
		});
		
		$('.delete-label button, .delete-button').on('click', function () { // Confirm delete
			if(confirm("Are you sure you want to delete this video?")) {
				return true;
			} else {
				return false;
			}
		});
		
	})
	
	.fail(function() {
		$('#error-note').show();
		console.log( "Video list fetched : false" );
	});
		
	function videoGrid(videos) {
		
		// Add badge number 
		var bNum = Object.keys(videos).length;
		$('.badge').append(bNum);
		
		var marker, i;	
		for (i = 0; i < Object.keys(videos).length; i++) { // Loop through each video and add map marker and click event 

			var html = '<div class="col-sm-4 col-md-3 col-lg-2 video"><div class="thumbnail" data-map-id="' + i + '"><a href="?edit=' + i + '" class="btn btn-primary btn-xs edit-label">Edit</a><span class="delete-label"><form  method="post" action=""><input type="hidden" name="delete_video"/><input type="hidden" name="video_number" value="' + i + '"><input type="hidden" name="video_id" value="' + videos[i]['id'] + '"><button type="submit" class="btn btn-primary btn-xs" >Delete</button></form></span><img title="' + videos[i]['title'] + '" class="video-thumbnail" src="https://i.ytimg.com/vi_webp/' + videos[i]['id'] + '/mqdefault.webp" title="' + videos[i]['title'] + '"><div title="' + videos[i]['title'] + '" class="caption">' + videos[i]['title'] + '</div></div>';
				$(".video-box").append(html);
		}		
	}	
});