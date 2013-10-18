<!DOCTYPE html>
<html>
	<head>
		<title> EF5L SystemTwo</title>
        <link rel="stylesheet" type="text/css" href="/css/reset.css" />
        <link rel="stylesheet" type="text/css" href="/css/project.css" />
    </head>
	<body>
		<!-- HEADER START -->
        <div id="homepage-container">
		<div id="index-header" name="header">	
			<div id="logo-container">
                <img src="/img/logo.png"/>
			</div>
			<form id="login-form" name="login-form" action="" method="post">

				<div id="username-container">
				<label for="username"> Username </label><br />
					<input type="text" id="username" name="username" />
				</div>
				<div id="password-container">
					<label for="password"> Password </label><br />
					<input type="password" id="password" name="password" />
				</div>
                <button type="submit" class="submit-button" id="login" name="login" value="login" />Log In</button>
			</form>
            <div id="hr"></div>
		</div>
		<!-- HEADER END -->
		<!-- CONTENT START -->
		<div id="index-content" name="content">
            <div class="article-header">
                <div>
                    <img src = "/img/article_header_1.png"/>
                </div>
            </div>
            <div class="article-body">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing
                    elit. Donec ante augue, pretium sed lectus id,
                    consectetur fermentum tellus. Praesent semper, orci vel
                    ultricies fringilla, mauris erat tempor ipsum, molestie
                    mattis enim nisi non nulla. Suspendisse consectetur
                    accumsan leo, quis luctus ipsum sollicitudin vitae.
                    Maecenas accumsan turpis suscipit viverra sodales. Etiam
                    hendrerit, turpis non ullamcorper gravida, dui libero
                    aliquet libero, at iaculis lacus odio sed diam. Aenean
                    tristique magna vitae orci aliquam tempus. Maecenas
                    accumsan sed ipsum quis ullamcorper. Cras vel
                    commodo neque. Praesent non ligula faucibus, sagittis
                    arcu vel, commodo arcu. Mauris eros massa, vestibulum a
                    lorem a, sodales luctus urna. In vitae leo id sapien
                    vulputate elementum non ut turpis. Integer gravida
                    tellus dui, quis posuere diam ultricies ac.
                </p>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing
                    elit. Donec ante augue, pretium sed lectus id,
                    consectetur fermentum tellus. Praesent semper, orci vel
                    ultricies fringilla, mauris erat tempor ipsum, molestie
                    mattis enim nisi non nulla. Suspendisse consectetur
                    accumsan leo, quis luctus ipsum sollicitudin vitae.
                    Maecenas accumsan turpis suscipit viverra sodales. Etiam
                    hendrerit, turpis non ullamcorper gravida, dui libero
                    aliquet libero, at iaculis lacus odio sed diam. Aenean
                    tristique magna vitae orci aliquam tempus. Maecenas
                    accumsan sed ipsum quis ullamcorper.
                </p>
                <p>
                    Maecenas accumsan turpis suscipit viverra sodales. Etiam
                    hendrerit, turpis non ullamcorper gravida, dui libero
                    aliquet libero, at iaculis lacus odio sed diam. Aenean
                    tristique magna vitae orci aliquam tempus. Maecenas
                    accumsan sed ipsum quis ullamcorper. Cras vel
                    commodo neque. Praesent non ligula faucibus, sagittis
                    arcu vel, commodo arcu. Mauris eros massa, vestibulum a
                    lorem a, sodales luctus urna. In vitae leo id sapien
                    vulputate elementum non ut turpis. Integer gravida
                    tellus dui, quis posuere diam ultricies ac.
                </p>
            </div>
		</div>
		<!-- CONTENT END -->
		<!-- FOOTER START -->
		<div id="index-footer" name="footer">	
			
		</div>
		<!-- FOOTER END -->
        </div>
	</body>
</html>

<?php
	session_start();

	if(isset($_SESSION['logged_in'])){
		header("Location: authorized.php");
		exit;
	}

	if(isset($_POST['login'])){
		include '../db/db.php';

		$db = new Database();	//user defined database class from db.php;

		 //$user is false if login is unsuccessful
        $db = new Database();
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