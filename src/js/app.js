/*jslint node: true */
/*global jQuery, google */
"use strict";

jQuery(function ($) {
	var map,
		markers = [], // Array of map markers  
		infoWindow,
		url = $("#map-container").attr("data-url"),
		currentMarker = -1, // ID of the currently open info window (marker ID)
		mapCenter;

	function initialize(locations) { // Creates map and set map markers

		var marker, i,
			mapOptions = {
				center: new google.maps.LatLng('54.9000', '25.3167'),
				zoom: 4,
				maxZoom: 8,
				streetViewControl: false,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				mapTypeControl: false
			};

		map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

		infoWindow = new google.maps.InfoWindow();

		for (i = 0; i < Object.keys(locations).length; i++) { // Loop through each video and add map marker and click event 

			marker = new google.maps.Marker({
				position: new google.maps.LatLng(locations[i].lat, locations[i].long),
				map: map,
				title: locations[i].title
			});

			google.maps.event.addListener(marker, 'click', (function (marker, i) {
				return function () {
					// infoWindow content
					var content = '<div class="map-video"><iframe src="https://www.youtube.com/embed/' + locations[i].id + '" frameborder="0" allowfullscreen></iframe></div>';

					currentMarker = i;
					console.log(currentMarker);

					infoWindow.setContent(content);
					infoWindow.open(map, marker);

				};
			})(marker, i));

			markers.push(marker); // Add arrays together

		}

		mapCenter = map.getCenter();

	}

	function videoClick(markerID) { // Map marker click event
		google.maps.event.trigger(markers[markerID], 'click');
	}

	function videoGrid(videos) { // Creates page video grid

		var marker,
			html,
			i;

		// Add badge number 
		$('.badge').append(Object.keys(videos).length);

		for (i = 0; i < Object.keys(videos).length; i++) { // Loop through each video and add map marker and click event 

			html = '<div class="col-sm-4 col-md-3 col-lg-2 video"><div class="thumbnail" data-map-id="' + i + '"><img title="' + videos[i].title + '" class="video-thumbnail" src="https://i.ytimg.com/vi/' + videos[i].id + '/mqdefault.jpg" title="' + videos[i].title + '"><div title="' + videos[i].title + '" class="caption"><span>' + videos[i].title + '</span></div></div>';
			$(".video-box").append(html);
		}
	}

	$.ajaxSetup({
		dataType: 'json' // Set data type
	});

	$.getJSON("/GitHub/Tom-Scott-s-Amazing-Places-Map/src/videos.json")

		.done(function (data) {
			console.log("Fetched Video list");
			//console.log(data);

			google.maps.event.addDomListener(window, 'load', initialize(data.videos)); // 

			// Create video gird
			videoGrid(data.videos);

			$(".caption").dotdotdot({
				ellipsis: '... ',
				wrap: 'word',
				watch: "window"
			});

			$('.thumbnail').on('click', function () { // Show map marker 
				var markerID = $(this).attr("data-map-id");
				videoClick(markerID);

				$("body,html").animate({
					scrollTop: 0
				}, 800);
			});

			google.maps.event.addDomListener(window, "resize", function () { // On window resize and center map and reopen current open info window
				map.setCenter(mapCenter);

				console.log("current #" + currentMarker);

				if (currentMarker !== -1) {
					var beforeCloseNumber = currentMarker; // Backup currentMarker as infoWindow.close(); clears it 
					infoWindow.close();

					currentMarker = beforeCloseNumber; // Set currentMarker again

					setTimeout( // Open the info window after a 500ms wait 
						function () {
							google.maps.event.trigger(markers[currentMarker], 'click');
						}, 500
					);

				}
			});

			google.maps.event.addListener(infoWindow, 'closeclick', function () { // On infoWindow close
				currentMarker = -1; // Set currentMarker
			});

		})

		.fail(function () { // JSON file failed to load 
			$('#error-note').show();
			console.log("Video list fetched : false");
		});


});