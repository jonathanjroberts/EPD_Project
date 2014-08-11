<?php
	function getRouteStartFromServerPath($base_directory)
	{
		$directory = explode("/",$_SERVER["REQUEST_URI"]);
		//$sizeDirectories = count($directory); $actualArrayLength = $sizeDirectories - 1;
		//$firstDirectory = $directory[1]; $lastDirectory = $sizeDirectories[$actualArrayLength]; 

		$countLoop = 0;  // Starts at the First Index of $directory[] Array
		foreach($directory as $currentDirectory){
			
			if ( $countLoop > 1 ) {  // Need to at least Ingore first empty value
				$currentDirectory = ucfirst(str_replace(array(".html",".htm",".php","_","-"),array("","",""," "," "),$currentDirectory) );
					if ( $currentDirectory == $base_directory ) {  // find starting value where = to 'Public'
						$directoryRouteStartPosition = $countLoop;
					}
			}
			// echo "$currentDirectory";
			$countLoop++;
		}	
		// echo '<br /><br />'.$directoryRouteStartPosition;
		return $directoryRouteStartPosition;
	}
?>