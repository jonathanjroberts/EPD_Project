<html>

<head>
	<title>Section > Equipment > Add Comment</title>
</head>

<body>

<!-- http://localhost/PMBA/EPD/public/comment/add.php -->

<br /> <h2> Section > Equipment > Add Comment </h2> <hr />

<!-- Start: Global Include Files -->
<?php
	include('../UtilityIncludes/globalIncludes.php');
?>
<!-- End: Global Include Files -->


<?php
	// Toggle Breadcrumbs
	echo breadcrumbs($base_url,$homePageFileName,$homePageCrumbName,$queryString,$crumbRouteStartPosition,0) . "<br /><br />";
	
	if (isset($_GET['section_id']) and isset($_GET['equipment_id']) and $_GET['section_id']!="" and $_GET['equipment_id']!="")
	{	
		$area_id = $_GET['area_id'];
		$section_id = $_GET['section_id'];
		$equipment_id = $_GET['equipment_id'];
	
		// Storing Passed Section Name  
		$sql_section = "SELECT section_name FROM section WHERE section_id=$section_id"; 
		$results_section = mysqli_query($link,$sql_section);
		echo (!$results_section?die(mysqli_error($link)."<br />$sql_section"):"");	
		list($section_name) = mysqli_fetch_array($results_section);
		
		// Storing Passed Equipment Short Name  
		$sql_equipment = "SELECT equipment_shortname FROM equipment WHERE equipment_id=$equipment_id"; 
		$results_equipment = mysqli_query($link,$sql_equipment);
		echo (!$results_equipment?die(mysqli_error($link)."<br />$sql_equipment"):"");
		list($equipment_shortname) = mysqli_fetch_array($results_equipment);
		
		/* Getting Available Tags Passed 
		$sql_tagList = "SELECT tag_id,tag_name FROM tag WHERE area_id=$area_id"; 
		$results_tagList = mysqli_query($link,$sql_tagList);
		echo (!$results_tagList?die(mysqli_error($link)."<br />$sql_tagList"):"");
		
		
		while(list($tag_id,$tag_name) = mysqli_fetch_array($results_tagList)){
			$input_tag[$tag_id] = $tag_name; 
		}
		$tagList = array_unique($input_tag); */
		
		// Display Section and Equipment to User
		echo "<br /> <b>Section:</b> $section_name > <b>Equipment:</b> $equipment_shortname <hr /><br /><br />";
		
		// Start Comment Form
		echo "<form enctype='multipart/form-data' action='' method='POST'>";
		echo "<input type='hidden' name='MAX_FILE_SIZE' value='3000000' />";
		echo "<b>Add New Comment:</b> <br />	<textarea rows='4' cols='50' name='textComment'></textarea><br />";
		echo "<br /><br />";
		echo "Choose a file to upload: <input name='file' type='file' />";
		echo "<input type='submit' value='Add New Comment'>";
		echo "</form>";
		
		// Link Back to Dashboard
		echo "<br /><hr /><br /> <a href='$base_url/dashboard.php?area_id=$area_id&section_id=$section_id'>Return to Dashboard</a> <br />";
		
		if (isset($_POST['textComment']) and $_POST['textComment']!="")
		{
			$comment_value = $_POST['textComment']; 
		
			if (isset($_POST['file'])) {  // Only send Picture if User selected
				include("../UtilityIncludes/uploadAndResizeImage.php");
				
				$sql_addComment = "INSERT INTO comment(section_id,equipment_id,comment_value,comment_image_url,comment_imageThumb_url,user_id) VALUES($section_id,$equipment_id,'$comment_value','$filename','$filenameThumb',$userId)";
				$results_addComment = mysqli_query($link,$sql_addComment);
				echo (!$results_addComment?die(mysqli_error($link)."<br />".$sql_addComment):"");
			} else {
				$sql_addComment = "INSERT INTO comment(section_id,equipment_id,comment_value,user_id) VALUES($section_id,$equipment_id,'$comment_value',$userId)";
				$results_addComment = mysqli_query($link,$sql_addComment);
				echo (!$results_addComment?die(mysqli_error($link)."<br />".$sql_addComment):"");
				
			}
			
			// Report Back to User > Check Comment Table
			$sql_checkComment = "SELECT comment_id FROM comment WHERE section_id=$section_id AND equipment_id=$equipment_id AND comment_value='$comment_value' AND user_id=$userId";
			$results_checkComment = mysqli_query($link,$sql_checkComment);	
			echo (!$results_checkComment?die(mysqli_error($link)."<br />".$sql_checkComment):"");
			
			$countComment = mysqli_num_rows($results_checkComment);
			
			if ($countComment > 0){
				echo "<br /><br />";
				echo "Your comment has been updated successfully for $section_name  >  Equipment Id: $equipment_shortname";
			} else {
				echo "<br /><br />";
				echo "There was a problem adding your comment. Please try again or contact support. <br /><br />";
				echo "Reference: <br />";
				echo "<ul><li>Area Id: $area_id</li><li>Area Name: $area_name</li>";
				echo "<li>Section Id: $section_id</li><li>Section Name: $section_name</li>";
				echo "<li>Equipment Id: $equipment_id</li><li>Equipment Name: $equipment_shortname</li>";
				echo "<li>Comment Id: $comment_id</li><li>Comment Value: $comment_value</li></ul>";
			}
		}
		
	} else {  // If GET Requests are not set
		echo "<br /><br /> <b>There was a problem with your request.</b> <br /><br />";
		echo "Please return to the <a href='$base_url/dashboard.php'>Dashboard</a> and try again";
	}
?>


	
		
</body>
</html>