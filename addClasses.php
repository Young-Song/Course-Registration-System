<?php session_start();
if(!isset($_SESSION['username']))
	header('Location: http://coursesuggest.web.engr.illinois.edu/index.html');
$link = mysqli_connect("engr-cpanel-mysql.engr.illinois.edu","coursesuggest_sy","asdf1234","coursesuggest_main");
if (mysqli_connect_errno())
{
	echo "Failed to connect to Mysql. Connection error";
}
?>
<!DOCTYPE HTML>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<title>Add classes</title>
	<link rel="stylesheet" href="css/acctstyle.css" type="text/css">
</head>
<body>
	<div id="header">
		<div id="header2">
			<ul id="navigation">
				<li>
					<a href="account.php">Home</a>
				</li>
				<li>
					<a href="getRecommended.php">Recommend classes</a>
				</li>
				<li>
					<a href="calendar.php">Calendar</a>
				</li>
				<li class="active">
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
	<div class="center" style="width: 800px;">
		<form style="float:left; width:400px; margin:0 auto;" method="post">
<?php
$query = "SELECT classname FROM Classes WHERE Classes.id not in (SELECT ClassId from ClassTaken, Students where username = '$_SESSION[username]' and ClassTaken.StudentId = Students.id)";
if($result = mysqli_query($link, $query)){
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		echo '<input style="padding-bottom:5px;" type="checkbox" name="classes[]" value="'.$row["classname"].'">'.$row["classname"].'<br>';
	}
}
echo '<input type="hidden" name="add" value="true">';
echo '<input style="margin-left: 20px; margin-top: 10px;" type="submit" value="Select Class">';
echo '</form><br><br>';


if($_POST[add]){
	$query = "SELECT id FROM Students WHERE username='$_SESSION[username]'";
	if($result = mysqli_query($link, $query)){
		$studentid = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$studentid = $studentid["id"];
	} else {
		echo "User doesn't exist";
	}
	if($result = mysqli_query($link, "SELECT * FROM Classes")){
		$class_ct = mysqli_num_rows($result);
	} else {
		echo "Error retrieving classes relation";
	}
	echo '<div style="float:left">';
	echo '<p>Please rate these classes: 5(loved) -> 1(hated)</p>';
	$checked = $_POST['classes'];
	for($i=0; $i<count($checked); $i++){
		if($result = mysqli_query($link, "SELECT id FROM Classes WHERE classname='$checked[$i]'")){
			$classid = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$classid = $classid["id"];
			$sql_insert = "INSERT INTO ClassTaken(ClassID, StudentID)
			VALUES ('$classid','$studentid')";
			if(!mysqli_query($link, $sql_insert)){
				die("Error:". mysqli_error($link));
			}
		
		$classesRated[] = $row[classname];

		echo '<form style="float:left;" method="post">';
                echo '<select style="padding-bottom:5px;" name="ratings['.$checked[$i].']">
			<option value="1"> 1 </option>
			<option value="2"> 2 </option>
			<option selected="selected" value="3"> 3 </option>
			<option value="4"> 4 </option>
			<option value="5"> 5 </option>
			</select>'.$checked[$i].'<br>';
		} else {
			echo "Error getting class id";
		}
	}
	echo '<input type="hidden" name="rated" value="true">';
	echo '<input style="margin-left: 20px; margin-top: 10px;" type="submit" value="Add Rating(s)"> <br>';
	echo '</form></div>';
}

if($_POST[rated]){
	$ratingScore = $_POST[ratings];
	$query = "SELECT id FROM Students WHERE username='$_SESSION[username]'";
	if($result = mysqli_query($link, $query)){
		$studentid = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$studentid = $studentid["id"];
	} else { echo 'couldnt get student id';}
		
	foreach($ratingScore as $classname => $rating)
	{
		//echo $classname.'<br>';
		$query = "SELECT id FROM Classes WHERE classname = '$classname'";
		if($result = mysqli_query($link, $query)){
			$classid = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$classid = $classid["id"];
		} else { echo 'couldnt get class id<br>';}
		if(!$result = mysqli_query($link, "INSERT into ratings(classid, studentid, rating) VALUES ('$classid', '$studentid', '$rating')"))
			echo 'Rating failed<br>';
		if($rating > 3)
		{
			$query = "SELECT topic FROM Classes WHERE classname = '$classname'";
			if($result = mysqli_query($link, $query)){
				$classtopic = mysqli_fetch_array($result, MYSQLI_ASSOC);
				$classtopic = $classtopic["topic"];
			} else { echo 'couldnt get class topic<br>';}
			if(!$result = mysqli_query($link, "INSERT into InterestTopics(StudentID, topics) VALUES ('$studentid', '$classtopic')"))
				echo 'failed to add to interests<br>';				
		}
	}
}
?>
	</div>
</body>
</html>