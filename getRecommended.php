<?php session_start(); 
if(!isset($_SESSION['username']))
	header('Location: http://coursesuggest.web.engr.illinois.edu/index.html');
$link = mysqli_connect("engr-cpanel-mysql.engr.illinois.edu","coursesuggest_sy","asdf1234","coursesuggest_main");

?>
<!DOCTYPE HTML>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<title>Recommended Classes</title>
	<link rel="stylesheet" href="css/acctstyle.css" type="text/css">
	<style>
		table, th {border: 1px solid black;}
		td {border-right: 1px solid black; padding:5px;}
	</style>
</head>
<body>
	<div id="header">
		<div id="header2">
			<ul id="navigation">
				<li>
					<a href="account.php">Home</a>
				</li>
				<li class="active">
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
	<?php
	
        $classRatingQuery = mysqli_query($link, "SELECT classname,AVG(rating) as avgRating FROM Classes, ratings WHERE  Classes.id=classid and Classes.id not in (Select ClassId from (ClassTaken Inner Join Students on StudentID = Students.id) where Students.username = '$_SESSION[username]' and ClassTaken.StudentID = Students.id) GROUP BY classname");
        
        $majorRequire = mysqli_query($link, "SELECT classname FROM Major, MajorRequirements,Students, Classes WHERE Students.username = '$_SESSION[username]' and Students.MajorID = Major.id and MajorRequirements.MajorID = Students.MajorID and MajorRequirements.ClassID = Classes.id and Classes.id not in (Select ClassId from ClassTaken, Students where Students.username = '$_SESSION[username]' and ClassTaken.StudentID = Students.id) ");
        
        $topicClass = mysqli_query($link, "SELECT distinct classname FROM InterestTopics, Students, Classes WHERE StudentID=Students.id AND Students.username = '$_SESSION[username]' AND topics = topic and Classes.id not in (Select ClassId from ClassTaken, Students where Students.username = '$_SESSION[username]' and ClassTaken.StudentID = Students.id)" );
        
        //echo 'Classnames received:<br>';
	$classScores = [];
	if($classRatingQuery){
		//echo '--Rating query:<br>';
		while($row = mysqli_fetch_array($classRatingQuery, MYSQLI_ASSOC)){
			//echo '--'.$row['classname'].'<br>';
			if(isset($classScores[$row['classname']])){
				$classScores[$row['classname']] += (10*($row['avgRating']-1));
			} else {
				$classScores[$row['classname']] = (10*($row['avgRating']-1));
			}
		}
	} else { echo 'classRatingQuery empty<br>'; }
	
	if($majorRequire){
		//echo '<br>--Major required query:<br>';
		while($row = mysqli_fetch_array($majorRequire, MYSQLI_ASSOC)){
			//echo '--'.$row['classname'].'<br>';
			if(isset($classScores[$row['classname']])){
				$classScores[$row['classname']] += 30;
			} else {
				$classScores[$row['classname']] = 30;
			}
		}
	}  else { echo '<br>majorRequire query empty<br>'; }
	
	//$topics = [];
	if($topicClass){
		//echo '<br>--Same topic query:<br>';
		while($row = mysqli_fetch_array($topicClass, MYSQLI_ASSOC)){
			//echo '--'.$row['classname'].'<br>';
			//if(!isset($topics[$row['classname']])){
				//$topics[$row['classname']] = 1;
				if(isset($classScores[$row['classname']])){
					$classScores[$row['classname']] += 30;
				} else {
					$classScores[$row['classname']] = 30;
				}
			//} 
		}
	}  else { echo '<br>topicClass query empty<br>'; }
	
	echo '<br>';
	echo '<table class="center" style="border-collapse:collapse;">';
	echo '<tr>';
        echo '<th>Recommended Classes</th><th>Score</th>';
        echo '</tr><br>' ;
        arsort($classScores);
	foreach ($classScores as $className => $score){
		echo '<tr>';
		echo '<td>'.$className.'</td><td style="text-align:center;">'.$classScores[$className].'</td>';
		echo '</tr>';
	}
	echo '</table>';

        /*
	$classScores = [];
	if($result = mysqli_query($link, $query)){
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			if(isset($classScores[$row['classname']]){
				$classScores[$row['classname']] += 10; //replace 10 with proper score for each query
			} else {
				$classScores[$row['classname']] = 10;
			}
		}
	}

	arsort($classScores);
	foreach ($classScores as $className => $score){
		echo $className.'<br>';
	}
	*/
	?>
</body>
</html>