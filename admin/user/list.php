<html>

<head>
	<title>Admin > Menu > User > List</title>
	<style> 
		th {text-decoration: underline;}
		td {text-align:center;} 
	</style>
</head>

<body>

<!-- http://localhost/PMBA/EPD/public/admin/user/list.php -->

<br /> <h2> Admin > Menu > User > List </h2> <hr />

<!-- Start: Global Include Files -->
<?php
	include('../../UtilityIncludes/globalIncludes.php');
?>
<!-- End: Global Include Files -->


<!-- Start: Table List: Current Records -->
<br /> <h3> Current Records </h3> <hr />
<?php
	// Toggle Breadcrumbs
	echo breadcrumbs($base_url,$homePageFileName,$homePageCrumbName,$queryString,$crumbRouteStartPosition,0) . "<br /><br />";
	
	// Link Back to Admin Menu
	echo "<br /><a href='$base_url/admin/default.php$queryString[0]'>Return to Admin Menu</a><br />";
	
	// Link Back to Dashboard
	echo "<br /><a href='$base_url/dashboard.php$queryString[0]'>Return to Dashboard</a><br />";
	echo "<br /><br />";
	
	
	// Get Current List of Areas
	$sql_areaList = "SELECT area_id,area_name FROM area";
	$results_areaList = mysqli_query($link,$sql_areaList);
	echo (!$results_areaList?die(mysqli_error($link)."<br />$sql_areaList"):"");
	
	while(list($area_id,$area_name) = mysqli_fetch_array($results_areaList)){
		$input[$area_id] = $area_name; 
	}
	$areaList = array_unique($input);
	
	// Get Current List of Users
	$sql = "SELECT user_id,user_name,area_id,user_activeFlag,role FROM users";
	$results = mysqli_query($link,$sql);
	echo (!$results?die(mysqli_error($link)."<br />$sql"):"");
	
	echo "<table>";
	echo "<tr>";
	echo "<th width='150px'>User Id</th>";
	echo "<th width='150px'>User Name</th>";
	echo "<th width='150px'>Area Id</th>";
	echo "<th width='150px'>Active Status</th>";
	echo "<th width='150px'>Role</th>";
	echo "<th width='150px'>Options</th>";
	echo "</tr>";
	
	while(list($user_id,$user_name,$area_id,$user_activeFlag,$role) = mysqli_fetch_array($results)){
		echo "<tr>";
		echo "<td>$user_id</td> <td>$user_name</td>";
		echo "<td>$area_id</td>";
		echo "<td>"; if ($user_activeFlag == 1) { echo "Active"; } else { echo "Inactive"; } echo "</td>";
		echo "<td>"; if ($role == 1) { echo "Admin"; } else { echo "User"; } echo "</td>";
		echo "<td>";	
		if ($role == 1) {  
			echo "<a href='setRole.php?user_id=$user_id'>Remove Admin Access</a>";
		} else {
			echo "<a href='setRole.php?user_id=$user_id'>Grant Admin Access</a>";
		}
		echo "</td>";
		echo "</tr>";
	}
	
	echo "</table>";	
?>
<!--  End: Table List: Current Records -->


</body>
</html>