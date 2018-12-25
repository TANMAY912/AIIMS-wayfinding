<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
$d="2018-12-21 12:34:39";
$db = mysqli_connect("localhost","root","root","mysql"); 
$sql = "SELECT * FROM mysql.images WHERE created >= '2018-12-25' AND created < ('2018-12-25' + INTERVAL 1 DAY)";
echo "yash";
$sth = $db->query($sql);
$result=mysqli_fetch_array($sth);
echo '<img src="data:image/jpeg;base64,'.base64_encode( $result['image'] ).'"/>';
?>
</body>
</html>