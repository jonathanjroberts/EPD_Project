<?php
	// *************************
	// 	Project Default Global Includes
	// *************************
	
	
	// Web Server Public Root Directory
		include ('connectEPD.php');						// DB Connection
		include ('routes.php');							// Project Routing File
		include ('getBreadcrumbLink.php');				// Links for Breadcrumbs
		include ('breadcrumbs.php');					// Breadcrumbs
		
	// Helper Functions
		include ('getCurrentListForValue.php');			// Pulling in Dependent List Items
		
	// Account Functions
		include ('secret/settings2.php');				// Get Private Encryption Key
		include ('verify.php');							// Account Verification - Catch
		
	// Query Functions
		include ('performSQLQuery.php');	
		
	
?>