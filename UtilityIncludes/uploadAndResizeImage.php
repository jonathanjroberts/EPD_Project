<?php
	// *******************************************
	// 	Function: uploadAndResizeImage 
	//
	//  - Passables:	File name as String
	//  - Return:		File Extension as String
	// *******************************************

	include('getFileExtension.php');

	//define ("MAX_SIZE","400");

	$errors=0;

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$image = $_FILES["file"]["name"];
		$uploadedfile = $_FILES['file']['tmp_name'];

		if ($image) 
		{
		$filename = stripslashes($_FILES['file']['name']);
			$extension = getFileExtension($filename);
			$extension = strtolower($extension);
			if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
			{
				echo ' Unknown Image extension ';
				$errors = 1;
				
			} else {
				$size=filesize($_FILES['file']['tmp_name']);

				/*if ($size > MAX_SIZE*1024)
				{
					echo "You have exceeded the size limit";
					$errors = 1;
				}*/

				if($extension == "jpg" || $extension == "jpeg" )
				{
					$uploadedfile = $_FILES['file']['tmp_name'];
					$src = imagecreatefromjpeg($uploadedfile);
					
				} else if($extension=="png") {
					$uploadedfile = $_FILES['file']['tmp_name'];
					$src = imagecreatefrompng($uploadedfile);
					
				} else {
					$src = imagecreatefromgif($uploadedfile);
				}

				list($width,$height)=getimagesize($uploadedfile);

				$newwidth = 60;
				$newheight = ($height/$width) * $newwidth;
				$tmp = imagecreatetruecolor($newwidth,$newheight);

				$newwidth1 = 25;
				$newheight1 = ($height/$width) * $newwidth1;
				$tmp1 = imagecreatetruecolor($newwidth1,$newheight1);

				imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
				imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);
				
				$uploadTime = time();

				$filename = "images/" . $uploadTime . "_" . $_FILES['file']['name'];
				$filenameThumb = "images/thumb/thumb_". $uploadTime . "_" . $_FILES['file']['name'];

				imagejpeg($tmp,$filename,100);
				imagejpeg($tmp1,$filenameThumb,100);

				imagedestroy($src);
				imagedestroy($tmp);
				imagedestroy($tmp1);
			}
		}
	}
	

	if(isset($_POST['Submit']) && !$errors) 
	{
		// mysql_query("update SQL statement ");
		echo "Image Uploaded Successfully!";

	}

?>