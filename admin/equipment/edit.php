<html>

<head>
	<title>Admin > Menu > Equipment Table > Edit</title>
</head>

<body>

<!-- http://localhost/PMBA/EPD/public/admin/equipment/edit.php -->

<br /> <h2> Admin > Menu > Equipment Table > Edit </h2> <hr />

<!-- Start: Global Include Files -->
<?php
	include('../../UtilityIncludes/globalIncludes.php');
?>
<!-- End: Global Include Files -->


<?php
	
	// Toggle Breadcrumbs
	echo breadcrumbs($base_url,$homePageFileName,$homePageCrumbName,$queryString,$crumbRouteStartPosition,0) . "<br /><br />";
	
	// Get Current List of Sections
	$sectionList = getCurrentListForValue($link,"section","section_id","section_name");
	
	if (isset($_GET['equipment_id']) and $_GET['equipment_id']!="")
	{	
		$equipment_id = $_GET['equipment_id'];

		// Storing Passed Equipment Name  
		$sql_equipment = "SELECT equipment_longname,equipment_shortname,section_id FROM equipment WHERE equipment_id=$equipment_id"; 
		$results_equipment = mysqli_query($link,$sql_equipment);
		echo (!$results_equipment?die(mysqli_error($link)."<br />$sql_equipment"):"");	
		list($equipment_longname,$equipment_shortname,$section_id) = mysqli_fetch_array($results_equipment);
		
		// Store Existing Equipment Name as Temp - for success/failure event output
		$existingEquipmentLongName_temp = $equipment_longname;
		$existingEquipmentShortName_temp = $equipment_shortname;
		$existingSectionId_temp = $section_id;
		
		// Display Equipment to User
		echo "<br /> <b>Edit Equipment Information for: </b> $equipment_longname / $equipment_shortname <br /><br /><br />";
		
		// Start Equipment Form
		echo "<form method='post' action=''>";
		echo "<b>Edit Equipment's Full Name:</b> <br />	<input name='equipment_longname' placeholder='$equipment_longname'></input><br /><br />";
		echo "<b>Edit Equipment's Abv. Name:</b> <br />	<input name='equipment_shortname' placeholder='$equipment_shortname'></input><br /><br />";
		echo "<b>Equipment currently belongs to Seciton:</b> <br /> ";
		echo "<select name='selectSection'>";
		echo "		<option value='0' disabled selected>- Select Section -</option>";				
					foreach($sectionList as $sectionId => $sectionValue){						
						echo "<option value='$sectionId' ";
						if ($sectionId == $section_id) {  // if statement for setting selectbox to $section_id
							echo "selected";
							$section_name = $sectionValue;
						}
						echo " >$sectionValue</option>";
					}
		echo "</select>";					
								
		echo "<br /><br /><br />";
		echo "<input type='submit' value='Update Equipment'>";
		echo "</form>";
		
		
		if (isset($_POST['equipment_longname']) and isset($_POST['equipment_longname']) and $_POST['equipment_shortname']!="" and $_POST['equipment_shortname']!="")
		{
			$equipment_longname = $_POST['equipment_longname']; 
			$equipment_shortname = $_POST['equipment_shortname']; 
			$section_id  = $_POST['selectSection']; 
			
			// Before Change > Report Back to User > Check Equipment Table
			$sqlQuery = "SELECT equipment_id FROM equipment WHERE equipment_id=$equipment_id AND equipment_longname='$equipment_longname' AND section_id=$section_id";
			$count = perform_SQLQuery_count($link,$sqlQuery);;
		
			if ($count > 0) {   // Infers the New (Long) Name is Unique
				echo "<br /><br />";
				echo "The Equipment Name and Section you entered is already present in the database.  Please try another request or contact support. <br />";			
			} else { 	
				// Update
				$sqlQuery = "UPDATE equipment SET equipment_longname='$equipment_longname',equipment_shortname='$equipment_shortname',section_id=$section_id WHERE equipment_id=$equipment_id";
				perform_SQLQuery($link,$sqlQuery);

				// Get Section Name
				$sqlString = "SELECT section_name FROM section WHERE section_id=$section_id";
				$section_name = perform_SQLQuery_list($link,$sqlString,'section_name');
			
				// After Change > Report Back to User > Check Equipment Table
				$sqlQuery = "SELECT equipment_id FROM equipment WHERE equipment_id=$equipment_id AND equipment_longname='$equipment_longname' AND equipment_shortname='$equipment_shortname'";
				$count = perform_SQLQuery_count($link,$sqlQuery);
				
				if ($count > 0) {  
					echo "<br /><br />";
					echo "Equipment, <b>" . $existingEquipmentLongName_temp . " / " . $existingEquipmentShortName_temp . "</b>, has been updated successfully to <b>$equipment_longname / $equipment_shortname</b>. <br />";
					echo "Equipment is listed under Section: <b>" . $section_name . "</b><br />";
				} else {
					echo "<br /><br />";
					echo "There was a problem updating Equipment: <b>" . $existingEquipmentLongName_temp . " / " . $existingEquipmentShortName_temp . " </b>, to <b>" . $equipment_longname . " / " . $equipment_shortname . "</b>.<br />"; 					
					echo "Please try again or contact support. <br /><br />";
					echo "Reference: <br />";
					echo "<ul><li>Equipment Id: $equipment_id</li>";
					echo "<li>Exisiting Equipment Name: <b>" . $equipment_longname . " / " . $equipment_shortname . "</b></li>";
					echo "<li>Exisiting Section_id: " . $existingSectionId_temp . " / New Section Id: <b>" . $section_Id . "</b></li>";
				}
			}
		}
		
	} else {  // If GET Requests are not set
		echo "<br /><br /> <b>There was a problem with your request.</b> <br /><br />";
		echo "Please return to the <a href='$base_url/dashboard.php'>Dashboard</a>";
	}
?>

		
</body>
</html>