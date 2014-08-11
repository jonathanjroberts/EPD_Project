<html>

<head>
	<title>Admin > Menu > Section Table > Change Active Status </title>
</head>

<body>

<body>

<!-- http://localhost/PMBA/EPD/public/admin/section/activate_or_inactivate.php -->

<br /> <h2> Admin > Menu > Section Table > Change Active Status </h2> <hr />

<!-- Start: Global Include Files -->
<?php
	include('../../UtilityIncludes/globalIncludes.php');
?>
<!-- End: Global Include Files -->

<?php
	// Link Back to Admin Menu > Area 
	echo "<br /><a href='$base_url/admin/section/list.php'>Return to Admin Section List</a><br />";
	
	// Link Back to Admin Menu
	echo "<br /><a href='$base_url/admin/default.php'>Return to Admin Menu</a><br />";
	
	// Link Back to Dashboard
	echo "<br /><a href='$base_url/dashboard.php'>Return to Dashboard</a><br />";
	echo "<br /><br />";

	// Toggle Breadcrumbs
	echo breadcrumbs($base_url,$homePageFileName,$homePageCrumbName,$queryString,$crumbRouteStartPosition,0) . "<br /><br />";
	
	
	if (isset($_GET['section_id']) and $_GET['section_id']!="")
	{	
		$section_id = $_GET['section_id'];

		// Storing Passed Section Name  
		$sql_section = "SELECT section_name,section_activeFlag FROM section WHERE section_id=$section_id"; 
		$results_section = mysqli_query($link,$sql_section);
		echo (!$results_section?die(mysqli_error($link)."<br />$sql_section"):"");	
		list($section_name,$section_activeFlag) = mysqli_fetch_array($results_section);
			
		// Display Section Status to User
		echo "<br />Section, <b>$section_name</b>, is currently set to ";
		if ($section_activeFlag == 1) { echo "<b>Active</b>"; }  else { echo "<b>Inactive</b>"; }
		echo " status";
		echo "<br /><br />";
		
		if ($section_activeFlag == 1) { $formButtonName = "Inactivate Section"; }  else { $formButtonName = "Activate Section"; } 
		if ($section_activeFlag == 1) { $newFormValue = 0; }  else { $newFormValue = 1; }
		
		// Start Section Form
		echo "<form method='post' action=''>";
		echo "<input type='hidden' name='section_activeFlag' value='$newFormValue'>"; // Set Value of 0 = Set to Inactive | Set Value of 1 = Set to Active
		echo "<br /><br />";
		echo "<input type='submit' value='$formButtonName'>";
		echo "</form>";
		
		
		if (isset($_POST['section_activeFlag']) and $_POST['section_activeFlag']!="")
		{
			$section_activeFlag = $_POST['section_activeFlag']; 
			
			$sql_newSectionActiveFlag = "UPDATE section SET section_activeFlag=$section_activeFlag WHERE section_id=$section_id";
			$results_newSectionActiveFlag = mysqli_query($link,$sql_newSectionActiveFlag);
			echo (!$results_newSectionActiveFlag?die(mysqli_error($link)."<br />".$sql_newSectionActiveFlag):"");
			
			// Report Back to User > Check Section Table
			$sql_checkSection = "SELECT section_id FROM section WHERE section_id=$section_id AND section_name='$section_name' AND section_activeFlag=$section_activeFlag";
			$results_checkSection = mysqli_query($link,$sql_checkSection);	
			echo (!$results_checkSection?die(mysqli_error($link)."<br />".$sql_checkSection):"");
			
			$countSection = mysqli_num_rows($results_checkSection);
		
			if ($section_activeFlag == 1) { $newStatusUpdate = "Active"; }  else { $newStatusUpdate = "Inactive"; } 
		
			if ($countSection > 0) {   
				echo "<br /><br />";
				echo "The status for Section, <b>$section_name</b>, has been changed successfully to: <b>$newStatusUpdate</b>.";
			} else {
				echo "<br /><br />";
				echo "There was a problem with your request for Section: <b>$section_name</b>.  Please try again or contact support. <br /><br />";
				echo "Reference: <br />";
				echo "<ul><li>Section Id: $section_id</li><li>Section Name: $section_name</li><li>Request to set Active Status to: $section_activeFlag</li>";
			}
		}
		
	} else {  // If GET Requests are not set
		echo "<br /><br /> <b>There was a problem with your request.</b> <br /><br />";  
		echo "Please return to the <a href='$base_url/dashboard.php'>Dashboard</a>";
	}
?>

		
</body>
</html>