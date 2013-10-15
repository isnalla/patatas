<?php
	session_start();

	//redirect to index.php if not logged in
	if(!$_SESSION['logged_in']){
		header("Location: /project/");
		exit;
	}
?>


<html>
	<head>
		<title>authorized</title>
	</head>
	<body>
		<?php
			//display appropriate dashboard according to role
			if($_SESSION['role'] == "LEC")
				include "dashboard/lecturer.php";
			else if($_SESSION['role'] == "DPH")
				include "dashboard/depthead.php";
			else if($_SESSION['role'] == "CLS")
				include "dashboard/collegesec.php";
			else if($_SESSION['role'] == "STD")
				include "dashboard/student.php";
		?>
		<br />
		<a href="logout.php" id="logout" name="logout">Log out</a>
	</body>
</html>