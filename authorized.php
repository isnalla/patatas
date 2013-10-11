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
			if($_SESSION['role'] == "Lecturer")
				include "dashboard/lecturer.php";
			else if($_SESSION['role'] == "Department Head")
				include "dashboard/depthead.php";
			else if($_SESSION['role'] == "College Secretary")
				include "dashboard/collegesec.php";
			else if($_SESSION['role'] == "Student")
				include "dashboard/student.php";
		?>
		<br />
		<a href="logout.php" id="logout" name="logout">Log out</a>
	</body>
</html>