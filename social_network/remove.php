<?php
	//session_start();
    $con=mysqli_connect("localhost","root","","social_network");
    $user=$_GET['u_id'];
    echo"$user";
	if (isset($_POST['yes'])) 
	{
		$delete = "delete from user where user_id='$user'";
		$query= mysqli_query($con, $delete);
		$check_user = mysqli_num_rows($query);
		echo "Check user = $check_user";
		if(!$query)
		{
			 echo("Error description: " . mysqli_error($con)."");

		}

		if($query)
		{
			echo"<script>alert('Account deleted')</script>";
			echo "<script>window.open('main.php', '_self')</script>";
		 }
		 else 
		 {
			echo"<script>alert('Not working')</script>";
		 }
	}

	else if (isset($_POST['no'])) 
	{

		echo "<script>window.open('home.php', '_self')</script>";
	}
?>