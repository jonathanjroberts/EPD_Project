<html>

<head>
	<title>Admin > Menu > Equpiment > List</title>
	<style> 
		th {text-decoration: underline;}
		td {text-align:center;} 
	</style>
</head>

<body>

<!-- http://localhost/PMBA/EPD/public/admin/equipment/list.php -->

<br /> <h2> Admin > Menu > Update Equpiment > List</h2> <hr />


<!-- Start: Global Include Files -->
<?php
	include('../../UtilityIncludes/globalIncludes.php');
?>
<!-- End: Global Include Files -->


<!-- Start: Table List: Current Records -->
<br /> <h3> Current Records </h3> <hr />

<?php

	// Toggle Breadcrumbs
	echo breadcrumbs($base_url,$homePageFileName,$homePageCrumbName,$queryString,$crumbRouteStartPosition,0) . "<br /><br />";
	
	// Get Current List of Sections
	$sectionList = getCurrentListForValue($link,"section","section_id","section_name");
	
	// Get Current List of Equipment
	$sql = "SELECT equipment_id,section_id,equipment_shortname,equipment_longname,equipment_activeFlag FROM equipment";
	$results = mysqli_query($link,$sql);
	echo (!$results?die(mysqli_error($link)."<br />$sql"):"");
	
	echo "<table>";
	echo "<tr>";
	echo "<th width='150px'>Equipment Id</th>";
	echo "<th width='150px'>Belongs to Section Id</th>";
	echo "<th width='150px'>Equipment Long Name</th>";
	echo "<th width='150px'>Equipment Short Name</th>";
	echo "<th width='150px'>Is Active?</th>";
	echo "<th width='150px'>Options</th>";
	echo "</tr>"; 	
	
	while(list($equipment_id,$section_id,$equipment_shortname,$equipment_longname,$equipment_activeFlag) = mysqli_fetch_array($results)){
		echo "<tr>";
		echo "<td>$equipment_id</td> <td>$section_id</td>";
		echo "<td>$equipment_longname</td> <td>$equipment_shortname</td>";
		echo "<td>"; if ($equipment_activeFlag == 1) { echo "Active"; } else { echo "Inactive"; } echo "</td>";
		echo "<td>";
		echo "<a href='edit.php?equipment_id=$equipment_id'>Edit</a> | ";	
		if ($equipment_activeFlag == 1) {  
			echo "<a href='activate_or_inactivate.php?equipment_id=$equipment_id'>Inactivate</a>";
		} else {
			echo "<a href='activate_or_inactivate.php?equipment_id=$equipment_id'>Activate</a>";
		}
		echo "</td>";
		echo "</tr>";
	}
	echo "</table>";	
	echo "<br /><br />";

	// Start: Add New Record -->
	if (isset($_GET['inputEquipmentShortName']) and isset($_GET['inputEquipmentLongName']) and isset($_GET['selectSection']) and $_GET['inputEquipmentShortName']!="" and $_GET['inputEquipmentLongName']!="" and $_GET['selectSection']!=""){
		
		$equipment_shortname = $_GET['inputEquipmentShortName'];
		$equipment_longname = $_GET['inputEquipmentLongName'];
		$section_id = $_GET['selectSection']; 
		
		// Check if current combination already exists
		$sqlQuery = "SELECT equipment_id FROM equipment WHERE equipment_longname='$equipment_longname' AND equipment_shortname='$equipment_shortname' AND section_id=$section_id";
		$count = perform_SQLQuery_count($link,$sqlQuery);
		
		if ($count > 0){
			echo "The Equipment Name and Section you entered is already present in the database! <br />";
		} else {
			// Insert 
			$sqlQuery = "INSERT INTO equipment(section_id,equipment_shortname,equipment_longname) VALUES($section_id,'$equipment_shortname','$equipment_longname')";
			perform_SQLQuery($link,$sqlQuery);

			// Check
			$sqlQuery = "SELECT equipment_longname FROM equipment WHERE equipment_longname='$equipment_longname'";
			$count = perform_SQLQuery_count($link,$sqlQuery);

			if($count > 0){
				echo "The new Equipment, <b>$equipment_longname / $equipment_shortname'</b>, has been added!";
			} else {
				echo "There was a problem adding: <b>$equipment_longname / $equipment_shortname</b>";
			}
		}
	}
	///////
	// Get Current List of Area
	$areaList = getCurrentListForValue($link,"area","area_id","area_name");

	// Default Display without GET passes
	if (!isset($_GET['area_id']))
	{
		echo "<br /> <h3> Add Records </h3> <hr />";
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
	
	// Allow User to Toggle their choice of Sections by Area for Equipment
	if (isset($_GET['area_id']) and $_GET['area_id']!="")
	{
		// Get selection for Area
		$area_id = $_GET['area_id']; 

		// Get Current List of Sections
		$sectionList = getCurrentListForValueBySelection($link,"section","section_id","section_name","area_id","$area_id");
			
		// Allows user to reselect Area after initial selection
		echo "<br /> <h3> Add Records </h3> <hr />";
		echo "<form method='get' action=''>";
		echo "Select Area: <select name='area_id'>";
		echo "<option value='0' disabled selected>- Select Area -</option>";
			foreach($areaList as $areaId => $areaValue){
				echo "<option value='$areaId'";
				if ($areaId == $area_id) {  
					echo "selected";
				}
				echo ">$areaValue</option>";
			}
		echo "</select>";
		echo "<input type='submit' value='Next >'>";
	

		// Start: HTML Form Section -->
		echo "<form method='get' name='Add Record' action=''>";
		echo "For Section:";
			echo "<select name='selectSection'>";

					echo "<option value='0' disabled selected>- Select Section -</option>";
					if (isset($_GET['area_id'])) 
					{
						foreach($sectionList as $sectionId => $sectionValue){
							echo "<option value='$sectionId' ";
							if ($sectionId == $section_id) {  
								echo "selected";
							}
							echo ">$sectionValue</option>";
						}
					} else {
						foreach($sectionList as $sectionId => $sectionValue){
							echo "<option value='$sectionId'>$sectionValue</option>";
						}
					}

			echo "</select>";
			echo "<br /><br />";
			echo "New Equipment Long Name:	<input type='text' name='inputEquipmentLongName'><br />";
			echo "<br />";
			echo "New Equipment Short Name:	<input type='text' name='inputEquipmentShortName'><br />";
				
			echo "<br />";
			echo "<input type='submit' value='Add Record'>";
		echo "</form>";

		//End: HTML Form Section -->
	
	}
?>

</body>
</html>