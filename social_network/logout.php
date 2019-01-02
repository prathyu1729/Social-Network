<!DOCTYPE html>
<html>
<head>
	
	
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style/home_style2.css">
</head>

<body>
</body>
</html>


<?php

$con=mysqli_connect("localhost","root","","social_network");
session_start();
$email=$_SESSION['email'];
$query="delete from login where userid in (select user_id from user where email='$email')";
$run=mysqli_query($con,$query);

session_destroy();

header("location:index.php");
?>