<?php
	// *******************************************
	// 	Function: getFileExtension 
	//
	//  - Passables:	File name as String
	//  - Return:		File Extension as String
	// *******************************************


	function getFileExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
	}
?>