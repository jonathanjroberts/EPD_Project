<html>

<head>
	<title>Section > Equipment > Change Comment Show/Hide Status</title>
</head>

<body>

<body>

<!-- http://localhost/PMBA/EPD/public/comment/add.php -->

<br /> <h2> Section > Equipment > Change Comment Show/Hide Status</h2> <hr />

<!-- Start: Global Include Files -->
<?php
	include('../UtilityIncludes/globalIncludes.php');
?>
<!-- End: Global Include Files -->


<?php
	// Toggle Breadcrumbs
	echo breadcrumbs($base_url,$homePageFileName,$homePageCrumbName,$queryString,$crumbRouteStartPosition,0) . "<br /><br />";
	
	if (isset($_GET['area_id']) and isset($_GET['section_id']) and isset($_GET['equipment_id']) and isset($_GET['comment_id']) and $_GET['area_id']!="" and $_GET['section_id']!="" and $_GET['equipment_id']!="" and $_GET['comment_id']!="")
	{	
		$area_id = $_GET['area_id'];
		$section_id = $_GET['section_id'];
		$equipment_id = $_GET['equipment_id'];
		$comment_id = $_GET['comment_id'];
	
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
	
		// Storing Passed Comment Value  
		$sql_commentValue = "SELECT comment_value FROM comment WHERE comment_id=$comment_id"; 
		$results_commentValue = mysqli_query($link,$sql_commentValue);
		echo (!$results_commentValue?die(mysqli_error($link)."<br />$sql_commentValue"):"");	
		list($comment_value) = mysqli_fetch_array($results_commentValue);
		
		// Storing Passed Comment Show Flag  
		$sql_commentShowFlag = "SELECT comment_showFlag FROM comment WHERE comment_id=$comment_id"; 
		$results_commentShowFlag = mysqli_query($link,$sql_commentShowFlag);
		echo (!$results_commentShowFlag?die(mysqli_error($link)."<br />$sql_comment"):"");	
		list($comment_showFlag) = mysqli_fetch_array($results_commentShowFlag);
		
		// Display Section and Equipment to User
		echo "<br /> <b>Section:</b> $section_name > <b>Equipment:</b> $equipment_shortname <hr /><br /><br />";
		echo "<br />";
		echo "<b>Comment: </b>$comment_value";
		echo "<br /><br />";
		echo "<b>Is currently set to: </b>"; if ($comment_showFlag == 1) {echo "Show"; } else { echo "Hide"; }
		echo "<br /><br /><br />";
		
		// Start Comment Form
		echo "<form method='post' action=''>";
		echo "<input type='hidden' name='comment_showFlag' value='0'>"; // Value of 0 = Set Comment to Hide | Value of 1 = Set Comment to Show
		echo "<input type='submit' value='Hide Comment'>";
		echo "</form>";
		
		// Link Back to Dashboard 
		echo "<br /><hr /><br /> <a href='$base_url/dashboard.php?area_id=$area_id&section_id=$section_id'>Return to Dashboard</a> <br />";
		
		if (isset($_POST['comment_showFlag']) and $_POST['comment_showFlag']!="")
		{
			$comment_showFlag = $_POST['comment_showFlag']; 
		
			$sql_hideComment = "UPDATE comment SET comment_showFlag=$comment_showFlag WHERE comment_id=$comment_id";
			$results_hideComment = mysqli_query($link,$sql_hideComment);
			echo (!$results_hideComment?die(mysqli_error($link)."<br />".$sql_hideComment):"");
			
			// Report Back to User > Check Comment Table
			$sql_checkComment = "SELECT comment_id FROM comment WHERE comment_id=$comment_id AND comment_value='$comment_value' AND comment_showFlag=$comment_showFlag";
			$results_checkComment = mysqli_query($link,$sql_checkComment);	
			echo (!$results_checkComment?die(mysqli_error($link)."<br />".$sql_checkComment):"");
			
			$countComment = mysqli_num_rows($results_checkComment);
			
			if ($comment_showFlag == 1) { $newStatusUpdate = "Shown"; }  else { $newStatusUpdate = "Hidden"; } 
			
			if ($countComment > 0){
				echo "<br /><br />";
				echo "Your comment for $section_name  >  Equipment Id: $equipment_shortname has been changed successfully to: <b>$newStatusUpdate</b>.";
				//echo "The status for Area, <b>$area_name</b>, has been changed successfully to: <b>$newStatusUpdate</b>.";
			} else {
				echo "<br /><br />";
				echo "There was a problem hiding your comment. Please try again or contact support. <br /><br />";
				echo "Reference: <br />";
				echo "<ul><li>Area Id: $area_id</li><li>Area Name: $area_name</li>";
				echo "<li>Section Id: $section_id</li><li>Section Name: $section_name</li>";
				echo "<li>Equipment Id: $equipment_id</li><li>Equipment Name: $equipment_shortname</li>";
				echo "<li>Comment Id: $comment_id</li><li>Comment Value: $comment_value</li></ul>";
			}
		}
		
	} else {  // If GET Requests are not set
		echo "<br /><br /> <b>There was a problem with your request.</b> <br /><br />";
		echo "Please return to the <a href='$base_url/dashboard.php'>Dashboard</a>";
	}
?>


	
		
</body>
</html>