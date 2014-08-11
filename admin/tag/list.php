<html>

<head>
	<title>Admin > Menu > Tag > List</title>
	<style> 
		th {text-decoration: underline;}
		td {text-align:center;} 
	</style>
</head>

<body>

<!-- http://localhost/PMBA/EPD/public/admin/tag/list.php -->

<br /> <h2> Admin > Menu > Tag > List</h2> <hr />

<!-- Start: Global Include Files -->
<?php
	include('../../UtilityIncludes/globalIncludes.php');
?>
<!-- End: Global Include Files -->


<!-- Start: Table List: Current Records -->
<br /> <h3> Current Records </h3> <hr />
<?php
	
	// Get Current List of Areas
	$sql_areaList = "SELECT area_id,area_name FROM area";
	$results_areaList = mysqli_query($link,$sql_areaList);
	echo (!$results_areaList?die(mysqli_error($link)."<br />$sql_areaList"):"");
	
	while(list($area_id,$area_name) = mysqli_fetch_array($results_areaList)){
		$input[$area_id] = $area_name; 
	}
	$areaList = array_unique($input);
	
	$sql="SELECT tag_id,tag_name,area_id,tag_activeFlag FROM tag";
	$results = mysqli_query($link,$sql);
	echo (!$results?die(mysqli_error($link)."<br />$sql"):"");
	
	echo "<table>";
	echo "<tr>";
	echo "<th width='150px'>Tag Id</th>";
	echo "<th width='150px'>Belongs to Area Id</th>";
	echo "<th width='150px'>Tag Name</th>";
	echo "<th width='150px'>Is Active?</th>";
	echo "<th width='150px'>Options</th>";
	echo "</tr>";
	
	while(list($tag_id,$tag_name,$area_id,$tag_activeFlag) = mysqli_fetch_array($results)){
		echo "<tr>";
		echo "<td>$tag_id</td> <td>$area_id</td>";
		echo "<td>$tag_name</td>";
		echo "<td>"; if ($tag_activeFlag == 1) { echo "Active"; } else { echo "Inactive"; } echo "</td>";
		echo "<td>";
		echo "<a href='edit.php?tag_id=$tag_id'>Edit</a> | ";	
		if ($tag_activeFlag == 1) {  
			echo "<a href='activate_or_inactivate.php?tag_id=$tag_id'>Inactivate</a>";
		} else {
			echo "<a href='activate_or_inactivate.php?tag_id=$tag_id'>Activate</a>";
		}
		echo "</td>";
		echo "</tr>";
	}
	
	echo "</table>";	
		
?>
<!--  End: Table List: Current Records -->

<!-- Start: Add New Record -->
<?php
	if (isset($_POST['inputTagName']) and isset($_POST['selectArea']) and $_POST['inputTagName']!="" and $_POST['selectArea']!=""){
		$tag_name = $_POST['inputTagName'];
		$area_id = $_POST['selectArea']; 
		
		// Check if current combination already exists
		$sql = "SELECT tag_name FROM tag WHERE tag_name='$tag_name' AND area_id=$area_id";
		$results = mysqli_query($link,$sql);	
		echo (!$results?die(mysqli_error($link)."<br />".$sql):"");
		$count = mysqli_num_rows($results);
		
		if ($count > 0){
			echo "The Tag + Area you entered is already present in the database! <br />";
		} else {
		// Insert into database
			$sql = "INSERT INTO tag(tag_name,area_id) VALUES('$tag_name',$area_id)";
			$results = mysqli_query($link,$sql);
			echo (!$results?die(mysqli_error($link)."<br />".$sql):"");

			// Report back to user
			$sql = "SELECT tag_name FROM tag WHERE tag_name='$tag_name' AND area_id=$area_id";
			
			$results = mysqli_query($link,$sql);	
			echo (!$results?die(mysqli_error($link)."<br />".$sql):"");
			
			$count = mysqli_num_rows($results);
			
			if($count > 0){
				echo "The new Tag, <b>$tag_name</b>, has been added!";
			} else {
				echo "There was a problem adding: <b>$tag_name</b>";
			}
		}
	}
?>
<!-- End: Add New Record -->

<!-- Start: HTML Form Section -->
<br /> <h3> Add Record</h3> <hr />
<form method='post' action=''>

	New Tag Name: <input type='text' name='inputTagName'><br />
	<br />
	Assigned to Area:	<select name="selectArea">
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