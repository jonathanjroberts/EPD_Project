<?php
	// *************************
	// 	Function - Breadcrumbs
	// *************************
	
	
	function breadcrumbs($base_url,$homePageFileName,$homePageCrumbName,$queryString,$crumbRouteStartPosition,$enableTestCommentsFlag)
	{
		$crumbs = explode("/",$_SERVER["REQUEST_URI"]);
		$sizeCrumbs = count($crumbs); $actualArrayLength = $sizeCrumbs - 1;
		$firstCrumb = $crumbs[1]; $lastCrumb = $crumbs[$actualArrayLength];  
		
		if ($enableTestCommentsFlag == 1) {
			echo "<b>Count Crumbs:</b> $sizeCrumbs  <b>]|[</b>  <b>ActualArrayLength</b> = $actualArrayLength"."<br />";
			echo "<b>crumbs[1]:</b> $crumbs[1]   <b>]|[</b>   <b>crumbs[2]:</b> $crumbs[2]  <b>]|[</b>  <b>crumbs[3]:</b> $crumbs[3]  <b>]|[</b>  <b>crumbs[4]:</b> $crumbs[4]"."<br /><br />";
			echo "<b>First Crumb:</b> $firstCrumb  <b>]|[</b>  <b>Last Crumb:</b> $lastCrumb <br />";
		}
		
		$stringSize = strlen($lastCrumb); 
		if ( strpos($lastCrumb, '.php') > 0 and strpos($lastCrumb, '.php') == TRUE ) {   // Only needed if current URL contains ".php"
			$position = strpos($lastCrumb, '.php');  // In the Last Crumb: Get index of ".php" and all GET Request in Current URL thereafter
			$crumbs[$actualArrayLength] = substr_replace($lastCrumb.' ', '', $position, -1);  // Replace Value of the Last Crumb with the Newly Cleaned String 
		}
		
		if ($enableTestCommentsFlag == 1) {
			echo "<b>Last Crumb Size:</b> $stringSize <b>]|[</b> <b>Needle Position:</b> $position <br />";
			echo "<b>New Last Crumb:</b> $crumbs[$actualArrayLength]"."<br /><br />";
			echo "<b>Crumbs Array: </b> ";
		}
		// Fixing First Value
		$completeQueryString = implode("&",$queryString);
		$breadcrumbs = array("<a href=\"$base_url" . "/" . "$homePageFileName" . "$completeQueryString" . "\">$homePageCrumbName</a>");
		

		$countLoop = 0; // Starts at the First Index of $crumbs[] Array
		$breadcrumbsPrevName = "root";
		foreach($crumbs as $crumb){
			if ( $countLoop > $crumbRouteStartPosition ) { // Need to at least Ingore first empty value
				$breadcrumbsName = ucfirst(str_replace(array(".html",".htm",".php","_","-"),array("","",""," "," "),$crumb) );
				
				if ( $countLoop < $actualArrayLength ) { 
					$tempIndex = $countLoop - 1; // Needed or else index will be violated
					$breadcrumbsLink = getBreadcrumbLink($breadcrumbsName,$breadcrumbsPrevName);
					$breadcrumbs[] = "<a href='$base_url/$breadcrumbsLink'>$breadcrumbsName</a>";
				} else {
					$breadcrumbs[] = "$breadcrumbsName";
					break 1; 
				}
				if ($countLoop >0) {$breadcrumbsPrevName = $breadcrumbsName;}
			}
			$countLoop++; // Final value of $countLoop Equals the Index of the Last Crumb in crumbs[] Array -> ($actualArrayLength)
			//if ($countLoop == 6) {break 1;}
		}
		if ($enableTestCommentsFlag == 1) {
			echo "<br /><b>Count Loop:</b> $countLoop<br /><br />";
		}
		$seperator = " &raquo; ";
		return implode($seperator, $breadcrumbs);
	}
	
?>