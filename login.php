<html>

<head>
	<title>Login</title>
</head>

<body>

<!-- http://localhost/PMBA/EPD/public/login.php -->


<?php
	include ('UtilityIncludes/connectEPD.php');
	include ('UtilityIncludes/secret/settings2.php'); 
	$secret = secret();

	if (isset($_POST['username']) and isset($_POST['pwd']) and $_POST['username']!="" and $_POST['pwd']!=""){
		$userName = $_POST['username'];
		$pwd = sha1($_POST['pwd']);

		$sql = "SELECT user_id,role FROM users WHERE user_name='$userName' AND pwd='$pwd'";
		$results = mysqli_query($link,$sql);
		echo (!$results?die(mysqli_error($link)."<br />".$sql):"");
		

		$count = mysqli_num_rows($results);
		if ($count > 0){
			list($userId,$role) = mysqli_fetch_array($results);
			$timeOfLogin = time();
			$hash = sha1($secret.$userId.$userName.$role.$timeOfLogin);
			//1st parameter is the name of the cookie
			//2nd parameter is the value of the cookie 
			//3rd parameter is expiration time
			//chrome://settings/cookies
			//if you do not specify 3rd parameter, your cookie will expire as soon as browser is closed. But if you provide the time you cookies will persist till that time even if a browser is closed, hence the name persistent-cookie
			
			$expirationTime = strtotime("+10 years");
			setcookie('userId',$userId,$expirationTime);
			setcookie('userName',$userName,$expirationTime);
			setcookie('role',$role,$expirationTime);
			setcookie('timeOfLogin',$timeOfLogin,$expirationTime);
			setcookie('hash',$hash,$expirationTime);
			//in runtime we will calculate the output with every request and match it with publicly available output
			//header function will take the user to dashboard.php page
			header('location:dashboard.php');
		}
	}
	?>


<!--  Start: HTML Form Section -->
<br /> <h2> Login </h2> <hr /> <br />

<?php
	if(!empty($_GET['message'])) 
	{
		$message = $_GET['message'];
		echo "$message";
	}
?>


<form method='post' action=''>

	Username: <input type='text' name='username'><br />
	<br />
	Password: <input type='password' name='pwd'><br />
	
	<br />
	<input type='submit' value='Go'>
</form>
<br />
<a href="register.php">Register</a>
<!--  End: HTML Form Section -->

</body>
</html>