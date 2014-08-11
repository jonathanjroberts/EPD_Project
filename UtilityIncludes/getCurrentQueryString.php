<?php
	function getCurrentQueryString($commonProjectGETRoute)//, $maxLoopCount)
	{
		$loopCount = 1;
		foreach($commonProjectGETRoute as $commonProjectGETRouteValue)
		{
			if (isset($_GET[$commonProjectGETRouteValue]) and $_GET[$commonProjectGETRouteValue]!="")
			{
				if ($loopCount == 1) 
				{
					// Get selection for Area and place "?" first
					$commonProjectGETRouteValue_id = $_GET[$commonProjectGETRouteValue];
					$queryString[] = "?" . $commonProjectGETRouteValue . "=" . $commonProjectGETRouteValue_id;
				} else {
					// Get selection for other passables without "?" 
					$commonProjectGETRouteValue_id = $_GET[$commonProjectGETRouteValue];
					$queryString[] = $commonProjectGETRouteValue . "=" . $commonProjectGETRouteValue_id;
					//if ($loopCount == $maxLoopCount) { 
					//	break 1;
					//}
				} // End Nested If
			} else {
				$queryString[] = "";
				break 1;
			}
			$loopCount++;
		}
		return $queryString;
	}
?>