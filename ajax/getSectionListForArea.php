

<!-- Start: Global Include Files -->
<?php
	include('../UtilityIncludes/globalIncludes.php');
?>
<!-- End: Global Include Files -->


<?php
	$area_id = intval($_GET['q']);

	$sql_sectionList = "SELECT section.section_id,section.section_name 
			FROM section,equipment 
			WHERE section.area_id=$area_id AND section.section_activeFlag=1 AND equipment.section_id=section.section_id";
			

	$results_sectionList = mysqli_query($link,$sql_sectionList);
			echo (!$results_sectionList?die(mysqli_error($link)."<br />$sql_sectionList"):"");
	
	while(list($section_id,$section_name) = mysqli_fetch_array($results_sectionList)){
				$input_section[$section_id] = $section_name; 
			}
			
	if (empty($input_section) == FALSE) {
			$sectionList = array_unique($input_section);
		} else { 
			$sectionList = array("- None - ");
		}
	
	
/*
	echo "<form method='get' action=''>";
	echo "Select Section: <select name='sections' onchange='getCommentListForSection(this.value)'>"; //"<select name='section_id'>";
	echo "<option value='0' disabled selected>- Select Section -</option>";
		foreach($sectionList as $sectionId => $sectionValue){
			echo "<option value='$sectionId'>$sectionValue</option>";
		}
	echo "</select>";
	echo "</form>";		
	echo "  |  <a href='comment/selectAdd.php?area_id=$area_id'>Add New Comment</a>";
	//echo "<div id='commentList'><b>Comment Results List for Area+Section will be given Here</b></div>";
			
			
	// Start - Ajax pull for Results
	echo "<table>";
	echo "<tr>";
	echo "<th width='50px'></th>"; // Left Gutter
	echo "<th width='100px'></th>"; // Comment[datetime_created] 
	echo "<th width='500px'></th>"; // Equipment[equipment_shortname] | Comment[comment_value] | Comment [Add]
	echo "<th width='100px'></th>"; // Section[section_name] | Comment[user_id]
	echo "<th width='150px'></th>";
	echo "</tr>"; 	
	echo "<tr> <td><hr /></td> <td><hr /></td> <td><hr /></td> <td><hr /></td> <td><hr /></td> </tr>";

	foreach ($sectionList as $section_id => $section_name) {
		echo "<tr><td> </td></tr>";
		echo "<tr>";
		echo "<td></td> <td><h3>Section: $section_name</h3></td> <td></td> <td></td> <td></td> <td></td>";
		echo "</tr>";
			
		$sql_visableEquipmentList_in_Section = "SELECT equipment_id,equipment_shortname FROM equipment WHERE section_id=$section_id AND equipment_activeFlag=1";
		
		$results_visableEquipmentList_in_Section = mysqli_query($link,$sql_visableEquipmentList_in_Section);
		echo (!$results_visableEquipmentList_in_Section?die(mysqli_error($link)."<br />$sql_visableEquipmentList_in_Section"):"");
		
		while(list($equipment_id,$equipment_shortname) = mysqli_fetch_array($results_visableEquipmentList_in_Section)){		
			echo "<tr>";
			echo "<td></td> <td></td>  <td><b>Equipment: $equipment_shortname</b></td> <td></td> <td></td>";
			echo "</tr>";	
			
				$sql_visableCommentList_in_Equipment = "SELECT comment_id,comment_value,user_id,datetime_created FROM comment WHERE equipment_id=$equipment_id AND comment_showFlag=1";
				$results_visableCommentList_in_Equipment = mysqli_query($link,$sql_visableCommentList_in_Equipment);
				echo (!$results_visableCommentList_in_Equipment?die(mysqli_error($link)."<br />$sql_visableCommentList_in_Equipment"):"");
				
				// Show Active Comments for Equipment Id
				while(list($comment_id,$comment_value,$user_id,$datetime_created) = mysqli_fetch_array($results_visableCommentList_in_Equipment)){		
						echo "<tr>";
						echo "<td></td> <td><b>$datetime_created:</b></td> <td>$comment_value</td> <td>$user_id</td> <td><a href='comment/show_or_hide.php?area_id=$area_id&section_id=$section_id&equipment_id=$equipment_id&comment_id=$comment_id'>Hide</a> | <a href='comment/edit.php?area_id=$area_id&section_id=$section_id&equipment_id=$equipment_id&comment_id=$comment_id'>Edit</a> | <a href='comment/delete.php?comment_id=$comment_id'>Delete</a> </td>";
						echo "</tr>";
				}					
			// Add Comment for Equipment Id
			echo "<tr>";
			echo "<td></td> <td></td> <td><a href='comment/add.php?area_id=$q&section_id=$section_id&equipment_id=$equipment_id'>Add New Comment</a></td> <td></td> <td></td>";
			echo "</tr>";
			echo "<tr><td> <br /> </td></tr>";
		}
		echo "<tr> <td><hr /></td> <td><hr /></td> <td><hr /></td> <td><hr /></td> <td><hr /></td> </tr>";
	}
	
	echo "</table>";

mysqli_close($link);
*/
?>