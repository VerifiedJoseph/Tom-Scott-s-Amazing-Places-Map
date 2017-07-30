<?php

	class admin {
		
		public $messages = array();
		public $edit_info = false;
		public $edit_info_disabled = 'disabled';
		
		public function __construct() { // Automatically starts when an object of this class is created
		
			if(isset($_POST['add_video'])) {
				$this->add_video();

			} else if(isset($_POST['update_file'])) {
				$this->update_file();

			} else if(isset($_POST['update_video'])) {
				$this->update_video();

			} else if(isset($_POST['delete_video'])) {
				$this->delete_video();

			}

			if(isset($_GET['edit'])) {
				$this->fetch();	
			}
		}
		
		private function add_video() {
			global $root_url, $file_root, $yt_api_key, $channel_id;
			
			if(empty($_POST['title'])) { // If email is empty
				$this->messages[] = "Title field is empty.";

			} elseif(empty($_POST['id'])) {
				$this->messages[] = "ID field is empty.";

			} elseif(empty($_POST['lat'])) {
				$this->messages[] = "Latitude field is empty.";

			} elseif(empty($_POST['long'])) {
				$this->messages[] = "Longitude field is empty.";

			} else {
			
				if(!file_exists($file_root)) { // Check if file exists
					$this->messages[] = "locations.json file not found.";
				
				} else {
					$file = file_get_contents($root_url . '/file');
					$file = json_decode($file,true); // Decode JOSN				
	
					$title = strip_tags($_POST['title']);
					$video = strip_tags($_POST['id']);
					$lat = strip_tags($_POST['lat']);
					$long = strip_tags($_POST['long']);

					// Check if the video exists (YouTube API)
					$file_get_url = "https://www.googleapis.com/youtube/v3/videos?id=". $video  ."&part=snippet&key=" . $yt_api_key;
					$content = file_get_contents($file_get_url, false);
					
					if (strpos($http_response_header[0], "200")) { // Check HTTP code 
						$data = json_decode($content, true);
					
						if($data['pageInfo']['totalResults'] == '1') {
							if($data['items'][0]['snippet']['channelId'] == $channel_id){
							
								// Update Last mod date 
								$file['details']['last_mod'] = date('Y-m-d');
	
								// Add video to the file 
								$new_video = array(
									'title' => $title,
									'id' =>	$video,
									'lat' => $lat,
									'long' => $long,
									'added' => date('Y-m-d'),
								);
							
								array_unshift($file['videos'], $new_video);
							
								// Encode to JOSN
								$file = json_encode($file);
							
								// Add to the file 
								$options = ['gs' => ['Content-Type' => 'text/plain','enable_cache' => false]];
								$ctx = stream_context_create($options);
								if(file_put_contents($file_root, $file, 0, $ctx)) {
									$this->messages[] = 'Video (' . $title . ') was added.';
								}
							
							} else {
								$this->messages[] = "YouTube API : Wrong Channel";						
							}
						} else {
							$this->messages[] = "YouTube API : Video not found ";
						}
					} else {
						$this->messages[] = "YouTube API Error (" . $http_response_header[0] . ")";		
					}
				}
			}
			
		}
		
		private function update_file() {
			global $root_url, $file_root;
			
			if(empty($_POST['file'])) {
				$this->messages[] = "File Text box is empty.";			
				
			} else {
				if(file_put_contents($file_root, $_POST['file'])) {
					$this->messages[] = "File updated.";
				}
			}
			
		}
		
		private function update_video() {
			global $root_url, $file_root;
			
			if(empty($_POST['title'])) { // If email is empty
				$this->messages[] = "Title field is empty.";

			} elseif(empty($_POST['lat'])) {
				$this->messages[] = "Latitude field is empty.";

			} elseif(empty($_POST['long'])) {
				$this->messages[] = "Longitude field is empty.";

			} else {
			
				if(!file_exists($file_root)) { // Check if file exists
					$this->messages[] = "locations.json file not found.";
				
				} else {
					$file = file_get_contents($root_url . '/file');
					$file = json_decode($file,true); // Decode JOSN				
	
					$video_num = preg_replace('#[^0-9]#', '', $_POST['video_number']);
					
					$title = strip_tags($_POST['title']);
					$lat = strip_tags($_POST['lat']);
					$long = strip_tags($_POST['long']);
				
					if (!is_numeric($video_num)) {
						$this->messages[] = "Invaild video number.";
				
					} else {
						if(!isset($file['videos'][$video_num])){
							$this->messages[] = "Video not found.";	
							
						} else {
							// Update Last mod date 
							$file['details']['last_mod'] = date('Y-m-d');
							
							// Update data
							$file['videos'][$video_num]['title'] = $title;
							$file['videos'][$video_num]['lat'] = $lat;
							$file['videos'][$video_num]['long'] = $long;
							
							// Encode to JOSN
							$file = json_encode($file);
	
							// Update the file 
							$options = ['gs' => ['Content-Type' => 'text/plain','enable_cache' => false]];
							$ctx = stream_context_create($options);
					
							if(file_put_contents($file_root, $file, 0, $ctx)) {
								$this->messages[] = 'Video (' . $title . ') was updated.';
							}
						}
					}	
				}
			}
			
		}
		
		private function delete_video() {
			global $root_url, $file_root;
			
			if(empty($_POST['video_id'])) { // If email is empty
				$this->messages[] = "-";

			} elseif(!isset($_POST['video_number'])) {
				$this->messages[] = "--";

			} else {
				
				if(!file_exists($file_root)) { // Check if file exists
					$this->messages[] = "locations.json file not found.";
				
				} else {
					$file = file_get_contents($root_url . '/file');
					$file = json_decode($file,true); // Decode JOSN	
				
					$n = 0;
					$remove = false;
					foreach($file['videos'] As $vid) {
						
						if($vid['id'] == $_POST['video_id'] AND $n == $_POST['video_number']){
							$title = $file['videos'][$n]['title'];
							
							unset($file['videos'][$n]);
							
							$file['videos'] = array_values($file['videos'])	;
							$removed = true;
							break;
						}
						
						$n++;
					}
					
					if($removed == true) {
						// Encode to JOSN
						$file = json_encode($file);
	
						// Update the file 
						$options = ['gs' => ['Content-Type' => 'text/plain','enable_cache' => false]];
						$ctx = stream_context_create($options);
					
						if(file_put_contents($file_root, $file, 0, $ctx)) {
							$this->messages[] = 'Video (' . $title . ') was Removed.';
						}	
					}
				}
			}
			
		} 
		
		private function fetch() {
			global $root_url, $file_root;		
			
			if(!isset($_GET['edit'])) { // If email is empty
				$this->messages[] = "Invaild video number.";

			} else {				
				$video_num = preg_replace('#[^0-9]#', '', $_GET['edit']);
				
				if (!is_numeric($video_num)) {
					$this->messages[] = "Invaild video number.";
				
				} else {
					if(!file_exists($file_root)) { // Check if file exists
						$this->messages[] = "locations.json file not found.";
				
					} else {
						$file = file_get_contents($root_url . '/file');
						$file = json_decode($file,true); // Decode JOSN
						
						if(isset($file['videos'][$video_num])){
							$this->edit_info = $file['videos'][$video_num];
							$this->edit_info['number'] = $video_num;
							$this->edit_info_disabled = '';
						} else {
							$this->messages[] = "Video not found.";						
							
						}
					}
				}
			}
		}
	
	}