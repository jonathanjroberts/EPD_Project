<html>

<head>
	<title>Admin > Menu > Area Table > Change Active Status </title>
</head>

<body>

<body>

<!-- http://localhost/PMBA/EPD/public/admin/area/inactivate.php -->

<br /> <h2> Admin > Menu > Area Table > Change Active Status </h2> <hr />

<!-- Start: Global Include Files -->
<?php
	include('../../UtilityIncludes/globalIncludes.php');
?>
<!-- End: Global Include Files -->

<?php

	// Toggle Breadcrumbs
	echo breadcrumbs($base_url,$homePageFileName,$homePageCrumbName,$queryString,$crumbRouteStartPosition,0) . "<br /><br />";
	
	
	if (isset($_GET['equipment_id']) and $_GET['equipment_id']!="")
	{	
		$equipment_id = $_GET['equipment_id'];

		// Storing Passed Equipment Name  
		$sql_equipment = "SELECT equipment_longname,equipment_shortname,equipment_activeFlag FROM equipment WHERE equipment_id=$equipment_id"; 
		$results_equipment = mysqli_query($link,$sql_equipment);
		echo (!$results_equipment?die(mysqli_error($link)."<br />$sql_equipment"):"");	
		list($equipment_longname,$equipment_shortname,$equipment_activeFlag) = mysqli_fetch_array($results_equipment);
		
		// Display Equipment Status to User
		echo "<br />Equipment, <b>$equipment_longname / $equipment_shortname</b>, is currently set to ";
		if ($equipment_activeFlag == 1) { echo "<b>Active</b>"; }  else { echo "<b>Inactive</b>"; }
		echo " status";
		echo "<br /><br />";
		
		if ($equipment_activeFlag == 1) { $formButtonName = "Inactivate Equipment"; }  else { $formButtonName = "Activate Equipment"; } 
		if ($equipment_activeFlag == 1) { $newFormValue = 0; }  else { $newFormValue = 1; }
		
		// Start Equipment Form
		echo "<form method='post' action=''>";
		echo "<input type='hidden' name='equipment_activeFlag' value='$newFormValue'>"; // Set Value of 0 = Set Equipment to Inactive | Set Value of 1 = Set Equipment to Active
		echo "<br /><br />";
		echo "<input type='submit' value='$formButtonName'>";
		echo "</form>";
		
		
		if (isset($_POST['equipment_activeFlag']) and $_POST['equipment_activeFlag']!="")
		{
			$equipment_activeFlag = $_POST['equipment_activeFlag']; 
			
			$sqlQuery = "UPDATE equipment SET equipment_activeFlag=$equipment_activeFlag WHERE equipment_id=$equipment_id";
			perform_SQLQuery($link,$sqlQuery);
			
			// Report Back to User > Check Equipment Table
			$sqlQuery = "SELECT equipment_id FROM equipment WHERE equipment_id=$equipment_id AND equipment_longname='$equipment_longname' AND equipment_activeFlag=$equipment_activeFlag";
			$count = perform_SQLQuery_count($link,$sqlQuery);
		
			if ($equipment_activeFlag == 1) { $newStatusUpdate = "Active"; }  else { $newStatusUpdate = "Inactive"; } 
		
			if ($count > 0) {   
				echo "<br /><br />";
				echo "The status for Equipment, <b>$equipment_longname / $equipment_shortname</b>, has been changed successfully to: <b>$newStatusUpdate</b>.";
			} else {
				echo "<br /><br />";
				echo "There was a problem with your request for Equipment: <b>$equipment_longname / $equipment_shortname</b>.  Please try again or contact support. <br /><br />";
				echo "Reference: <br />";
				echo "<ul><li>Equipment Id: $equipment_id</li><li>Equipment Full Name: $equipment_longname</li><li>Equipment Abv Name: $equipment_shortname</li><li>Request to set Active Status to: $equipment_activeFlag</li>";
			}
		}
		
	} else {  // If GET Requests are not set
		echo "<br /><br /> <b>There was a problem with your request.</b> <br /><br />";  
		echo "Please return to the <a href='$base_url/dashboard.php'>Dashboard</a>";
	}
?>

		
</body>
</html>