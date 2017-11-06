/*jslint node: true */
/*global jQuery, google */
"use strict";

jQuery(function ($) {
	
	var map,
		markers = [], // Array of map markers 
		infoWindow;

	/**
	* Create a map from the JSON data
	* @param {object} locations
	*/
	function initMap(locations) { // Creates map and set map markers

		var marker, i,
			mapOptions = { // Map Options
				center: new google.maps.LatLng('54.9000', '25.3167'), // Default map location
				zoom: 4, // Default zoom
				maxZoom: 11,
				streetViewControl: false,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				mapTypeControl: false
			};
		
		// New map
		map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

		// New infoWindow
		infoWindow = new google.maps.InfoWindow();

		// Loop through each video, adding a map markers and click events
		for (i = 0; i < Object.keys(locations).length; i += 1) {

			// New marker
			marker = new google.maps.Marker({
				position: new google.maps.LatLng(locations[i].lat, locations[i].long),
				map: map,
				title: locations[i].title
			});

			// Marker click event listener
			google.maps.event.addListener(marker, 'click', (function (marker, i) {
				return function () {
					
					// info window content
					var content = '<div class="map-video"><iframe src="https://www.youtube.com/embed/' + locations[i].id + '" frameborder="0" allowfullscreen></iframe></div>';
					
					infoWindow.setContent(content);
					infoWindow.open(map, marker);
				};
			})(marker, i));
			
			// Add maker to map markers array
			markers.push(marker);

		}

	}

	/**
	* Create a grid showing all the videos from JSON
	* @param {object} videos
	*/
	function videoGrid(videos) {

		var html,
			i;

		// Loop through each video and add it to the grid
		for (i = 0; i < Object.keys(videos).length; i += 1) {

			// http://shoelace.io/#7084dfaae9239b22106fd5d7ca503f17
			html = '<div class="col-xs-6 col-sm-4 col-lg-2 video"><div class="thumbnail" data-map-id="' + i + '">'
				+ '<img title="' + videos[i].title + '" class="video-thumbnail" src="https://i.ytimg.com/vi/' + videos[i].id + '/mqdefault.jpg" title="' + videos[i].title + '">' // Small screens
				+ '<div title="' + videos[i].title + '" class="caption"><span>' + videos[i].title + '</span></div></div>';
			$(".video-box").append(html);
		}
	}

	/**
	* Ajax Setup
	*/
	$.ajaxSetup({
		dataType: 'json' // Set data type
	});
	
	/*
		Run request
	*/
	$.getJSON("videos.json")

		.done(function (data) {
			console.log("Fetched video list");

			// Add badge number 
			$('.badge').append(Object.keys(data.videos).length);
		
			// Create Map
			initMap(data.videos);

			// Create video gird
			videoGrid(data.videos);

			// Hide overflow text
			$(".caption").dotdotdot({
				ellipsis: '... ',
				wrap: 'word',
				watch: "window"
			});
		
			// Thumbanil click event (open info window for video on map)
			$('.thumbnail').on('click', function () {
				
				var markerID = $(this).attr("data-map-id");
				
				// Trigger marker event
				google.maps.event.trigger(markers[markerID], 'click');
				
				// Scroll to page top.
				$("body,html").animate({
					scrollTop: 0
				}, 800);
			});
			
			// Hide loading screen on map load.
			google.maps.event.addListenerOnce(map, 'idle', function () {
				$('#loading').fadeOut('slow');
			});
		
		})

		.fail(function () {
			$('#error-note').show();
			$('#loading').fadeOut('slow');
			console.log("Failed to fetch video list");
		});

});
