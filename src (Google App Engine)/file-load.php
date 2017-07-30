<?php
	
	$file = file_get_contents('gs://#default#/locations.json');
	
	//header('Content-Type: application/json');
	echo $file;
?>