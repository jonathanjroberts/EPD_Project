<html>

<head>
	<title>Admin > Menu > Module Table > Change Active Status </title>
</head>

<body>

<body>

<!-- http://localhost/PMBA/EPD/public/admin/module/activate_or_inactivate.php -->

<br /> <h2> Admin > Menu > Module Table > Change Active Status </h2> <hr />

<!-- Start: Global Include Files -->
<?php
	include('../../UtilityIncludes/globalIncludes.php');
?>
<!-- End: Global Include Files -->

<?php
	// Link Back to Admin Menu > Area 
	echo "<br /><a href='$base_url/admin/module/list.php'>Return to Admin Module List</a><br />";
	
	// Link Back to Admin Menu
	echo "<br /><a href='$base_url/admin/default.php'>Return to Admin Menu</a><br />";
	
	// Link Back to Dashboard
	echo "<br /><a href='$base_url/dashboard.php'>Return to Dashboard</a><br />";
	echo "<br /><br />";

	// Toggle Breadcrumbs
	echo breadcrumbs($base_url,$homePageFileName,$homePageCrumbName,$queryString,$crumbRouteStartPosition,0) . "<br /><br />";
	
	
	if (isset($_GET['module_id']) and $_GET['module_id']!="")
	{	
		$module_id = $_GET['module_id'];

		// Storing Passed Module Name  
		$sql_module = "SELECT module_name,module_activeFlag FROM module WHERE module_id=$module_id"; 
		$results_module = mysqli_query($link,$sql_module);
		echo (!$results_module?die(mysqli_error($link)."<br />$sql_module"):"");	
		list($module_name,$module_activeFlag) = mysqli_fetch_array($results_module);
			
		// Display Module Status to User
		echo "<br />Module, <b>$module_name</b>, is currently set to ";
		if ($module_activeFlag == 1) { echo "<b>Active</b>"; }  else { echo "<b>Inactive</b>"; }
		echo " status";
		echo "<br /><br />";
		
		if ($module_activeFlag == 1) { $formButtonName = "Inactivate Module"; }  else { $formButtonName = "Activate Module"; } 
		if ($module_activeFlag == 1) { $newFormValue = 0; }  else { $newFormValue = 1; }
		
		// Start Area Form
		echo "<form method='post' action=''>";
		echo "<input type='hidden' name='module_activeFlag' value='$newFormValue'>"; // Set Value of 0 = Set Area to Inactive | Set Value of 1 = Set Area to Active
		echo "<br /><br />";
		echo "<input type='submit' value='$formButtonName'>";
		echo "</form>";
		
		
		if (isset($_POST['module_activeFlag']) and $_POST['module_activeFlag']!="")
		{
			$module_activeFlag = $_POST['module_activeFlag']; 
			
			$sql_newActiveFlag = "UPDATE module SET module_activeFlag=$module_activeFlag WHERE module_id=$module_id";
			$results_newActiveFlag = mysqli_query($link,$sql_newActiveFlag);
			echo (!$results_newActiveFlag?die(mysqli_error($link)."<br />".$sql_newActiveFlag):"");
			
			// Report Back to User > Check Module Table
			$sql_check = "SELECT module_id FROM module WHERE module_id=$module_id AND module_name='$module_name' AND module_activeFlag=$module_activeFlag";
			$results_check = mysqli_query($link,$sql_check);	
			echo (!$results_check?die(mysqli_error($link)."<br />".$sql_check):"");
			
			$countModule = mysqli_num_rows($results_check);
		
			if ($module_activeFlag == 1) { $newStatusUpdate = "Active"; }  else { $newStatusUpdate = "Inactive"; } 
		
			if ($countModule > 0) {   
				echo "<br /><br />";
				echo "The status for Module, <b>$module_name</b>, has been changed successfully to: <b>$newStatusUpdate</b>.";
			} else {
				echo "<br /><br />";
				echo "There was a problem with your request for Module: <b>$module_name</b>.  Please try again or contact support. <br /><br />";
				echo "Reference: <br />";
				echo "<ul><li>Module Id: $module_id</li><li>Module Name: $module_name</li><li>Request to set Active Status to: $module_activeFlag</li>";
			}
		}
		
	} else {  // If GET Requests are not set
		echo "<br /><br /> <b>There was a problem with your request.</b> <br /><br />";  
		echo "Please return to the <a href='$base_url/dashboard.php'>Dashboard</a>";
	}
?>

		
</body>
</html>