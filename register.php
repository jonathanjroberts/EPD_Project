<html>

<head>
	<title>Login > Register</title>
</head>

<body>

<!-- http://localhost/PMBA/EPD/public/register.php -->

<!--  Start: PHP Section -->
<?php
	include('UtilityIncludes/connectEPD.php');
	include('UtilityIncludes/getCurrentListForValue.php');


	// Get Current List of Areas
	$areaList = getCurrentListForValue($link,"area","area_id","area_name");
	
	if(isset($_POST['inputUsername']) and isset($_POST['inputPassword']) and isset($_POST['selectArea']) and $_POST['inputUsername']!='' and $_POST['inputPassword']!="" and $_POST['selectArea']!="")
	{
		$username = $_POST['inputUsername'];
		$pwd = sha1($_POST['inputPassword']);
		$area_id = $_POST['selectArea']; 

		// Check to see if Username is already present
		$sql = "SELECT user_id FROM users WHERE user_name='$username' AND pwd='$pwd'";
		$results = mysqli_query($link,$sql);	
		echo (!$results?die(mysqli_error($link)."<br />".$sql):"");
		$count = mysqli_num_rows($results);
		
		if ($count > 0){
			echo "Your username is already present in the database! <br />";
			echo "<a href='login.php'>Login</a><br />";
		} else {
			// Insert into database
			$sql = "INSERT INTO users(user_name,pwd,area_id) VALUES('$username','$pwd','$area_id')";
			$results = mysqli_query($link,$sql);
			echo (!$results?die(mysqli_error($link)."<br />".$sql):"");

			// Report back to user
			$sql = "SELECT user_id FROM users WHERE user_name='$username' AND pwd='$pwd'";
			// "SELECT Count(id)" could work - it will either be 1 or 0, but it wont give the actual username, just if it exists or not.
			// mysqli_num_rows returns the number of rows select statement got from the query
			
			$results = mysqli_query($link,$sql);	
			// if for any reason the query fails, it will post a response.  If it passes, nothing is posted.
			echo (!$results?die(mysqli_error($link)."<br>".$sql):"");
			
			$count = mysqli_num_rows($results);
			
			echo "<br /> Count: " . $count . "<br />";
			if($count>0){
				$success = "Thanks for Registering! Please Log in";
				header('location:login.php?message=$success');
			}
		}
	}
?>
<!--  End: PHP Section -->


<!--  Start: HTML Form Section -->

	<h2> Register </h2> <hr /> <br />
		<form method="post" name="template" action="">
			
			Username: <input type='text' name='inputUsername'><br />
			<br />
			
			Password: <input type='password' name='inputPassword'><br />
			<br />
			
			Area:	<select name="selectArea">
						<option value="0" disabled selected>- Select Area -</option>
						<?php 
							foreach($areaList as $areaId => $areaValue){
							echo "<option value='$areaId'>$areaValue</option>";
						}
						?>
					</select>
					
			
			<br /><br />
			<input type="submit" value="Submit">
		</form>

<!--  End: HTML Form Section -->

</body>
</html>