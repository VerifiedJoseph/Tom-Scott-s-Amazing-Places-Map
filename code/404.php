<?php

header("HTTP/1.0 404 Not Found");

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
		<title>Page Not Found - A Website By VerifiedJoseph</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
		<link rel="stylesheet" type="text/css" href="../css/style.css"/>
	</head>
	<body>
    <div class="container" id="main">   
		<div class="row e">
			<div class="col-md-12">
				<h4><a href="<?php echo $root_url; ?>">Back to the main page.</a></h4>
			</div>
		</div>
    </div>
	</body>
</html>