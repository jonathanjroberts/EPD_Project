<html>

<head>
	<title>Admin > Menu</title>
</head>

<body>

<!-- http://localhost/PMBA/EPD/public/admin/default.php -->




<!--  Start: Admin Menu Links -->

<br /> <h2> Admin > Menu </h2> <hr /> <br />

<!-- Start: Global Include Files -->
<?php
	include('../UtilityIncludes/globalIncludes.php');
?>
<!-- End: Global Include Files -->


<?php 
	// Link Back to Dashboard
	echo "<br /><a href='$base_url/dashboard.php$queryString[0]'>Return to Dashboard</a><br />";
	echo "<br /><br />";

	// Toggle Breadcrumbs
	echo breadcrumbs($base_url,$homePageFileName,$homePageCrumbName,$queryString,$crumbRouteStartPosition,0) . "<br /><br />";

	
	echo "<ul>";	
		echo "<li><a href='$base_url/admin/area/list.php$queryString[0]'>Update Area Table</a></li><br />";
		echo "<li><a href='$base_url/admin/section/list.php$queryString[0]'>Update Section Table</a></li><br />";
		echo "<li><a href='$base_url/admin/equipment/list.php$queryString[0]'>Update Equipment Table</a></li><br />";		
		echo "<li><a href='$base_url/admin/tag/list.php$queryString[0]'>Update Tag Table</a></li><br />";
		echo "<li><a href='$base_url/admin/module/list.php$queryString[0]'>Update Module Table</a></li><br />";
		echo "<li><a href='$base_url/admin/user/list.php$queryString[0]'>Update User Table (Role)</a></li><br />";
	echo "</ul>";
?>

<!--  End: Admin Menu Links -->

</body>
</html>