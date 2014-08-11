<?php
	
	include('../UtilityIncludes/globalIncludes.php');
	
		$area_id = intval($_GET['area']);
		
		$sql_sectionList = "SELECT section.section_id,section.section_name 
			FROM section, equipment, comment
			WHERE section.area_id=$area_id AND section.section_activeFlag=1 AND equipment.section_id=section.section_id";// AND comment.comment_showFlag=1";

		$results_sectionList = mysqli_query($link,$sql_sectionList);
			echo (!$results_sectionList?die(mysqli_error($link)."<br />$sql_sectionList"):"");
		
		$input_section[] = "- Select Section -";
		while(list($section_id,$section_name) = mysqli_fetch_array($results_sectionList)){
			$input_section[$section_id] = $section_name; 
		}
				
		if (empty($input_section) == FALSE) {
			$sectionList = array_unique($input_section);
		} else { 
			$sectionList = array("- None - ");
		}
		
		$section = $sectionList;
	echo json_encode($section);

?>