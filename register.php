<?php
$con = mysqli_connect("engr-cpanel-mysql.engr.illinois.edu","coursesuggest_sy","asdf1234","coursesuggest_main");
if (mysqli_connect_errno())
{
	echo "Failed to connect to Mysql. Connection error";

}
$sql_insert = "INSERT INTO Students(Name,Year,Gender,MajorID,username,password)
VALUES
('$_POST[Name]','$_POST[Year]','$_POST[Gender]','$_POST[MajorID]','$_POST[username]','$_POST[password]')";

if(!mysqli_query($con,$sql_insert))
{
	die("Error:". mysqli_error($con));
}

echo "1 student added";
echo '<br><a href="http://coursesuggest.web.engr.illinois.edu/index.html"><button>Back to homepage</button></a>';

#mysqli_close($con);

?>