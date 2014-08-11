<html>

<head>
	<title>Admin > Menu > Area Table > List</title>
	<style> 
		th {text-decoration: underline;}
		td {text-align:center;} 
	</style>
</head>

<body>

<!-- http://localhost/PMBA/EPD/public/admin/area/list.php -->

<br /> <h2> Admin > Menu > Area Table > List </h2> <hr />

<!-- Start: Table List: Current Records -->
<br /> <h3> Current Available Areas </h3> <hr />

<!-- Start: Global Include Files -->
<?php
	include('../../UtilityIncludes/globalIncludes.php');
?>
<!-- End: Global Include Files -->

<?php	
	// Toggle Breadcrumbs
	echo breadcrumbs($base_url,$homePageFileName,$homePageCrumbName,$queryString,$crumbRouteStartPosition,0) . "<br /><br />";
		
	$sqlQuery="SELECT area.area_id,area.area_name,area.area_activeFlag,area.datetime_created,users.user_name 
			FROM area,users 
			WHERE users.user_id=area.user_id";
	$results = perform_SQLQuery($link,$sqlQuery);
	
	echo "<table>";
	echo "<tr>";
	echo "<th width='150px'>Area Id</th>";
	echo "<th width='150px'>Area Name</th>";
	echo "<th width='150px'>Current Status</th>";
	echo "<th width='150px'>Change Status</th>";
	echo "<th width='150px'>Username</th>";
	echo "<th width='150px'>Created at</th>";
	echo "</tr>";
	
	while(list($area_id,$area_name,$area_activeFlag,$datetime_created,$user_name) = mysqli_fetch_array($results)){
		echo "<tr>";
		echo "<td>$area_id</td> <td>$area_name</td>";
		
		// Where "0" = Currently Inactive | "1" = Currently Active
		echo "<td>"; if ($area_activeFlag == 1) { echo "Active"; } else { echo "Inactive"; } echo "</td>";
		
		echo "<td>";
		echo "<a href='edit.php?area_id=$area_id'>Edit</a> | ";	
		if ($area_activeFlag == 1) {  
			echo "<a href='activate_or_inactivate.php?area_id=$area_id'>Inactivate</a>";
		} else {
			echo "<a href='activate_or_inactivate.php?area_id=$area_id'>Activate</a>";
		}
		echo "</td>";
		echo "<td>$user_name</td> <td>$datetime_created</td>";
		echo "</tr>";
	}
	
	echo "</table>";	
		
?>
<!--  End: Table List: Current Records -->

<!-- Start: Add New Record -->
<?php
	if (isset($_POST['inputAreaName']) and $_POST['inputAreaName']!=""){
		$area_name = $_POST['inputAreaName'];
		
		// Check if current combination already exists
		$sqlQuery = "SELECT area_name FROM area WHERE area_name='$area_name'";
		$count = perform_SQLQuery_count($link,$sqlQuery);
		
		if ($count > 0){
			echo "<br />The Area Name you entered is already present in the database.  Please try another request or contact support. <br />";
		} else {
			// Insert into database
			$sqlQuery = "INSERT INTO area(area_name,user_id) VALUES('$area_name',$userId)";
			perform_SQLQuery($link,$sqlQuery);

			// Report back to user
			$sqlQuery = "SELECT area_name FROM area WHERE area_name='$area_name'";
			$count = perform_SQLQuery_count($link,$sqlQuery);
			
			if($count > 0){
				echo "<br />The new Area, <b>$area_name</b>, has been added!<br />";
			} else {
				echo "<br />There was a problem adding: <b>$area_name</b><br />";
			}
		}
	}
?>
<!-- End: Add New Record -->

<!-- Start: HTML Form Section -->
<br /> <h3> Add Record</h3> <hr />
<form method='post' action=''>

	New Area Name: <input type='text' name='inputAreaName'><br />
	<br />

	<input type='submit' value='Add Record'>
</form>
<br />
<!--  End: HTML Form Section -->


</body>
</html>