<?php session_start();
if($_POST['action'] == 'Register')
	header('Location: http://coursesuggest.web.engr.illinois.edu/registration.html');
else{
$_SESSION['username'] = $_POST[username];
$link = mysqli_connect("engr-cpanel-mysql.engr.illinois.edu","coursesuggest_sy","asdf1234","coursesuggest_main");
if (mysqli_connect_errno())
{
	echo "Failed to connect to Mysql. Connection error";
}
$query = "SELECT * FROM Students WHERE username='$_SESSION[username]' AND  password='$_POST[password]'";
if($result = mysqli_query($link, $query)){
	if($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		header('Location: http://coursesuggest.web.engr.illinois.edu/account.php');
	}else{ echo '
<!doctype html>

<head>

	<!-- Basics -->
	
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<title>Login</title>

	<!-- CSS -->

	<link rel="stylesheet" href="css/loginstylesheet.css">
	
</head>
	<!-- Main HTML -->
<body>	
	<!-- Begin Page Content -->
	<div id="container">	
		<form action="index.php" method="post">
		<label for="name">NetID:</label>
		<input type="name" name="username">
		
		<label for="username">Password:</label>
		<input type="password" name="password">
		<p>Incorrect netid/password</p>
		
		<div id="lower">
		<input id="login" type="submit" name="action" value="Login">
		<input id="register" type="submit" name="action" value="Register">
		</div>
		
		</form>
	</div>
	<!-- End Page Content -->
</body>
</html>
';
	}
}
}
?>