<?php
session_start();

    $con=mysqli_connect("localhost","root","","social_network");

	if (isset($_POST['login'])) 
	{

		$email = htmlentities(mysqli_real_escape_string($con, $_POST['email']));
		$password = htmlentities(mysqli_real_escape_string($con, $_POST['password']));
		$passnew=sha1($password);

		$select_user = "select * from user where email='$email' AND password='$passnew'";

		$query= mysqli_query($con, $select_user);
		$check_user = mysqli_num_rows($query);
		$uid="select user_id from user where email='$email'";
		$query2= mysqli_query($con, $uid);
		$uid_row = mysqli_fetch_array($query2);
		$uid1 = $uid_row['user_id'];

		if($check_user == 1)
		{
			$_SESSION['email'] = $email;
			$insert="insert into login(userid)values('$uid1')";
			$query1= mysqli_query($con, $insert);
			//echo "<script>alert('Insertion is successful')</script>";
			echo "<script>window.open('home.php', '_self')</script>";
		 }
		 else
		 {
			echo"<script>alert('Your Email or Password is incorrect')</script>";
		}
	}
?>