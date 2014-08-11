<html>

<head>
	<title>Admin > Menu > Area Table > Edit</title>
</head>

<body>

<!-- http://localhost/PMBA/EPD/public/admin/area/edit.php -->

<br /> <h2> Admin > Menu > Area Table > Edit </h2> <hr />

<!-- Start: Global Include Files -->
<?php
	include('../../UtilityIncludes/globalIncludes.php');
?>
<!-- End: Global Include Files -->


<?php
	// Toggle Breadcrumbs
	echo breadcrumbs($base_url,$homePageFileName,$homePageCrumbName,$queryString,$crumbRouteStartPosition,0) . "<br /><br />";

	if (isset($_GET['area_id']) and $_GET['area_id']!="")
	{	
		$area_id = $_GET['area_id'];

		// Storing Passed Area Name  
		$sqlQuery = "SELECT area_name FROM area WHERE area_id=$area_id";
		$area_name = perform_SQLQuery_list($link,$sqlQuery,'area_name');
		
		// Store Existing Area Name as Temp
		$existingAreaName_temp = $area_name;
		
		// Display Area to User
		echo "<br /> <b>Edit Name for Area:</b> $area_name <br /><br /><br />";
		
		// Start Area Form
		echo "<form method='post' action=''>";
		echo "<b>Edit Area Name:</b> <br />	<input name='area_name' placeholder='$area_name'></input><br />";
		echo "<br /><br />";
		echo "<input type='submit' value='Update Area'>";
		echo "</form>";
		
		
		if (isset($_POST['area_name']) and $_POST['area_name']!="")
		{
			$area_name = $_POST['area_name']; 
			
			$sqlQuery = "SELECT area_id FROM area WHERE area_id=$area_id AND area_name='$area_name'";
			$count = perform_SQLQuery_count($link,$sqlQuery);
		
			if ($count > 0) {   // Infers the New Name is Unique
				echo "<br /><br />";
				echo "The Area Name you entered is already present in the database.  Please try another request or contact support. <br />";			
			} else {
				// Update
				$sqlQuery = "UPDATE area SET area_name='$area_name',user_id=$userId,datetime_created=now() WHERE area_id=$area_id";
				perform_SQLQuery($link,$sqlQuery);
				
				// Check
				$sqlQuery = "SELECT area_id FROM area WHERE area_id=$area_id AND area_name='$area_name'";
				$count = perform_SQLQuery_count($link,$sqlQuery);
				
				if ($count > 0) {  
					echo "<br /><br />";
					echo "Area, <b>$existingAreaName_temp</b>, has been renamed successfully to <b>$area_name</b>.";
				} else {
					echo "<br /><br />";
					echo "There was a problem renaming Area, <b>$existingAreaName_temp</b>, to <b>$area_name</b>.  Please try again or contact support. <br /><br />";
					echo "Reference: <br />";
					echo "<ul><li>Area Id: $area_id</li><li>Exisiting Area Name: $existingAreaName_temp</li><li>New Area Name Entered: $area_name</li>";
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