<html>

<head>
	<title>Admin > Menu > Tag Table > Change Active Status </title>
</head>

<body>

<body>

<!-- http://localhost/PMBA/EPD/public/admin/tag/activate_or_inactivate.php -->

<br /> <h2> Admin > Menu > Tag Table > Change Active Status </h2> <hr />

<!-- Start: Global Include Files -->
<?php
	include('../../UtilityIncludes/globalIncludes.php');
?>
<!-- End: Global Include Files -->

<?php
	// Link Back to Admin Menu > Area 
	echo "<br /><a href='$base_url/admin/tag/list.php'>Return to Admin Tag List</a><br />";
	
	// Link Back to Admin Menu
	echo "<br /><a href='$base_url/admin/default.php'>Return to Admin Menu</a><br />";
	
	// Link Back to Dashboard
	echo "<br /><a href='$base_url/dashboard.php'>Return to Dashboard</a><br />";
	echo "<br /><br />";

	// Toggle Breadcrumbs
	echo breadcrumbs($base_url,$homePageFileName,$homePageCrumbName,$queryString,$crumbRouteStartPosition,0) . "<br /><br />";
	
	
	if (isset($_GET['tag_id']) and $_GET['tag_id']!="")
	{	
		$tag_id = $_GET['tag_id'];

		// Storing Passed Tag Name  
		$sql_tag = "SELECT tag_name,tag_activeFlag FROM tag WHERE tag_id=$tag_id"; 
		$results_tag = mysqli_query($link,$sql_tag);
		echo (!$results_tag?die(mysqli_error($link)."<br />$sql_tag"):"");	
		list($tag_name,$tag_activeFlag) = mysqli_fetch_array($results_tag);
			
		// Display Tag Status to User
		echo "<br />Tag, <b>$tag_name</b>, is currently set to ";
		if ($tag_activeFlag == 1) { echo "<b>Active</b>"; }  else { echo "<b>Inactive</b>"; }
		echo " status";
		echo "<br /><br />";
		
		if ($tag_activeFlag == 1) { $formButtonName = "Inactivate Tag"; }  else { $formButtonName = "Activate Tag"; } 
		if ($tag_activeFlag == 1) { $newFormValue = 0; }  else { $newFormValue = 1; }
		
		// Start Area Form
		echo "<form method='post' action=''>";
		echo "<input type='hidden' name='tag_activeFlag' value='$newFormValue'>"; // Set Value of 0 = Set Area to Inactive | Set Value of 1 = Set Area to Active
		echo "<br /><br />";
		echo "<input type='submit' value='$formButtonName'>";
		echo "</form>";
		
		
		if (isset($_POST['tag_activeFlag']) and $_POST['tag_activeFlag']!="")
		{
			$tag_activeFlag = $_POST['tag_activeFlag']; 
			
			$sql_newActiveFlag = "UPDATE tag SET tag_activeFlag=$tag_activeFlag WHERE tag_id=$tag_id";
			$results_newActiveFlag = mysqli_query($link,$sql_newActiveFlag);
			echo (!$results_newActiveFlag?die(mysqli_error($link)."<br />".$sql_newActiveFlag):"");
			
			// Report Back to User > Check Tag Table
			$sql_check = "SELECT tag_id FROM tag WHERE tag_id=$tag_id AND tag_name='$tag_name' AND tag_activeFlag=$tag_activeFlag";
			$results_check = mysqli_query($link,$sql_check);	
			echo (!$results_check?die(mysqli_error($link)."<br />".$sql_check):"");
			
			$countTag = mysqli_num_rows($results_check);
		
			if ($tag_activeFlag == 1) { $newStatusUpdate = "Active"; }  else { $newStatusUpdate = "Inactive"; } 
		
			if ($countTag > 0) {   
				echo "<br /><br />";
				echo "The status for Tag, <b>$tag_name</b>, has been changed successfully to: <b>$newStatusUpdate</b>.";
			} else {
				echo "<br /><br />";
				echo "There was a problem with your request for Tag: <b>$tag_name</b>.  Please try again or contact support. <br /><br />";
				echo "Reference: <br />";
				echo "<ul><li>Tag Id: $tag_id</li><li>Tag Name: $tag_name</li><li>Request to set Active Status to: $tag_activeFlag</li>";
			}
		}
		
	} else {  // If GET Requests are not set
		echo "<br /><br /> <b>There was a problem with your request.</b> <br /><br />";  
		echo "Please return to the <a href='$base_url/dashboard.php'>Dashboard</a>";
	}
?>

		
</body>
</html>