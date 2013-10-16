<?php
	session_start();

	if(!isset($_SESSION['logged_in'])){
		header("Location: /project");
		exit;
	}

	session_destroy();
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Logout</title>
	</head>
	<body>
		You have succesfully logged out. <br />
		<a href="/">Go to Homepage</a>
	</body>
</html>