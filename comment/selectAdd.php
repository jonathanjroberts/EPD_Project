<html>

<head>
	<title> Section > Equipment > Add Comment</title>
	<style> 
		th {text-decoration: underline;}
		td {text-align:center;} 
	</style>
</head>

<body>

<!-- http://localhost/PMBA/EPD/public/comment/selectAdd.php -->

<br /> <h2> Dashboard > Add Comment </h2> <hr />

<!-- Start: Global Include Files -->
<?php
	include('../UtilityIncludes/globalIncludes.php');
?>
<!-- End: Global Include Files -->


<!-- Start: Get Section Records -->
<?php
	// Toggle Breadcrumbs
	echo breadcrumbs($base_url,$homePageFileName,$homePageCrumbName,$queryString,$crumbRouteStartPosition,0) . "<br /><br />";
	
	// Get Current List of Sections
	$sql_sectionList = "SELECT section_id,section_name FROM section";
	$results_sectionList = mysqli_query($link,$sql_sectionList);
	echo (!$results_sectionList?die(mysqli_error($link)."<br />$sql_sectionList"):"");
	
	while(list($section_id,$section_name) = mysqli_fetch_array($results_sectionList)){
		$input[$section_id] = $section_name; 
	}
	$sectionList = array_unique($input);
	
?>
<!--  End: Get Section Records -->


<!-- Start: Select Section / Select Dependent Equipment -->
<br /> <h3> Add New Comment</h3> <hr />
<?php
	if (isset($_GET['area_id']) and $_GET['area_id']!="")
	{	
		$area_id = $_GET['area_id'];
		
		if (!isset($_GET['section_id']))
		{
			echo "<form method='get' action=''>";
			echo "<input type='hidden' name='area_id' value='$area_id'>";
			echo "<b>Select Section:</b> <select name='section_id'>";
			echo "<option value='0' disabled selected>- Select Section -</option>";
				foreach($sectionList as $sectionId => $sectionValue){
					echo "<option value='$sectionId'>$sectionValue</option>";
				}
			echo "</select>";
			echo "<input type='submit' value='Next >'>";
			echo "</form>";
		}


		// Start Equipment Selection and Comment Add
		if (isset($_GET['section_id']) and $_GET['section_id']!="")
		{
			// Get selection for Section
			//$area_id = $_GET['area_id'];
			$section_id = $_GET['section_id']; 
			
			// Allows user to reslect Section after initial selection
			echo "<form method='get' action=''>";
			echo "<b>Select Section:</b> <select name='section_id'>";
			echo "<option value='0' disabled selected>- Select Section -</option>";
				foreach($sectionList as $sectionId => $sectionValue){
					// echo "<option value='$sectionId'>$sectionValue</option>";
					echo "<option value='$sectionId' ";
					if ($sectionId == $section_id) {  // if statement for setting selectbox to $section_id
						echo "selected";
					}
					echo " >$sectionValue</option>";
				}
			echo "</select>";
			echo "<input type='submit' value='Next >'>";
			echo "</form>";
			echo "<br />";
			
			// Start Equipment Drop Down List Portion
			$sql_equipmentList = "SELECT equipment_id,equipment_shortname FROM equipment WHERE section_id=$section_id";
			$results_equipmentList = mysqli_query($link,$sql_equipmentList);
			echo (!$results_equipmentList?die(mysqli_error($link)."<br />$sql_equipmentList"):"");
		
			while(list($equipment_id,$equipment_name) = mysqli_fetch_array($results_equipmentList)){
				$equipmentList[$equipment_id] = $equipment_name; 
			}
			
			// Select Equipment and Comment
			echo "<form enctype='multipart/form-data' action='' method='POST'>";
			echo "<input type='hidden' name='MAX_FILE_SIZE' value='3000000' />";
			echo "<b>Select Equipment:</b>	<select name='equipment_id'>";
			echo "<option value='0' disabled selected>- Select Equipment -</option>";
				foreach($equipmentList as $equipmentId => $equipmentValue){;
					echo "<option value='$equipmentId'>$equipmentValue</option>";
				}
									
			echo "</select>";
			echo "<br /><br />";
			echo "<b>Add New Comment:</b> <br />	<textarea rows='4' cols='50' name='textComment'></textarea><br />";
			echo "<br /><br />";
			echo "Choose a file to upload: <input name='file' type='file' />";
			echo "<input type='submit' value='Add New Comment'>";
			echo "</form>";
			
			// Select Equipment and Comment
			/*echo "<form method='post' action=''>";
			echo "<b>Select Equipment:</b>	<select name='equipment_id'>";
			echo "<option value='0' disabled selected>- Select Equipment -</option>";
				foreach($equipmentList as $equipmentId => $equipmentValue){;
					echo "<option value='$equipmentId'>$equipmentValue</option>";
				}
									
			echo "</select>";
			echo "<br /><br />";
			echo "<b>Add New Comment:</b> <br />	<textarea rows='4' cols='50' name='textComment'></textarea><br />";
			echo "<br /><br />";
			echo "<input type='submit' value='Add New Comment'>";
			echo "</form>"; */
		}
		
	echo "<br /><hr /><br /> <a href='"; include '../UtilityIncludes/route.php';  echo "dashboard.php?area_id=$area_id'>Return to Dashboard</a>";
	
	} else {  // If GET Requests are not set
		echo "<br /><br />";
		echo "<b>There was a problem with your request.</b> <br /><br />";
		echo "Please return to the <a href='$base_url/dashboard.php'>Dashboard</a> and try again";
	}
?>
<!-- End: Select Section / Select Dependent Equipment -->

<!-- Start: Add Record -->
<?php
	if (isset($_POST['textComment']) and $_POST['textComment']!="")
	{
		$comment_value = $_POST['textComment']; 
		$section_id = $_GET['section_id'];
		$equipment_id = $_POST['equipment_id']; 
		
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
		
		include("../UtilityIncludes/uploadAndResizeImage.php");
		
		// Updating DB Tables
			/* Insert into Database - Comment Table
			$sql_addComment = "INSERT INTO comment(section_id,equipment_id,comment_value,comment_image_url,comment_imageThumb_url) VALUES($section_id,$equipment_id,'$comment_value','$filename','$filenameThumb')";
			$results_addComment = mysqli_query($link,$sql_addComment);
			echo (!$results_addComment?die(mysqli_error($link)."<br />".$sql_addComment):""); */
			
			// Insert into Database - Section Table
			$sql_updateSectionShowFlag = "UPDATE section SET section_showFlag=1 where section_id=section_id";
			$results_updateSectionShowFlag  = mysqli_query($link,$sql_updateSectionShowFlag );
			echo (!$results_updateSectionShowFlag ?die(mysqli_error($link)."<br />".$sql_updateSectionShowFlag ):"");
		
		// Report Back to User
			// Check Comment Table
			$sql_checkComment = "SELECT comment_id FROM comment WHERE section_id=$section_id AND equipment_id=$equipment_id AND comment_value='$comment_value'";
			$results_checkComment = mysqli_query($link,$sql_checkComment);	
			echo (!$results_checkComment?die(mysqli_error($link)."<br />".$sql_checkComment):"");
			
			$countComment = mysqli_num_rows($results_checkComment);
				
			// Check Section Table: Look for Section Show Flag = 1 
			$sql_checkSection = "SELECT section_id FROM section WHERE section_id=$section_id AND section_showFlag=1";
			$results_checkSection = mysqli_query($link,$sql_checkSection);	
			echo (!$results_checkSection?die(mysqli_error($link)."<br />".$sql_checkSection):"");
			
			$countSection = mysqli_num_rows($results_checkSection);
			
		/* Testing */ // echo "<br /> Count Comment: " . $countComment . "<br />";
		/* Testing */ // echo "<br /> Count Section: " . $countSection . "<br /><br />";
		if ($countComment > 0 and $countSection > 0){
			echo "<br /><br />";
			echo "Your new comment has been added";
		} else {
				echo "<br /><br />";
				echo "There was a problem adding your comment. Please try again or contact support. <br /><br />";
				echo "Reference: <br />";
				echo "<ul><li>Area Id: $area_id</li>";
				echo "<li>Section Id: $section_id</li>";
				echo "<li>Equipment Id: $equipment_id</li>";
				echo "<li>Comment Id: $comment_id</li></ul>";
		}
		
	}
?>
<!-- End: Add Record -->


</body>
</html>