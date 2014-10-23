<?php session_start();
if(!isset($_SESSION['username']))
	header('Location: http://coursesuggest.web.engr.illinois.edu/index.html');
session_destroy();
header('Location: http://coursesuggest.web.engr.illinois.edu/index.html');
?>