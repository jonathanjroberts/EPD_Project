<?php
	
	function perform_SQLQuery($link,$sqlString)
	{
		$results = mysqli_query($link,$sqlString);
		echo (!$results?die(mysqli_error($link)."<br />$sqlString"):"");	
		
		return $results;
	}
	
	function perform_SQLQuery_count($link,$sqlString)
	{
		$results = mysqli_query($link,$sqlString);
		echo (!$results?die(mysqli_error($link)."<br />$sqlString"):"");
		
		$count = mysqli_num_rows($results);
	
		return $count; 
	}
	
	function perform_SQLQuery_list($link,$sqlString,$value)
	{
		$results = mysqli_query($link,$sqlString);
		echo (!$results?die(mysqli_error($link)."<br />$sqlString"):"");	
		
		list($value) = mysqli_fetch_array($results);
		
		return $value;
	}
	
	function perform_SQLQuery_listarray($link,$sqlString,$value)
	{
		//if ( is_Array($value) == TRUE ) {
		//	$values = explode(",",$value);
		//}
		return $value;
		/*$results = mysqli_query($link,$sqlString);
		echo (!$results?die(mysqli_error($link)."<br />$sqlString"):"");	
		
		list($values[0],$values[1]) = mysqli_fetch_array($results);
		*/
		//return array ($values);
	}
	
	
	
?>