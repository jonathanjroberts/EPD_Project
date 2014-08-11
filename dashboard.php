<html>

<head>
	<title>Dashboard</title>
	<style> 
		th {text-decoration: underline;}
		td {text-align:left; padding-left:10px; vertical-align:top;} 
		h3 {padding-top: 20px; font-weight: bold; text-decoration: underline;}
	</style>
</head>

<body>

<!-- http://localhost/PMBA/EPD/public/dashboard.php -->

<br /> <h2> Dashboard </h2> <hr />

<!-- Start: Global Include Files -->
<?php
	include('UtilityIncludes/globalIncludes.php');
?>
<!-- End: Global Include Files -->

<!-- Start: Select Area > Select Dependent Sections -->
<br /> <h3>Select Area and Section</h3> <hr />


<?php
	// Get Current List of Areas
	$areaList = getCurrentListForValue($link,"area","area_id","area_name");
	
	// Search Page
	echo "<br /><a href='$base_url/search/search.php$queryString[0]'>Go to: Search Page</a><br /><br />";

	// Toggle Breadcrumbs
	echo breadcrumbs($base_url,$homePageFileName,$homePageCrumbName,$queryString,$crumbRouteStartPosition,0) . "<br /><br />";
	
	// Default Display without GET passes
	if (!isset($_GET['area_id']))
	{
		echo "<form method='get' action=''>";
		echo "Select Area: <select name='area_id'>";
		echo "<option value='0' disabled selected>- Select Area -</option>";
			foreach($areaList as $areaId => $areaValue){
				echo "<option value='$areaId'>$areaValue</option>";
			}
		echo "</select>";
		echo "<input type='submit' value='Next >'>";
		echo "</form>";
	}

// Start Area re-Selection + Display Results & Start Section Selection and Display Results	
	if (isset($_GET['area_id']) and $_GET['area_id']!="")
	{
		// Get selection for Area
		$area_id = $_GET['area_id']; 
		
		// Allows user to reslect Area after initial selection
		echo "<form method='get' action=''>";
		echo "Select Area: <select name='area_id'>";
		echo "<option value='0' disabled selected>- Select Area -</option>";
			foreach($areaList as $areaId => $areaValue){
				//echo "<option value='$areaId'>$areaValue</option>";
				echo "<option value='$areaId' ";
				if ($areaId == $area_id) {  // if statement for setting selectbox to $section_id
					echo "selected";
				}
				echo " >$areaValue</option>";
			}
		echo "</select>";
		echo "<input type='submit' value='Next >'>";
		// Generic Link to Add Comment without passing GET Request(Equipment Id)
		echo "  |  <a href='comment/selectAdd.php?area_id=$area_id'>Add New Comment</a>";
		echo "</form>";
		
		
		// Start Select Section Filter
			// Get Current List of Sections
			$sql_sectionList = "SELECT section.section_id,section.section_name 
			FROM section,equipment 
			WHERE section.area_id=$area_id AND section.section_activeFlag=1 AND equipment.section_id=section.section_id";
			/* shows sections if not comments - testing */ //$sql_sectionList = "SELECT section_id,section_name FROM section WHERE area_id=$area_id AND section_activeFlag=1";// AND equipment.section_id=section.section_id";
			
			$results_sectionList = mysqli_query($link,$sql_sectionList);
			echo (!$results_sectionList?die(mysqli_error($link)."<br />$sql_sectionList"):"");
			
			while(list($section_id,$section_name) = mysqli_fetch_array($results_sectionList)){
				$input_section[$section_id] = $section_name; 
			}
			if (empty($input_section) == FALSE) {
				$sectionList = array_unique($input_section);
			} else { 
				$sectionList = array("- None - ");
			}
			
			// Select Section form when 'section_id' is Unknown
			if (!isset($_GET['section_id']) and isset($_GET['area_id']) and $_GET['area_id']!="")
			{
				echo "<form method='get' action=''>";
				echo "<input type='hidden' name='area_id' value='$area_id'>";
				echo "Select Section: <select name='section_id'>";
				echo "<option value='0' disabled selected>- Select Section -</option>";
					foreach($sectionList as $sectionId => $sectionValue){
						echo "<option value='$sectionId'>$sectionValue</option>";
					}
				echo "</select>";
				echo "<input type='submit' value='Filter >'>";
				echo "</form>";
			}
			
			// Select Section form when 'section_id' is Known
			if (isset($_GET['section_id']) and $_GET['section_id']!="")
			{
	
				// Get previous Area Selection to keep URL & Get Section Selection
				$area_id = $_GET['area_id']; 
				$section_id = $_GET['section_id']; 
				
				echo "<form method='get' action=''>";
				echo "<input type='hidden' name='area_id' value='$area_id'>";
				echo "Select Section: <select name='section_id'>";
				
				if ($section_id != 0) { echo "<option value='0'>- All -</option>"; } else { "<option disabled selected>- Select Section -</option>"; }  // Toggle different options depending on $section_id setting
					foreach($sectionList as $sectionId => $sectionValue){						
						echo "<option value='$sectionId' ";
						if ($sectionId == $section_id) {  // if statement for setting selectbox to $section_id
							echo "selected";
							$section_name = $sectionValue;
						}
						echo " >$sectionValue</option>";
					}
				echo "</select>";				
				echo "<input type='submit' value='Filter >'>";				
				echo "</form>";
			}
		
		
		// With Section (Id,Name) already defined, Re-Specify sectionList so it only includes filter selection
			// if section_id == 0 is the same as "All" Sections
		//if (isset($_GET['section_id']) and $_GET['section_id']!="")
		/* rvm later */{
			if ($section_id == 0) { 
				// Do nothing | $sectionList[] already equals $sectionList[]
				// Need to do this in order to filter down for a specific section
			} else {
				unset($sectionList);
				$sectionList[$section_id] = $section_name; 
			}
		/* rvm later */}
		
		
		echo "<table>";
		echo "<tr>";
		echo "<th width='50px'></th>"; // Left Gutter
		echo "<th width='100px'></th>"; // Comment[datetime_created] 
		echo "<th width='500px'></th>"; // Equipment[equipment_shortname] | Comment[comment_value] | Comment [Add]
		echo "<th width='100px'></th>"; // Section[section_name] | Comment[user_id]
		echo "<th width='150px'></th>";
		echo "</tr>"; 	
		echo "<tr> <td><hr /></td> <td><hr /></td> <td><hr /></td> <td><hr /></td> <td><hr /></td> </tr>";
		
		
		foreach ($sectionList as $section_id => $section_name) {
			echo "<tr><td> </td></tr>";
			echo "<tr>";
			echo "<td></td> <td><h2>Section: $section_name</h2></td> <td></td> <td></td> <td></td> <td></td>";
			echo "</tr>";
			
			// Failed Attempts to "Not" display equipment if no comment is present.
				//$sql_visableEquipmentList_in_Section = "SELECT equipment.equipment_id,equipment.equipment_shortname FROM equipment,comment WHERE equipment.section_id=$section_id AND equipment.equipment_activeFlag=1 AND equipment.equipment_id=comment.equipment_id";
				//$sql_visableEquipmentList_in_Section = "SELECT equipment.equipment_id,equipment.equipment_shortname,comment.equipment_id FROM equipment LEFT JOIN comment ON equipment.equipment_id=comment.equipment_id WHERE equipment.section_id=$section_id AND equipment.equipment_activeFlag=1";
			
			$sql_visableEquipmentList_in_Section = "SELECT equipment_id,equipment_shortname FROM equipment WHERE section_id=$section_id AND equipment_activeFlag=1";
			
			$results_visableEquipmentList_in_Section = mysqli_query($link,$sql_visableEquipmentList_in_Section);
			echo (!$results_visableEquipmentList_in_Section?die(mysqli_error($link)."<br />$sql_visableEquipmentList_in_Section"):"");
			
			while(list($equipment_id,$equipment_shortname) = mysqli_fetch_array($results_visableEquipmentList_in_Section)){		
				echo "<tr>";
				echo "<td></td> <td></td>  <td><h3>Equipment: $equipment_shortname</h3></td> <td></td> <td></td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td></td> <td><b><u>Date & Time:</u></b></td>  <td><b><u>Comments:</u></b></td> <td><b><u>User:</u></b></td> <td><b><u>Options:</u></b></td>";
				echo "</tr>";				
				
					$sql_visableCommentList_in_Equipment = "SELECT comment_id,comment_value,user_id,datetime_created FROM comment WHERE equipment_id=$equipment_id AND comment_showFlag=1 AND comment_activeFlag=1";
					$results_visableCommentList_in_Equipment = mysqli_query($link,$sql_visableCommentList_in_Equipment);
					echo (!$results_visableCommentList_in_Equipment?die(mysqli_error($link)."<br />$sql_visableCommentList_in_Equipment"):"");
					
					// Show Active Comments for Equipment Id
					while(list($comment_id,$comment_value,$user_id,$datetime_created) = mysqli_fetch_array($results_visableCommentList_in_Equipment)){		
							echo "<tr>";
							echo "<td></td> <td><b>$datetime_created:</b></td> <td>$comment_value</td> <td>$user_id</td> <td><a href='comment/show_or_hide.php?area_id=$area_id&section_id=$section_id&equipment_id=$equipment_id&comment_id=$comment_id'>Hide</a> | <a href='comment/edit.php?area_id=$area_id&section_id=$section_id&equipment_id=$equipment_id&comment_id=$comment_id'>Edit</a> | <a href='comment/activate_or_inactivate.php?area_id=$area_id&section_id=$section_id&equipment_id=$equipment_id&comment_id=$comment_id'>Remove</a> </td>";
							echo "</tr>";
					}					
				// Add Comment for Equipment Id
				echo "<tr>";
				echo "<td></td> <td></td> <td><a href='comment/add.php?area_id=$area_id&section_id=$section_id&equipment_id=$equipment_id'>Add New Comment</a></td> <td></td> <td></td>";
				echo "</tr>";
				echo "<tr><td> <br /> </td></tr>";
			}
			echo "<tr> <td><hr /></td> <td><hr /></td> <td><hr /></td> <td><hr /></td> <td><hr /></td> </tr>";
		}
		
		echo "</table>";	
		
	} // No else if here
?>
<!-- End: Select Area > Select Dependent Sections  -->


</body>
</html>