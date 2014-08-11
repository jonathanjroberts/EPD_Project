<html>

<head>
	<title>Admin > Menu > User Table > Set Role </title>
</head>

<body>

<body>

<!-- http://localhost/PMBA/EPD/public/admin/section/activate_or_inactivate.php -->

<br /> <h2> Admin > Menu > User Table > Set Role </h2> <hr />

<!-- Start: Global Include Files -->
<?php
	include('../../UtilityIncludes/globalIncludes.php');
?>
<!-- End: Global Include Files -->

<?php
	// Link Back to Admin Menu > Area 
	echo "<br /><a href='$base_url/admin/user/list.php'>Return to Admin Section List</a><br />";
	
	// Link Back to Admin Menu
	echo "<br /><a href='$base_url/admin/default.php'>Return to Admin Menu</a><br />";
	
	// Link Back to Dashboard
	echo "<br /><a href='$base_url/dashboard.php'>Return to Dashboard</a><br />";
	echo "<br /><br />";

	// Toggle Breadcrumbs
	echo breadcrumbs($base_url,$homePageFileName,$homePageCrumbName,$queryString,$crumbRouteStartPosition,0) . "<br /><br />";
	
	
	if (isset($_GET['user_id']) and $_GET['user_id']!="")
	{	
		$user_id = $_GET['user_id'];

		// Storing Passed Section Name  
		$sql = "SELECT user_id,user_name,area_id,user_activeFlag,role FROM users WHERE user_id=$user_id";
		$results = mysqli_query($link,$sql);
		echo (!$results?die(mysqli_error($link)."<br />$sql"):"");	
		list($user_id,$user_name,$area_id,$user_activeFlag,$role ) = mysqli_fetch_array($results);
			
		// Display Section Status to User
		echo "<br />User, <b>$user_name</b>, is currently set to ";
		if ($role == 1) { echo "<b>Remove Admin Access</b>"; }  else { echo "<b>Grant Admin Access</b>"; }
		echo " status";
		echo "<br /><br />";
		
		if ($role == 1) { $formButtonName = "Remove Admin Access"; }  else { $formButtonName = "Grant Admin Access"; } 
		if ($role == 1) { $newFormValue = 0; }  else { $newFormValue = 1; }
		
		// Start Section Form
		echo "<form method='post' action=''>";
		echo "<input type='hidden' name='role' value='$newFormValue'>"; // Set Value of 0 = Set to Inactive | Set Value of 1 = Set to Active
		echo "<br /><br />";
		echo "<input type='submit' value='$formButtonName'>";
		echo "</form>";
		
		
		if (isset($_POST['role']) and $_POST['role']!="")
		{
			$role = $_POST['role']; 
			
			$sql_new = "UPDATE users SET role=$role WHERE user_id=$user_id";
			$results_new = mysqli_query($link,$sql_new);
			echo (!$results_new?die(mysqli_error($link)."<br />".$sql_new):"");
			
			// Report Back to User > Check Users Table
			$sql_check = "SELECT user_id FROM users WHERE user_id=$user_id AND user_name='$user_name' AND role=$role";
			$results_check = mysqli_query($link,$sql_check);	
			echo (!$results_check?die(mysqli_error($link)."<br />".$sql_check):"");
			
			$count = mysqli_num_rows($results_check);
		
			if ($role == 1) { $newStatusUpdate = "Active"; }  else { $newStatusUpdate = "Inactive"; } 
		
			if ($count > 0) {   
				echo "<br /><br />";
				echo "The status for User, <b>$user_name</b>, has been changed successfully to: <b>$newStatusUpdate</b>.";
			} else {
				echo "<br /><br />";
				echo "There was a problem with your request for User: <b>$user_name</b>.  Please try again or contact support. <br /><br />";
				echo "Reference: <br />";
				echo "<ul><li>User Id: $user_id</li><li>User Name: $user_name</li><li>Request to set Role Status to: $role</li>";
			}
		}
		
	} else {  // If GET Requests are not set
		echo "<br /><br /> <b>There was a problem with your request.</b> <br /><br />";  
		echo "Please return to the <a href='$base_url/dashboard.php'>Dashboard</a>";
	}
?>

		
</body>
</html>