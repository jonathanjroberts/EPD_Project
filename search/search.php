<html>

<head>
	<title>Search</title>
	<style> 
		th {text-decoration: underline;}
		td {text-align:left; padding-left:10px; vertical-align:top;} 
		h3 {padding-top: 20px; font-weight: bold; text-decoration: underline;}
	</style>
</head>

<body>


<!-- http://localhost/PMBA/EPD/public/search/search.php -->

<br /> <h2> Search </h2> <hr />



<!-- Start: Global Include Files -->
<?php
	include('../UtilityIncludes/globalIncludes.php');
?>
<!-- End: Global Include Files -->


<?php

	// Toggle Breadcrumbs
	echo breadcrumbs($base_url,$homePageFileName,$homePageCrumbName,$queryString,$crumbRouteStartPosition,0) . "<br />";
	
	// Link Back to Dashboard
	echo "<br /><a href='$base_url/dashboard.php'>Return to Dashboard</a>";
	echo "<br /><br />";

	// Get Current List of Areas
	$sql_areaList = "SELECT area_id,area_name FROM area WHERE area_activeFlag=1";
	$results_areaList = mysqli_query($link,$sql_areaList);
	echo (!$results_areaList?die(mysqli_error($link)."<br />$sql_areaList"):"");
	
	while(list($area_id,$area_name) = mysqli_fetch_array($results_areaList)){
		$input_area[$area_id] = $area_name; 
	}
	$areaList = array_unique($input_area);


	if (isset($_GET['term']) and isset($_GET['area_id']) and $_GET['term']!='' and $_GET['area_id']!='') {
		$sTerm = $_GET['term'];
		$area_id = $_GET['area_id'];

		$sql = "SELECT comment.datetime_created,comment.comment_value,comment.user_id,comment.equipment_id,equipment.equipment_id,equipment.equipment_shortname,equipment.section_id,section.section_id,section.section_name FROM 
				comment,equipment,section 
				WHERE (comment_value like '%$sTerm%' or datetime_created like '%$sTerm%') AND area_id=$area_id AND comment.equipment_id=equipment.equipment_id AND equipment.section_id=section.section_id";
				
		$results = mysqli_query($link,$sql);
		echo (!$results?die(mysqli_error($link)."<br>$sql"):"");
		
		echo "<table>";
		echo "<tr>";
		echo "<th width='60px'></th>"; // Left Gutter
		echo "<th width='110px'></th>"; // Comment[datetime_created] 
		echo "<th width='160px'></th>"; // Equipment[equipment_shortname] | Comment[comment_value] | Comment [Add]
		echo "<th width='500px'></th>"; // Section[section_name] | Comment[user_id]
		echo "<th width='150px'></th>";
		echo "</tr>"; 	
		echo "<tr> <td><hr /></td> <td><hr /></td> <td><hr /></td> <td><hr /></td> <td><hr /></td> </tr>";
		
		echo "<tr>";
		echo "<td><b><u>Section:</u></b></td> <td><b><u>Equipment</u></b></td>  <td><b><u>Date & Time:</u></b></td> <td><b><u>Comments:</u></b></td> <td><b><u>User:</u></b></td>";
		echo "</tr>";	
			
		while(list($comment_datetime_created,$comment_comment_value,$comment_user_id,$comment_equipment_id,$equipment_equipment_id,$equipment_equipment_shortname,$equipment_section_id,$section_section_id,$section_section_name ) = mysqli_fetch_array($results)) {
			echo "<tr>";
			echo "<td>$section_section_name</td> <td>$equipment_equipment_shortname</td>  <td>$comment_datetime_created</td> <td>$comment_comment_value</td> <td>$comment_user_id</td>";
			echo "</tr>";

			//echo "$bookId $bookName <img src='images/$bookImage'><br>Price: $bookPrice<br>";
		}
		
		
	}

?>

	<form method='get' action=''>
		Select Area: <select name='area_id'>";
		<option value='0' disabled selected>- Select Area -</option>";
		<?php
			foreach($areaList as $areaId => $areaValue){
				echo "<option value='$areaId'>$areaValue</option>";
			}
		?>
		</select>
		Search Term: <input type='text' name='term'><br />
		<input type='submit' value='Go'>
	</form>

</body>
</html>

