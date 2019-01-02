<?php

$con=mysqli_connect("localhost","root","","social_network");


	if(isset($_POST['sign_up']))
	{

		$first_name = htmlentities(mysqli_real_escape_string($con,$_POST['f_name']));
		$last_name = htmlentities(mysqli_real_escape_string($con,$_POST['l_name']));
		$pass = htmlentities(mysqli_real_escape_string($con,$_POST['password']));
		$email = htmlentities(mysqli_real_escape_string($con,$_POST['email']));
		$country = htmlentities(mysqli_real_escape_string($con,$_POST['country']));
		$gender = htmlentities(mysqli_real_escape_string($con,$_POST['gender']));
		$birthday = htmlentities(mysqli_real_escape_string($con,$_POST['dob']));
		#$occupation = htmlentities(mysqli_real_escape_string($con,$_POST['occupation']));
		#$status = "verified";
		#$posts = "no";
		$newgid = sprintf('%05d', rand(0, 999999));

		$username = strtolower($first_name . "_" . $last_name . "_" . $newgid);
	

		if(strlen($pass) <9 )
		{
			echo"<script>alert('Password should be minimum 9 characters!')</script>";
			exit();
		}

		$check_email = "select * from user where email='$email'";
		$run_email = mysqli_query($con,$check_email);

		$check = mysqli_num_rows($run_email);

		if($check == 1)
		{
			echo "<script>alert('Email already exist, Please try using another email')</script>";
			echo "<script>window.open('signup.php', '_self')</script>";
			exit();
		}
		
		$profile_pic="defaultm.jpg";

	   $passnew=sha1($pass);
		
		$insert = "insert into user (email,f_name,l_name,password,country,gender,dob,user_image)
		values('$email','$first_name','$last_name','$passnew','$country','$gender','$birthday','$profile_pic')";
		
		
		$query = mysqli_query($con, $insert);

		if($query)
		{

			echo "<script>alert('Well Done, you are good to go.')</script>";
			echo "<script>window.open('signin.php', '_self')</script>";
		}
		else
		{
			
			echo $email."</br>".$first_name."</br>".$last_name."</br>".$pass."</br>".$country."</br>".$gender."</br>".$birthday."</br>".$profile_pic."</br>";
			echo "<script>alert('Registration failed, please try again!')</script>";
			#echo "<script>window.open('signup.php', '_self')</script>";
		}
	}

	mysqli_close($con);
?>