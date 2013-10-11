<!DOCTYPE html>
<html>
	<head>
		<title> EF5L SystemTwo</title>
		<link rel="stylesheet" type="text/css" href="css/project.css" />
	</head>
	<body>
		<!-- HEADER START -->
		<div id="index-header" name="header">	
			<h2 id="index-header-text"> EF5L systemtwo </h2>	
			<form id="login-form" name="login-form" action="" method="post">

				<div id="username-container">
				<label for="username"> username </label><br />
					<input type="text" id="username" name="username" />
				</div>

				<div id="password-container">
					<label for="password"> password </label><br />
					<input type="password" id="password" name="password" />
					<button type="submit" id="login" name="login" value="login" />Log-in</button>
				</div>
			</form>
		</div>
		<!-- HEADER END -->
		<!-- CONTENT START -->
		<div id="index-content" name="content">	
			
		</div>
		<!-- CONTENT END -->
		<!-- FOOTER START -->
		<div id="index-footer" name="footer">	
			
		</div>
		<!-- FOOTER END -->
	</body>
</html>

<?php
	session_start();

	if(isset($_SESSION['logged_in'])){
		header("Location: authorized.php");
		exit;
	}

	if(isset($_POST['login'])){
		include 'db/db.php';

		$db = new Database();	//user defined database class from db.php;

		 //$user is false if login is unsuccessful
		if($user = $db->login($_POST['username'],sha1($_POST['password']))){
				$_SESSION['logged_in'] = true;
				$_SESSION['role'] = $user['role'];
				$_SESSION['username'] = $user['username'];
				$_SESSION['name'] = $user['name'];

				header("Location: authorized.php");
                exit;
		}
		else {	//show alert if login fails
			echo "<script>
					alert('Invalid username/password');
				  </script>";
		}
	}
?>