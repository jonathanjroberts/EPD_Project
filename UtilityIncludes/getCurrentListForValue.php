<?php
	function getCurrentListForValue($link,$tableNameForValue,$value_id,$value_name)
	{
		$sql_valueList = "SELECT " . $value_id . "," . $value_name . " FROM " . $tableNameForValue;
		$results_valueList = mysqli_query($link,$sql_valueList);
		echo (!$results_valueList?die(mysqli_error($link)."<br />$sql_valueList"):"");
		
		if (!$results_valueList) {
			//echo (!$results_valueList?die(mysqli_error($link)."<br />$sql_valueList"):"");
			die(mysqli_error($link)."<br />$sql_valueList");
			$valueList[] = $sql_valueList;
		} else {
			while(list($value_id,$value_name) = mysqli_fetch_array($results_valueList)){
				$input[$value_id] = $value_name; 
			}
			$valueList = array_unique($input);
		} 
		
		return $valueList; 
	}
	
	function getCurrentListForValueBySelection($link,$tableNameForValue,$value_id,$value_name,$selection_id,$GETRequest_selection_Id)
	{
		$sql_valueList = "SELECT " . $value_id . "," . $value_name . " FROM " . $tableNameForValue . " WHERE " . $selection_id . " = " . $GETRequest_selection_Id;
		$results_valueList = mysqli_query($link,$sql_valueList);
		echo (!$results_valueList?die(mysqli_error($link)."<br />$sql_valueList"):"");
		
		if (!$results_valueList) {
			//echo (!$results_valueList?die(mysqli_error($link)."<br />$sql_valueList"):"");
			die(mysqli_error($link)."<br />$sql_valueList");
			$valueList[] = $sql_valueList;
		} else {
			while(list($value_id,$value_name) = mysqli_fetch_array($results_valueList)){
				$input[$value_id] = $value_name; 
			}
			if (isset($input)) {
				$valueList = array_unique($input);
			} else {
				$valueList = ""; // which would essentially return an empty value
			}
		} 
		
		return $valueList; 
	}
	
?>