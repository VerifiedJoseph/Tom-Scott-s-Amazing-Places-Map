<?php

include 'config.php';
include 'classes/admin_class.php';
	
	$admin = new admin();
	
	$messages = array();
	$channel_id = 'UCBa659QWEk1AI4Tg--mrJ2A'; // Channel ID
	
	// Get File 
	if(!file_exists('gs://#default#/locations.json')) { // Check if file exists
		$messages[] = "locations.json file not found.";
		$current_file ="locations.json file not found.";
	} else {
		// Fetch theme details file (details.json)
		$current_file = file_get_contents($root_url . '/file');
	}	
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Tom Scott's Amazing Places - A Website By VerifiedJoseph</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
		<link rel="stylesheet" type="text/css" href="../css/style.css"/>
	</head>
	<body>
    <div class="container" id="main">   
		<div class="row e">
			<div class="col-md-12">
				<h4>Admin Panel</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div id="map-container" data-map-load="false" data-url="<?php echo $root_url; ?>">
					<div id="error-note">
						<div class="alert alert-dismissible alert-danger">
							<span title="Technobabble from scifiideas.com/technobabble-generator"><strong>Oh snap!</strong> The supersonic pulse   reactor has uncoupled from the shift compressor.</span>
							<h6>In english please?? locations.json failed to load, press F5 to reload the page and try agin.</h6>
						</div>
					</div>
					<div id="map-canvas"></div>
				</div>
			</div>
		</div>	  
		
		<div class="row">
			<div class="col-md-12">
			<?php 		
				if(count($admin->messages) > 0) { // Check number of elements
					// Loop through each message
					foreach ($admin->messages As $msg) {
						echo '<div id="error-note1"><div class="alert alert-danger">' . $msg . '</div></div>';
					}
				}
			?>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-4">
				<h2>Add Video</h2>
				<form class="form-horizontal" method="post" action="" name="video">
					<fieldset>
						<input type="hidden" name="add_video"/>
						<div class="form-group">
							<label class="col-lg-3 control-label">Title</label>
							<div class="col-lg-9">
								<input type="text" class="form-control" name="title" placeholder="Video Title">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label">ID</label>
							<div class="col-lg-9">
								<input type="text" class="form-control" name="id" placeholder="Video ID">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label">Latitude</label>
							<div class="col-lg-9">
								<input type="text" class="form-control" name="lat" placeholder="Latitude">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label">Longitude</label>
							<div class="col-lg-9">
								<input type="text" class="form-control" name="long" placeholder="Longitude">
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-12 col-lg-offset-2">
								<button type="submit" class="btn btn-primary">Submit</button>
								<button type="reset" class="btn btn-default">Cancel</button>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
			
			<div class="col-md-4">
				<h2>Edit Video
				</h2>
				<form class="form-horizontal" method="post" action="" name="video">
					<fieldset>
						<input type="hidden" name="update_video"/>
						<input type="hidden" name="video_number" value="<?php echo $admin->edit_info['number']; ?>"/>
						<div class="form-group">
							<label class="col-lg-3 control-label">Title</label>
							<div class="col-lg-9">
								<input type="text" class="form-control" name="title" value="<?php echo $admin->edit_info['title']; ?>" placeholder="Video Title" <?php echo $admin->edit_info_disabled; ?>/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label">ID</label>
							<div class="col-lg-9">
								<input type="text" title="Video ID can not be changed." class="form-control" name="id" value="<?php echo $admin->edit_info['id']; ?>" placeholder="Video ID" disabled/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label">Latitude</label>
							<div class="col-lg-9">
								<input type="text" class="form-control" name="lat" value="<?php echo $admin->edit_info['lat']; ?>" placeholder="Latitude" <?php echo $admin->edit_info_disabled; ?>/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label">Longitude</label>
							<div class="col-lg-9">
								<input type="text" class="form-control" name="long" value="<?php echo $admin->edit_info['long']; ?>" placeholder="Longitude" <?php echo $admin->edit_info_disabled; ?>/>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-10 col-lg-offset-2">
								<button type="submit" class="btn btn-primary" <?php echo $admin->edit_info_disabled; ?>>Submit</button>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
			
			<div class="col-md-4">
				<h2>Edit File</h2>
				<form class="form-horizontal" method="post" action="" name="video">
					<fieldset>
						<input type="hidden" name="update_file"/>
						<div class="form-group">
							<div class="col-lg-9">
								<textarea class="form-control" name="file" rows="10" id="textArea"><?php echo $current_file; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-10 col-lg-offset-2">
								<button type="submit" class="btn btn-primary">Submit</button>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<div class="pull-left">
					<h2>Videos <span class="badge"></span></h2>
				</div>
				<!--<div class="pull-left video-btn">
					<span class="btn btn-primary">Toggle Videos</span>
				</div>-->
			</div>
		</div>	
		
		<div class="row video-box">
            <!--<div class="col-md-2 col-sm-4 col-xs-12 video">
              <div class="thumbnail">
                <img src="https://i.ytimg.com/vi_webp//mqdefault.webp" alt="The Human-Powered Theme Park">
                <div class="caption">The Giant Cranes and Robots That Keep Civilisation Running</div>
              </div>
            </div>-->
		</div>		
    </div>
		<script src="../js/jquery-2.2.0.min.js"></script>
		<script src="../js/jquery.dotdotdot.min.js"></script>
		<script src="../js/backend.js"></script>
		<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $map_key; ?>"></script>
	</body>
</html>