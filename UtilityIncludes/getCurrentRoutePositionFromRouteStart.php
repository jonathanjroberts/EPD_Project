<?php
	function getCurrentRoutePositionFromRouteStart($base_directory)
	{
		$directory = explode("/",$_SERVER["REQUEST_URI"]);
		$sizeDirectories = count($directory); $actualArrayLength = $sizeDirectories -1;

		$countLoop = 2;  // Note: $countLoop = 1 is the same as 0 for Root Directory [ "PMBA/EPD/Public" - "PMBA/EPD/Public" == 0] 
		foreach($directory as $currentDirectory){
		
			$currentDirectory = ucfirst(str_replace(array(".html",".htm",".php","_","-"),array("","",""," "," "),$currentDirectory) );
				if ( $currentDirectory == $base_directory ) {  // find starting value where = to 'Public'
					$directoryRouteStartPosition = $countLoop;
					break 1;
				}
			$countLoop++;
		}	
		$currentRoutePosition = $actualArrayLength - $countLoop; // Determines how many "../" to use for Sub Directories
		
		if ($currentRoutePosition != 0) {
			$childDirectoryCountString = "../";
			for ($i = 0; $i <= $currentRoutePosition; $i++) {
				$childDirectoryCountString = $childDirectoryCountString . "../";
			}
		} else {
			$childDirectoryCountString = "";
		}
		return $childDirectoryCountString;  
	}
?>