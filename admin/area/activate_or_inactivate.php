<html>

<head>
	<title>Admin > Menu > Area Table > Change Active Status </title>
</head>

<body>

<body>

<!-- http://localhost/PMBA/EPD/public/admin/area/activate_or_inactivate.php -->

<br /> <h2> Admin > Menu > Area Table > Change Active Status </h2> <hr />

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
		//$sqlString = "SELECT area_name,area_activeFlag FROM area WHERE area_id=$area_id";
		//$v1[0] = '$area_name'; $v1[1] = '$area_activeFlag';  $value = implode($v1,",");
		//$sqlResult = array('area_name','area_activeFlag');
		//  echo perform_SQLQuery_list($link,$sqlString,$value);
		//foreach ($arr as $value) {
		//	echo "Value: $value<br />\n";
		//}
		
		// Need to modify SQL Query functions to send/return array instead of variable
		$sql_area = "SELECT area_name,area_activeFlag FROM area WHERE area_id=$area_id"; 
		$results_area = mysqli_query($link,$sql_area);
		echo (!$results_area?die(mysqli_error($link)."<br />$sql_area"):"");	
		list($area_name,$area_activeFlag) = mysqli_fetch_array($results_area); 
			
		// Display Area Status to User
		echo "<br />Area, <b>$area_name</b>, is currently set to ";
		if ($area_activeFlag == 1) { echo "<b>Active</b>"; }  else { echo "<b>Inactive</b>"; }
		echo " status";
		echo "<br /><br />";
		
		if ($area_activeFlag == 1) { $formButtonName = "Inactivate Area"; }  else { $formButtonName = "Activate Area"; } 
		if ($area_activeFlag == 1) { $newFormValue = 0; }  else { $newFormValue = 1; }
		
		// Start Area Form
		echo "<form method='post' action=''>";
		echo "<input type='hidden' name='area_activeFlag' value='$newFormValue'>"; // Set Value of 0 = Set Area to Inactive | Set Value of 1 = Set Area to Active
		echo "<br /><br />";
		echo "<input type='submit' value='$formButtonName'>";
		echo "</form>";
		
		
		if (isset($_POST['area_activeFlag']) and $_POST['area_activeFlag']!="")
		{
			$area_activeFlag = $_POST['area_activeFlag']; 
			
			// Update
			$sqlQuery = "UPDATE area SET area_activeFlag=$area_activeFlag WHERE area_id=$area_id";
			perform_SQLQuery($link,$sqlQuery);
			
			// Check
			$sqlQuery = "SELECT area_id FROM area WHERE area_id=$area_id AND area_name='$area_name' AND area_activeFlag=$area_activeFlag";
			$count = perform_SQLQuery_count($link,$sqlQuery);
		
			if ($area_activeFlag == 1) { $newStatusUpdate = "Active"; }  else { $newStatusUpdate = "Inactive"; } 
		
			if ($count > 0) {   
				echo "<br /><br />";
				echo "The status for Area, <b>$area_name</b>, has been changed successfully to: <b>$newStatusUpdate</b>.";
			} else {
				echo "<br /><br />";
				echo "There was a problem with your request for Area: <b>$area_name</b>.  Please try again or contact support. <br /><br />";
				echo "Reference: <br />";
				echo "<ul><li>Area Id: $area_id</li><li>Area Name: $area_name</li><li>Request to set Active Status to: $area_activeFlag</li>";
			}
		}
		
	} else {  // If GET Requests are not set
		echo "<br /><br /> <b>There was a problem with your request.</b> <br /><br />";  
		echo "Please return to the <a href='$base_url/dashboard.php'>Dashboard</a>";
	}
?>

		
</body>
</html>