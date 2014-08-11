<?php
	// *************************
	// 	Project Routes File
	// *************************
	
	// Get Info about Native Server/URL/Directory Path
		include ('getRouteStartFromServerPath.php');			// Find Where to Start Folder Structure for User
		
	// Web Server Public Root Directory
		$base_url = "http://localhost/PMBA/EPD/public";			// Unseen Server Directory Stucture, Construct of Pre-Build Links
		$base_directory = "Public";								// Root Directory for Users (breadcrumbs, getting route positions)

	// Get Info about User's Current Route State	
		include ('getCurrentRoutePositionFromRouteStart.php');	// Determines how many "../" to use for Sub Directories
		include ('getCurrentQueryString.php');					// Get the User's Current Query String
		
		
	
	// Breadcrumb Function -> Path Inputs
		$homePageFileName = "dashboard.php";
		$homePageCrumbName = "EPD";
		$commonProjectGETRoute = array('area_id','section_id');
		//$count = count($commonProjectGETRoute);
			$queryString = getCurrentQueryString($commonProjectGETRoute);
		
	
		// Get Route Start Ordinal From Server Path
			$crumbRouteStartPosition = getRouteStartFromServerPath($base_directory);
			// $crumbRouteStartPosition = 3; // Ignoring: PMBA/EPD/Public directories
	
?>