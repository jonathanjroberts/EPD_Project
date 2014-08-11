<?php

	function verify($link,$base_url) 
	{
		$secret = secret(); // Get private encryption key

		// The objective of this file is to authenticate a user in all future requests after they have been authenticated by login.php
		// We first check whether cookies are defined, if not then we take the user back to login.php (taken care by else part). 

		if (isset($_COOKIE['userId']) and isset($_COOKIE['userName']) and isset($_COOKIE['timeOfLogin']) and isset($_COOKIE['hash'])){
			$userId = $_COOKIE['userId'];
			$userName = $_COOKIE['userName'];
			$role = $_COOKIE['role'];
			$timeOfLogin = $_COOKIE['timeOfLogin'];
			$hashCookie = $_COOKIE['hash'];
			$hashCalculated = sha1($secret.$userId.$userName.$role.$timeOfLogin);
			if ($hashCookie != $hashCalculated){
				header('location:' . $base_url . '/login.php');
				exit;
			}
		} else {
			header('location:' . $base_url . '/login.php');
			exit;
		}

		$sql="SELECT user_name FROM users WHERE user_name='$userName'";
		$results=mysqli_query($link,$sql);
		echo (!$results?die(mysqli_error($link)."<br>".$sql):"");
		list($userName)=mysqli_fetch_array($results);
		
		$userAccountOptionsStr = "<br /> Welcome: <b>$userName</b> - <a href=$base_url/logout.php> Log Out </a> <br /><br />";
		return $userAccountOptionsStr;
	}

?>