<?php
	function getBreadcrumbLink($breadcrumbsName,$breadcrumbsPrevName)
	{
		/* Admin Section Routes */
			if ($breadcrumbsName == "Admin") {
				$breadcrumbsLink = "Admin/default.php";
				
			} elseif ($breadcrumbsPrevName == "Admin" and $breadcrumbsName == "Area") {
				$breadcrumbsLink = "Admin/Area/list.php";
				
			} elseif ($breadcrumbsPrevName == "Admin" and $breadcrumbsName == "Section") {
				$breadcrumbsLink = "Admin/Section/list.php";
				
			} elseif ($breadcrumbsPrevName == "Admin" and $breadcrumbsName == "Equipment") {
				$breadcrumbsLink = "Admin/Equipment/list.php";
				
			} elseif ($breadcrumbsPrevName == "Admin" and $breadcrumbsName == "Tag") {
				$breadcrumbsLink = "Admin/Tag/list.php";
				
			} elseif ($breadcrumbsPrevName == "Admin" and $breadcrumbsName == "Module") {
				$breadcrumbsLink = "Admin/Module/list.php";
				
			} elseif ($breadcrumbsPrevName == "Admin" and $breadcrumbsName == "User") {
				$breadcrumbsLink = "Admin/User/list.php";
			
		/* General Section Routes */
			} else {
				$breadcrumbsLink = "dashboard.php";
			}
		
		/* Testing */ // echo "<br />".$breadcrumbsName."<br />"; echo "<br />".$breadcrumbsLink."<br />";
		return $breadcrumbsLink;
	}
?>