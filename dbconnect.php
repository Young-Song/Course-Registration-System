<html>
<head><h2>UIUC Course Suggestor</h2></head>
<body>
<p>Connecting to database...<br>
<?php
$link = mysqli_connect('engr-cpanel-mysql.engr.illinois.edu', 'coursesuggest_fe', 'cs411DB', 'coursesuggest_main');

if (!$link) {
    die('Connect Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
    echo 'Failure to connect\n';
}
else
{
    echo 'Success... connected to ' . mysqli_get_host_info($link) . "\n";
}
mysqli_close($link);
?>
</p>
</body>
</html>