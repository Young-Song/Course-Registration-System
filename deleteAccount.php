<?php session_start(); 
if(!isset($_SESSION['username']))
	header('Location: http://coursesuggest.web.engr.illinois.edu/index.html');
?>
<html>
	<head>
		<title>Account deletion</title>
	</head>
	<body>
	<p>Deleting account with username:<?php echo " $_SESSION[username]"?></p>
<?php
$con = mysqli_connect("engr-cpanel-mysql.engr.illinois.edu","coursesuggest_sy","asdf1234","coursesuggest_main");
if (mysqli_connect_errno())
{
	echo "Failed to connect to Mysql. Connection error";

}
$sql_delete = "DELETE FROM Students WHERE username='$_SESSION[username]'";

if(!mysqli_query($con,$sql_delete))
{
	die("Error: ". mysqli_error($con));
}

echo "Account deleted";


#mysqli_close($con);

?>
		<br><a href="http://coursesuggest.web.engr.illinois.edu/index.html"><button>Back to homepage</button></a>
	</body>
</html>	