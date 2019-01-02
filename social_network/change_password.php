<!DOCTYPE html>
<?php
session_start();
include("includes/header.php");

if(!isset($_SESSION['email']))
{
	header("location: index.php");
}
?>

<html>
<head>
	<title>Forgot Password</title>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style/home_style2.css">
</head>
<style >
	
body{

overflow-x: :hidden;

}

.main-content
{
width:50%;
height:40%;
margin: 10px auto;
background-color: #fff;
border:2px solid #e6e6e6 ;
padding:40px 50px;


}

.header
{
border:0px solid #000;
margin-bottom: 5px;
}

.well
{
background-color:#187FAB;
}


#signup
{

width:60%;	
border-radius:30px;
}



</style>
<body>
<div class="row">
	<div class="col-sm-12">
		<div class="well">
			<center><h1 style="color:white;"><strong>Chatbox</strong></h1></center>
			
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="main-content">
			<div clas="header">
			<h3 style="text-align:center;"><strong>Change Your Password</strong></h3><hr>
		</div>
		<div class="l_pass">
			<form action="" method="post">
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
					<input id="password" type="password" class="form-control" name="pass" placeholder="new password" required>

				</div><br>

				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
					<input id="password" type="password" class="form-control" name="pass1" placeholder="Re-enter new password" required>

				</div><br>
				
				
				
				
				<center><button id="signup" class="btn btn-info btn-lg" name="change">Change Password</button></center>

			</form>
		</div>
	</div>
</div>

</div>
</body>
</html>

<?php
 $con=mysqli_connect("localhost","root","","social_network");

if(isset($_POST['change']))
{
	
	$user=$_SESSION['email'];
	$get_user="select* from user where email='$user'";

	$run_user=mysqli_query($con,$get_user);

	$user_id=$row['user_id'];




 $pass=htmlentities(mysqli_real_escape_string($con, $_POST['pass']));

	$pass1=htmlentities(mysqli_real_escape_string($con, $_POST['pass1']));

	if($pass==$pass1)
	{
		if(strlen($pass)>=6 && strlen($pass)<=60)
		{
			$passnew = sha1($pass);
			$update="update user set password='$passnew' where user_id='$user_id'";

			$run=mysqli_query($con,$update);
			echo"<script>alert('Your password has been changed')</script>";
			echo"<script>window.open('home.php','_self')</script>";
		}


		else
		{

		echo"<script>alert('Your password should be greater than 6 words')</script>";

		}
	}

	else
	{

	echo"<script>alert('Your password did not match')</script>";
	echo"<script>window.open('change_password.php','_self')</script>";


	}






}





?>
