<html>

<head>
	<title>Admin > Menu > Section > List</title>
	<style> 
		th {text-decoration: underline;}
		td {text-align:center;} 
	</style>
</head>

<body>

<!-- http://localhost/PMBA/EPD/public/admin/section/list.php -->

<br /> <h2> Admin > Menu > Section > List </h2> <hr />

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
	
	// Link Back to Admin Menu
	echo "<br /><a href='$base_url/admin/default.php$queryString[0]'>Return to Admin Menu</a><br />";
	
	// Link Back to Dashboard
	echo "<br /><a href='$base_url/dashboard.php$queryString[0]'>Return to Dashboard</a><br />";
	echo "<br /><br />";
	
	
	// Get Current List of Areas
	$sql_areaList = "SELECT area_id,area_name FROM area";
	$results_areaList = mysqli_query($link,$sql_areaList);
	echo (!$results_areaList?die(mysqli_error($link)."<br />$sql_areaList"):"");
	
	while(list($area_id,$area_name) = mysqli_fetch_array($results_areaList)){
		$input[$area_id] = $area_name; 
	}
	$areaList = array_unique($input);
	
	// Get Current List of Sections
	$sql = "SELECT section_id,area_id,section_name,section_activeFlag FROM section";
	$results = mysqli_query($link,$sql);
	echo (!$results?die(mysqli_error($link)."<br />$sql"):"");
	
	echo "<table>";
	echo "<tr>";
	echo "<th width='150px'>Section Id</th>";
	echo "<th width='150px'>Belongs to Area Id</th>";
	echo "<th width='150px'>Section Name</th>";
	echo "<th width='150px'>Active Status</th>";
	echo "<th width='150px'>Options</th>";
	echo "</tr>";
	
	while(list($section_id,$area_id,$section_name,$section_activeFlag) = mysqli_fetch_array($results)){
		echo "<tr>";
		echo "<td>$section_id</td> <td>$area_id</td>";
		echo "<td>$section_name</td>";
		echo "<td>"; if ($section_activeFlag == 1) { echo "Active"; } else { echo "Inactive"; } echo "</td>";
		echo "<td>";
		echo "<a href='edit.php?section_id=$section_id'>Edit</a> | ";	
		if ($section_activeFlag == 1) {  
			echo "<a href='activate_or_inactivate.php?section_id=$section_id'>Inactivate</a>";
		} else {
			echo "<a href='activate_or_inactivate.php?section_id=$section_id'>Activate</a>";
		}
		echo "</td>";
		echo "</tr>";
	}
	
	echo "</table>";	
?>
<!--  End: Table List: Current Records -->

<!-- Start: Add New Record -->
<?php
	if (isset($_POST['inputSectionName']) and isset($_POST['selectArea']) and $_POST['inputSectionName']!="" and $_POST['selectArea']!=""){
		$section_name = $_POST['inputSectionName'];
		$area_id = $_POST['selectArea']; 
		
		// Check if current combination already exists
		$sql = "SELECT section_name FROM section WHERE section_name='$section_name' AND area_id=$area_id ";
		$results = mysqli_query($link,$sql);	
		echo (!$results?die(mysqli_error($link)."<br />".$sql):"");
		$count = mysqli_num_rows($results);
		
		if ($count > 0){
			echo "The Section + Area you entered is already present in the database! <br />";
		} else {
		// Insert into database
			$sql = "INSERT INTO section(area_id,section_name) VALUES($area_id,'$section_name')";
			$results = mysqli_query($link,$sql);
			echo (!$results?die(mysqli_error($link)."<br />".$sql):"");

			// Report back to user
			$sql = "SELECT section_name FROM section WHERE section_name='$section_name'";
			// "SELECT Count(id)" could work - it will either be 1 or 0, but it wont give the actual username, just if it exists or not.
			// mysqli_num_rows returns the number of rows select statement got from the query
			
			$results = mysqli_query($link,$sql);	
			// if for any reason the query fails, it will post a response.  If it passes, nothing is posted.
			echo (!$results?die(mysqli_error($link)."<br />".$sql):"");
			
			$count = mysqli_num_rows($results);
			
			/* Testing */ echo "<br /> Count: " . $count . "<br />";
			if($count > 0){
				echo "The new Section, <b>$section_name</b>, has been added!";
			} else {
				echo "There was a problem adding: <b>$section_name</b>";
			}
		}
	}
?>
<!-- End: Add New Record -->

<!-- Start: HTML Form Section -->
<br /> <h3> Add Record</h3> <hr />
<form method='post' action=''>

	New Section Name:	<input type='text' name='inputSectionName'><br />
	<br />
	Belongs to Area:	<select name="selectArea">
							<option value="0" disabled selected>- Select Area -</option>
							<?php 
								foreach($areaList as $areaId => $areaValue){
								echo "<option value='$areaId'>$areaValue</option>";
							}
							?>
						</select>
	<br /><br />

	<input type='submit' value='Add Record'>
</form>
<br />
<!--  End: HTML Form Section -->


</body>
</html>