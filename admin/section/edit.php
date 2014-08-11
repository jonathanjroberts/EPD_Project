<html>

<head>
	<title>Admin > Menu > Section Table > Edit</title>
</head>

<body>

<!-- http://localhost/PMBA/EPD/public/admin/section/edit.php -->

<br /> <h2> Admin > Menu > Section Table > Edit </h2> <hr />

<!-- Start: Global Include Files -->
<?php
	include('../../UtilityIncludes/globalIncludes.php');
?>
<!-- End: Global Include Files -->


<?php
	// Toggle Breadcrumbs
	echo breadcrumbs($base_url,$homePageFileName,$homePageCrumbName,$queryString,$crumbRouteStartPosition,0) . "<br /><br />";
	
	// Link Back to Admin Menu > Area 
	echo "<br /><a href='$base_url/admin/section/list.php$queryString[0]'>Return to Admin Section List</a><br />";
	
	// Link Back to Admin Menu
	echo "<br /><a href='$base_url/admin/default.php$queryString[0]'>Return to Admin Menu</a><br />";
	
	// Link Back to Dashboard
	echo "<br /><a href='$base_url/dashboard.php$queryString[0]'>Return to Dashboard</a><br />";
	echo "<br /><br />";
	
	// Get Current List of Sections
	$areaList = getCurrentListForValue($link,"area","area_id","area_name");
		/*$sql_sectionList = "SELECT area_id,area_name FROM area";
		$results_sectionList = mysqli_query($link,$sql_sectionList);
		echo (!$results_sectionList?die(mysqli_error($link)."<br />$sql_areaList"):"");
		
		while(list($area_id,$area_name) = mysqli_fetch_array($results_areaList)){
			$input[$area_id] = $area_name; 
		}
		$areaList = array_unique($input); */
	

	if (isset($_GET['section_id']) and $_GET['section_id']!="")
	{	
		$section_id = $_GET['section_id'];

		// Storing Passed Section Name  
		$sql_section = "SELECT section_id,section_name,area_id FROM section WHERE section_id=$section_id"; 
		$results_section = mysqli_query($link,$sql_section);
		echo (!$results_section?die(mysqli_error($link)."<br />$sql_section"):"");	
		list($section_id,$section_name,$area_id) = mysqli_fetch_array($results_section);
		
		// Store Existing Section Name as Temp - for success/failure event output
		$existingSectionName_temp = $section_name;
		$existingAreaId_temp = $area_id;
		
		// Display Section to User
		echo "<br /> <b>Edit Section Information for: </b> $section_name<br /><br /><br />";
		
		// Start Section Form
		echo "<form method='post' action=''>";
		echo "<input type='hidden' name='section_id' value='$section_id'>";
		echo "<b>Edit Section's Name:</b> <br />	<input name='section_name' placeholder='$section_name'></input><br /><br />";
		echo "<b>Section Currently belongs to Area:</b> <br /> ";
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
		echo "<input type='submit' value='Update Section'>";
		echo "</form>";
		
		
		if (isset($_POST['section_name']) and $_POST['section_name']!="")
		{
			$section_id = $_POST['section_id'];
			$section_name = $_POST['section_name']; 
			$area_id  = $_POST['selectArea']; 
			
			// Before Change > Report Back to User > Check Section Table
			$sql_checkSection = "SELECT section_id FROM section WHERE section_id=$section_id AND section_name='$section_name' AND area_id=$area_id";
			$results_checkSection = mysqli_query($link,$sql_checkSection);	
			echo (!$results_checkSection?die(mysqli_error($link)."<br />".$sql_checkSection):"");
			
			$countNewSectionName = mysqli_num_rows($results_checkSection);
		
			if ($countNewSectionName > 0) {   // Infers the New Name is Unique
				echo "<br /><br />";
				echo "The Section Name and Area you entered is already present in the database.  Please try another request or contact support. <br />";			
			} else { 	
				$sql_editSection = "UPDATE section SET section_name='$section_name',area_id=$area_id WHERE section_id=$section_id";
				$results_editSection = mysqli_query($link,$sql_editSection);
				echo (!$results_editSection?die(mysqli_error($link)."<br />".$sql_editSection):"");

				// Get Section Name
				$sql_getAreaName = "SELECT area_name FROM area WHERE area_id=$area_id";
				$results_getAreaName = mysqli_query($link,$sql_getAreaName);
				echo (!$results_getAreaName?die(mysqli_error($link)."<br />".$sql_getAreaName):"");
				
				list($area_name) = mysqli_fetch_array($results_getAreaName);
				
				// After Change > Report Back to User > Check Section Table
				$sql_checkSection = "SELECT section_id FROM section WHERE section_id=$section_id AND section_name='$section_name' AND area_id=$area_id";
				$results_checkSection = mysqli_query($link,$sql_checkSection);	
				echo (!$results_checkSection?die(mysqli_error($link)."<br />".$sql_checkSection):"");
				
				$countSection = mysqli_num_rows($results_checkSection);
				
				if ($countSection > 0) {  
					echo "<br /><br />";
					echo "Section, <b>" . $existingSectionName_temp . "</b>, has been updated successfully to <b>$section_name</b>. <br />";
					echo "Area is listed under: " . $area_name . "<br />";
				} else {
					echo "<br /><br />";
					echo "There was a problem updating Section: <b>" . $existingSectionName_temp . " </b>, to <b>" . $section_name . "</b>.<br />"; 					
					echo "Please try again or contact support. <br /><br />";
					echo "Reference: <br />";
					echo "<ul><li>Section Id: $section_id</li>";
					echo "<li>Exisiting Section Name: <b>" . $section_name . "</b></li>";
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