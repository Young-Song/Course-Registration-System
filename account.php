<?php session_start(); 
if(!isset($_SESSION['username']))
	header('Location: http://coursesuggest.web.engr.illinois.edu/index.html');
$link = mysqli_connect("engr-cpanel-mysql.engr.illinois.edu","coursesuggest_sy","asdf1234","coursesuggest_main");
//$database_name = 'coursesuggest_main';
//mysql_select_db($database_name, $link);
if (mysqli_connect_errno())
{
	echo "Failed to connect to Mysql. Connection error";
}
$query = "SELECT DISTINCT classname 
FROM Classes, ClassTaken, Students
WHERE Classes.id=ClassTaken.Classid 
AND ClassTaken.Studentid=Students.id 
AND Students.username like '$_SESSION[username]'";
?>
<!DOCTYPE HTML>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<title>Account</title>
	<link rel="stylesheet" href="css/acctstyle.css" type="text/css">
</head>
<body>
	<div id="header">
		<div id="header2">
			<ul id="navigation">
				<li class="active">
					<a href="account.php">Home</a>
				</li>
				<li>
					<a href="getRecommended.php">Recommend classes</a>
				</li>
				<li>
					<a href="calendar.php">Calendar</a>
				</li>
				<li>
					<a href="addClasses.php">Add classes taken</a>
				</li>
			</ul>
		</div>
		<div id="user">
			<?php
				echo '<p>Welcome '. $_SESSION[username] . '</p>'; 
			?>
			<a href="http://coursesuggest.web.engr.illinois.edu/logout.php">Log out</a>
		</div>
	</div>
	<div id="bodypar" style="display:inline-block; width:700px; float:left;">
		<p><u>Classes Taken</u></p>
		<?php 
		$result = mysqli_query($link, $query);
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			echo $row["classname"].'<br>';
		}
		echo '<br>';
		?>
	</div>
	<div style="display:inline-block; float:right; margin-top:20px;">
		<form method="post">
			New password: <input type="password" name="newpass">
			<input type="hidden" name="changepass" value="true">
			<input type="submit" value="Submit">
		</form> <br>
		<a style="margin:0 auto;" href="deleteAccount.php">Delete account</a>
		<?php
		if($_POST[changepass]){
			$query = "UPDATE Students SET password='$_POST[newpass]' WHERE username='$_SESSION[username]'";
			if($result = mysqli_query($link, $query)){
				echo "Password updated.";
			} else {
				echo "UPDATE failed";
				die("Error:". mysqli_error($con));
			}
		} ?>
	</div>
</body>
</html>