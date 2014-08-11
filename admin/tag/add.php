<html>

<head>
	<title>Admin > Menu > Tag > Add</title>
	<style> 
		th {text-decoration: underline;}
		td {text-align:center;} 
	</style>
</head>

<body>

<!-- http://localhost/PMBA/EPD/public/admin/tag/add.php -->

<br /> <h2> Admin > Menu > Tag > Add</h2> <hr />

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
		
	// After getting user input
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