<html>

<head>
	<title>Admin > Menu > Module Table > Edit</title>
</head>

<body>

<!-- http://localhost/PMBA/EPD/public/admin/module/edit.php -->

<br /> <h2> Admin > Menu > Module Table > Edit </h2> <hr />

<!-- Start: Global Include Files -->
<?php
	include('../../UtilityIncludes/globalIncludes.php');
?>
<!-- End: Global Include Files -->


<?php
	// Toggle Breadcrumbs
	echo breadcrumbs($base_url,$homePageFileName,$homePageCrumbName,$queryString,$crumbRouteStartPosition,0) . "<br /><br />";
	
	// Link Back to Admin Menu > Area 
	echo "<br /><a href='$base_url/admin/module/list.php$queryString[0]'>Return to Admin Module List</a><br />";
	
	// Link Back to Admin Menu
	echo "<br /><a href='$base_url/admin/default.php$queryString[0]'>Return to Admin Menu</a><br />";
	
	// Link Back to Dashboard
	echo "<br /><a href='$base_url/dashboard.php$queryString[0]'>Return to Dashboard</a><br />";
	echo "<br /><br />";
	
	// Get Current List of Areas
	$areaList = getCurrentListForValue($link,"area","area_id","area_name");

	if (isset($_GET['module_id']) and $_GET['module_id']!="")
	{	
		$module_id = $_GET['module_id'];

		// Storing Passed Module Name  
		$sql_module = "SELECT module_id,module_name,area_id FROM module"; 
		$results_module = mysqli_query($link,$sql_module);
		echo (!$results_module?die(mysqli_error($link)."<br />$sql_module"):"");	
		list($module_id,$module_name,$area_id) = mysqli_fetch_array($results_module);
		
		// Store Existing Module Name as Temp - for success/failure event output
		$existingModuleName_temp = $module_name;
		$existingAreaId_temp = $area_id;
		
		// Display Module to User
		echo "<br /> <b>Edit Module Information for: </b> $module_name<br /><br /><br />";
		
		// Start Module Form
		echo "<form method='post' action=''>";
		echo "<input type='hidden' name='module_id' value='$module_id'>";
		echo "<b>Edit Module's Name:</b> <br />	<input name='module_name' placeholder='$module_name'></input><br /><br />";
		echo "<b>Module Currently belongs to Area:</b> <br /> ";
		echo "<select name='selectArea'>";
		echo "		<option value='0' disabled selected>- Select Area -</option>";				
					foreach($areaList as $areaId => $areaValue){						
						echo "<option value='$areaId' ";
						if ($areaId == $area_id) {  // if statement for setting selectbox to $area_id
							echo "selected";
							$area_name = $areaValue;
						}
						echo " >$areaValue</option>";
					}
		echo "</select>";					
								
		echo "<br /><br /><br />";
		echo "<input type='submit' value='Update Module'>";
		echo "</form>";
		
		
		if (isset($_POST['module_name']) and $_POST['module_name']!="")
		{
			$module_id = $_POST['module_id'];
			$module_name = $_POST['module_name']; 
			$area_id  = $_POST['selectArea']; 
			
			// Before Change > Report Back to User > Check Table
			$sql_check = "SELECT module_id FROM module WHERE module_id=$module_id AND module_name='$module_name' AND area_id=$area_id";
			$results_check = mysqli_query($link,$sql_check);	
			echo (!$results_check?die(mysqli_error($link)."<br />".$sql_check):"");
			
			$countNewName = mysqli_num_rows($results_check);
		
			if ($countNewName > 0) {   // Infers the New Name is Unique
				echo "<br /><br />";
				echo "The Module Name and Area you entered is already present in the database.  Please try another request or contact support. <br />";			
			} else { 	
				$sql_edit = "UPDATE module SET module_name='$module_name',area_id=$area_id WHERE module_id=$module_id";
				$results_edit = mysqli_query($link,$sql_edit);
				echo (!$results_edit?die(mysqli_error($link)."<br />".$sql_edit):"");

				// Get Area Name
				$sql_getAreaName = "SELECT area_name FROM area WHERE area_id=$area_id";
				$results_getAreaName = mysqli_query($link,$sql_getAreaName);
				echo (!$results_getAreaName?die(mysqli_error($link)."<br />".$sql_getAreaName):"");
				
				list($area_name) = mysqli_fetch_array($results_getAreaName);
				
				// After Change > Report Back to User > Check Table
				$sql_check = "SELECT module_id FROM module WHERE module_id=$module_id AND module_name='$module_name' AND area_id=$area_id";
				$results_check = mysqli_query($link,$sql_check);	
				echo (!$results_check?die(mysqli_error($link)."<br />".$sql_check):"");
				
				$countModule = mysqli_num_rows($results_check);
				
				if ($countModule > 0) {  
					echo "<br /><br />";
					echo "Module, <b>" . $existingModuleName_temp . "</b>, has been updated successfully to <b>$module_name</b>. <br />";
					echo "Module is listed under Area: " . $area_name . "<br />";
				} else {
					echo "<br /><br />";
					echo "There was a problem updating Section: <b>" . $existingModuleName_temp . " </b>, to <b>" . $module_name . "</b>.<br />"; 					
					echo "Please try again or contact support. <br /><br />";
					echo "Reference: <br />";
					echo "<ul><li>Module Id: $module_id</li>";
					echo "<li>Exisiting Module Name: <b>" . $module_name . "</b></li>";
					echo "<li>Exisiting Area_id: " . $existingAreaId_temp . " / New Area Id: <b>" . $area_Id . "</b></li>";
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