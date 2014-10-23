<?php session_start(); 
if(!isset($_SESSION['username']))
	header('Location: http://coursesuggest.web.engr.illinois.edu/index.html');
$link = mysqli_connect("engr-cpanel-mysql.engr.illinois.edu","coursesuggest_sy","asdf1234","coursesuggest_main");
if (mysqli_connect_errno())
{
	echo "Failed to connect to Mysql. Connection error";
}
$update = 1;
if(isset($_POST[timepick]))
{
	$update = 1;
	//echo $_POST[timepick];
	if($result = mysqli_query($link, "SELECT id FROM Classes WHERE classname='$_POST[classname]'")){
			$classid = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$classid = $classid["id"];
	}
	$query = 'SELECT time1, time2, time3, time4, time5, time6 FROM classtime
				WHERE classid = "'.$classid.'" AND (time1 = "'.$_POST[timepick].'" OR time2 = "'.$_POST[timepick].'" OR time3 = "'.$_POST[timepick].'" OR time4 = 			"'.$_POST[timepick].'"
				OR time5 = "'.$_POST[timepick].'" OR time6 = "'.$_POST[timepick].'")';
	if(empty($_SESSION['classes']))
		$classes = array();
	else
		$classes = $_SESSION['classes'];
	if($result = mysqli_query($link, $query)){
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			for($i=0; $i<6; $i+=1)
			{
				//echo "time".$i."<br>";
				//echo $row["time".$i].'<br>';
				if($row["time".$i]){
					if(isset($classes[$row["time".$i]]))
						$update = 0;
					$classes[$row["time".$i]] = $_POST[classname];
				}	
			}
		}
	} else {echo 'failed to get times';}
	if($update)
		$_SESSION['classes'] = $classes;
	//echo $_SESSION['classes'][$_POST[timepick]];
	//echo $classes[$_POST[timepick]];
}
?>
<html>
	<head>
		<style>
			table {border-collapse:collapse; table-layout: fixed; width: 70%; height:60%;}
			table, td, th {border: 1px solid black;}
			td {padding:0; text-align:center;}
			td:hover {background-color:#00FFFF;}
			div {height:100%; width:100%;}
			.invis {background: transparent; height:100%; width:100%; border: none !important;}
			form {margin:0;}
		</style>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script>
		$(document).ready(function() {
			var arrayFromPHP = <?php echo json_encode($_SESSION['classes']); ?>;
			$.each(arrayFromPHP, function (time, classes) {
				$("input[value="+time+"]").closest("td").css("background-color", "#F0F0F0");
				$("input[value="+time+"]").closest("td").html(classes);
    				$("input[value="+time+"]").closest("form").remove();
			});
		});
		</script>
		<title>Calendar</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="css/acctstyle.css" type="text/css">
	</head>
	<body>
	<div id="header">
		<div id="header2">
			<ul id="navigation" style="height:50px">
				<li>
					<a href="account.php">Home</a>
				</li>
				<li>
					<a href="getRecommended.php">Recommend classes</a>
				</li>
				<li class="active">
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
	<table class="center">
	<tr>
		<th></th><th>Monday</th><th>Tuesday</th><th>Wednesday</th><th>Thursday</th><th>Friday</th>
	</tr><tr>
		<th>8</th>
		<td><div><form method="post">
			<input type="hidden" name="time" value="M8">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="T8">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="W8">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="R8">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="F8">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
	</tr><tr>
		<th>9</th>
		<td><div><form method="post">
			<input type="hidden" name="time" value="M9">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="T9">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="W9">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="R9">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="F9">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
	</tr><tr>
		<th>10</th>
		<td><div><form method="post">
			<input type="hidden" name="time" value="M10">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="T10">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="W10">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="R10">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="F10">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
	</tr><tr>
		<th>11</th>
		<td><div><form method="post">
			<input type="hidden" name="time" value="M11">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="T11">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="W11">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="R11">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="F11">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
	</tr><tr>
		<th>12</th>
		<td><div><form method="post">
			<input type="hidden" name="time" value="M12">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="T12">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="W12">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="R12">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="F12">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
	</tr><tr>
		<th>1</th>
		<td><div><form method="post">
			<input type="hidden" name="time" value="M1">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="T1">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="W1">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="R1">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="F1">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
	</tr><tr>
		<th>2</th>
		<td><div><form method="post">
			<input type="hidden" name="time" value="M2">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="T2">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="W2">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="R2">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="F2">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
	</tr><tr>
		<th>3</th>
		<td><div><form method="post">
			<input type="hidden" name="time" value="M3">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="T3">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="W3">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="R3">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="F3">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
	</tr><tr>
		<th>4</th>
		<td><div><form method="post">
			<input type="hidden" name="time" value="M4">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="T4">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="W4">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="R4">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="F4">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
	</tr><tr>
		<th>5</th>
		<td><div><form method="post">
			<input type="hidden" name="time" value="M5">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="T5">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="W5">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="R5">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
		<td><div><form method="post">
			<input type="hidden" name="time" value="F5">
			<input type="hidden" name="timeset" value="true">
			<input class="invis" type="submit" value="">
		</form></div></td>
	</tr>
	</table><br>
	<div style="display:block;width:300;" class="center">
	<?php
		if($update == 0)
			echo 'Conflicting times';
		if($_POST[timeset]){
			$query = 'SELECT classname FROM Classes JOIN classtime ON id=classid
				WHERE time1 = "'.$_POST[time].'" OR time2 = "'.$_POST[time].'" OR time3 = "'.$_POST[time].'" OR time4 = "'.$_POST[time].'"
				OR time5 = "'.$_POST[time].'" OR time6 = "'.$_POST[time].'"';
			$classct = 0;
			if($result = mysqli_query($link, $query)){
				echo '<form method="post" id="pick">';
				echo '<input type="hidden" name="timepick" value="'.$_POST[time].'">';
				while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
					echo '<input type="radio" name="classname" value="'.$row["classname"].'">'.$row["classname"].'<br>';
					$classct += 1;
				}
				if($classct > 0)
					echo '<input type="submit" value="Submit"></form>';
				else
					echo '<p> No classes at that time </p></form>';
			} 
		}
	?>
	</div>
	</body>
</html>