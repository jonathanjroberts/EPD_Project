<html>

<head>
	<title>Admin > Menu > Area Table > Add</title>
	<style> 
		th {text-decoration: underline;}
		td {text-align:center;} 
	</style>
</head>

<body>

<!-- http://localhost/PMBA/EPD/public/admin/area/add.php -->

<br /> <h2> Admin > Menu > Area Table > Add </h2> <hr />


<!-- Start: Global Include Files -->
<?php
	include('../../UtilityIncludes/globalIncludes.php');
?>
<!-- End: Global Include Files -->


<!-- Start: Add New Record -->
<?php
	// Toggle Breadcrumbs
	echo breadcrumbs($base_url,$homePageFileName,$homePageCrumbName,$queryString,$crumbRouteStartPosition,0) . "<br /><br />";	
	
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
<br /> <h3> Add Area Record</h3> <hr />
<form method='post' action=''>

	New Area Name: <input type='text' name='inputAreaName'><br />
	<br />

	<input type='submit' value='Add Area Record'>
</form>
<br />
<!--  End: HTML Form Section -->


</body>
</html>