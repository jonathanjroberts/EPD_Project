<html>

<head>
	<title>Admin > Menu > Tag Table > Edit</title>
</head>

<body>

<!-- http://localhost/PMBA/EPD/public/admin/tag/edit.php -->

<br /> <h2> Admin > Menu > Tag Table > Edit </h2> <hr />

<!-- Start: Global Include Files -->
<?php
	include('../../UtilityIncludes/globalIncludes.php');
?>
<!-- End: Global Include Files -->


<?php
	// Toggle Breadcrumbs
	echo breadcrumbs($base_url,$homePageFileName,$homePageCrumbName,$queryString,$crumbRouteStartPosition,0) . "<br /><br />";
	
	// Link Back to Admin Menu > Area 
	echo "<br /><a href='$base_url/admin/tag/list.php$queryString[0]'>Return to Admin Tag List</a><br />";
	
	// Link Back to Admin Menu
	echo "<br /><a href='$base_url/admin/default.php$queryString[0]'>Return to Admin Menu</a><br />";
	
	// Link Back to Dashboard
	echo "<br /><a href='$base_url/dashboard.php$queryString[0]'>Return to Dashboard</a><br />";
	echo "<br /><br />";
	
	// Get Current List of Areas
	$areaList = getCurrentListForValue($link,"area","area_id","area_name");

	if (isset($_GET['tag_id']) and $_GET['tag_id']!="")
	{	
		$tag_id = $_GET['tag_id'];

		// Storing Passed Tag Name  
		$sql_tag = "SELECT tag_id,tag_name,area_id FROM tag"; 
		$results_tag = mysqli_query($link,$sql_tag);
		echo (!$results_tag?die(mysqli_error($link)."<br />$sql_tag"):"");	
		list($tag_id,$tag_name,$area_id) = mysqli_fetch_array($results_tag);
		
		// Store Existing Tag Name as Temp - for success/failure event output
		$existingTagName_temp = $tag_name;
		$existingAreaId_temp = $area_id;
		
		// Display Tag to User
		echo "<br /> <b>Edit Tag Information for: </b> $tag_name<br /><br /><br />";
		
		// Start Tag Form
		echo "<form method='post' action=''>";
		echo "<input type='hidden' name='tag_id' value='$tag_id'>";
		echo "<b>Edit Tag's Name:</b> <br />	<input name='tag_name' placeholder='$tag_name'></input><br /><br />";
		echo "<b>Tag Currently belongs to Area:</b> <br /> ";
		echo "<select name='selectArea'>";
		echo "		<option value='0' disabled selected>- Select Area -</option>";				
					foreach($areaList as $areaId => $areaValue){						
						echo "<option value='$areaId' ";
						if ($areaId == $area_id) {  // if statement for setting selectbox to $area_id
							echo "selected";
							$area_name = $areaValue;
						}
						echo " >$areaValue</option>";
					}
		echo "</select>";					
								
		echo "<br /><br /><br />";
		echo "<input type='submit' value='Update Tag'>";
		echo "</form>";
		
		
		if (isset($_POST['tag_name']) and $_POST['tag_name']!="")
		{
			$tag_id = $_POST['tag_id'];
			$tag_name = $_POST['tag_name']; 
			$area_id  = $_POST['selectArea']; 
			
			// Before Change > Report Back to User > Check Table
			$sql_check = "SELECT tag_id FROM tag WHERE tag_id=$tag_id AND tag_name='$tag_name' AND area_id=$area_id";
			$results_check = mysqli_query($link,$sql_check);	
			echo (!$results_check?die(mysqli_error($link)."<br />".$sql_check):"");
			
			$countNewName = mysqli_num_rows($results_check);
		
			if ($countNewName > 0) {   // Infers the New Name is Unique
				echo "<br /><br />";
				echo "The Tag Name and Area you entered is already present in the database.  Please try another request or contact support. <br />";			
			} else { 	
				$sql_edit = "UPDATE tag SET tag_name='$tag_name',area_id=$area_id WHERE tag_id=$tag_id";
				$results_edit = mysqli_query($link,$sql_edit);
				echo (!$results_edit?die(mysqli_error($link)."<br />".$sql_edit):"");

				// Get Area Name
				$sql_getAreaName = "SELECT area_name FROM area WHERE area_id=$area_id";
				$results_getAreaName = mysqli_query($link,$sql_getAreaName);
				echo (!$results_getAreaName?die(mysqli_error($link)."<br />".$sql_getAreaName):"");
				
				list($area_name) = mysqli_fetch_array($results_getAreaName);
				
				// After Change > Report Back to User > Check Table
				$sql_check = "SELECT tag_id FROM tag WHERE tag_id=$tag_id AND tag_name='$tag_name' AND area_id=$area_id";
				$results_check = mysqli_query($link,$sql_check);	
				echo (!$results_check?die(mysqli_error($link)."<br />".$sql_check):"");
				
				$countTag = mysqli_num_rows($results_check);
				
				if ($countTag > 0) {  
					echo "<br /><br />";
					echo "Tag, <b>" . $existingTagName_temp . "</b>, has been updated successfully to <b>$tag_name</b>. <br />";
					echo "Tag is listed under Area: " . $area_name . "<br />";
				} else {
					echo "<br /><br />";
					echo "There was a problem updating Section: <b>" . $existingTagName_temp . " </b>, to <b>" . $tag_name . "</b>.<br />"; 					
					echo "Please try again or contact support. <br /><br />";
					echo "Reference: <br />";
					echo "<ul><li>Tag Id: $tag_id</li>";
					echo "<li>Exisiting Tag Name: <b>" . $tag_name . "</b></li>";
					echo "<li>Exisiting Area_id: " . $existingAreaId_temp . " / New Area Id: <b>" . $area_Id . "</b></li>";
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