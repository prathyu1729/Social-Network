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
	<?php
		$user = $_SESSION['email'];
		$get_user = "select * from user where email='$user'";
		$run_user = mysqli_query($con,$get_user);
		$row = mysqli_fetch_array($run_user);
		if (!$run_user)
		 {
    		printf("Error: %s\n", mysqli_error($con));
    		exit();
		}

		$user_name = $row['f_name'];
	?>
	<title><?php echo "$user_name"; ?></title>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style/home_style2.css">
</head>
<style>
	#cover-img{
		height: 400px;
		width: 100%;
	}#update_profile{
		position: absolute;
		top: 58%;
		left: 50%;
		cursor: pointer;
		transform: translate(-50%, -50%);
	}
	#button_profile{
		position: absolute;
		top: 67%;
		left: 50%;
		cursor: pointer;
		transform: translate(-50%, -50%);
	}
	#own_posts{
		border: 5px solid #e6e6e6;
		padding: 40px 50px;
	}
	#post_img
	{
		height: 300px;
		width: 100%;
	}
</style>
<body>



	


	<?php
		if(isset($_POST['update']))
		{

				$u_image = $_FILES['u_image']['name'];
				$image_tmp = $_FILES['u_image']['tmp_name'];
				$random_number = rand(1,100);

				if($u_image=='')
				{
					echo "<script>alert('Please Select Profile Image on clicking on your profile image')</script>";
					echo "<script>window.open('profile.php?u_id=$user_id' , '_self')</script>";
					exit();
				}
				else 
				{
					move_uploaded_file($image_tmp, "users/$u_image.$random_number");
					$update = "update user set user_image='$u_image.$random_number' where user_id='$user_id'";

					$run = mysqli_query($con, $update);

					if($run)
					{
					echo "<script>alert('Your Profile Updated')</script>";
					echo "<script>window.open('profile.php?u_id=$user_id' , '_self')</script>";
					}
				}

			}
	?>


<div class="row">
	<div class="col-sm-2" style="background-color: #e6e6e6;text-align: center;left: 0.8%;border-radius: 5px;">
		<?php
		echo"
			<center><h2><strong>About</strong></h2></center>
			<center><h4><strong>$first_name $last_name</strong></h4></center>
			<center>
				<img src='users/$user_image' alt='Profile' class='img-circle' width='180px' height='185px'>
				
				<form action='profile.php?u_id='$user_id' method='post' enctype='multipart/form-data'>
				<label id='update_profile'> Select New Profile
				<input type='file' style='display:none' name='u_image' size='60' />
				</label>
				<button id='button_profile' name='update' class='btn btn-info'>Update Profile</button>
				</form>
			</center>
			<br><br>
<br>
<br> <br><br>
<br>
<br><br>
			<p><strong>Lives In: </strong> $user_country</p><br>
			<p><strong>Gender: </strong> $user_gender</p><br>
			<p><strong>Date of Birth: </strong> $user_birthday</p><br>
		";
		?>
	</div>
	
	<div class = "col-sm-6">
		<?php
			global $con;
			if(isset($_GET['u_id']))
			{
				$u_id = $_GET['u_id'];
			}
			$get_posts = "SELECT * FROM POSTS WHERE user_id = '$u_id' ORDER BY 1 DESC LIMIT 5"; #<!-- show only 5 latest posts>
			$run_posts = mysqli_query($con, $get_posts);
			
			while($row_posts = mysqli_fetch_array($run_posts))
			{
				$post_id = $row_posts['post_id'];
				$user = $row_posts['user_id'];
				$content = $row_posts['post_content'];
				$upload_image = $row_posts['upload_image'];
				$post_date = $row_posts['post_date'];
				
				$user = "SELECT * FROM user WHERE user_id = '$user_id' AND posts = 'yes'";
				$run_user = mysqli_query($con, $user);
				$row_user = mysqli_fetch_array($run_user);
				
				$user_name = $row_user['f_name'];
				$user_image = $row_user['user_image'];
				#Now display posts from database
				if($content == "No" && strlen($upload_image) >= 1)
				{
					echo"
					<div id = 'own_posts'>
						<div class = 'row'>
							<div class = 'col-sm-2'>
								<p><img src='users/$user_image' class='img-circle' width='100px' height='100px'></p>
							</div>
							<div class = 'col-sm-6'>
								<h3><a style='text-decoration:none; cursor:pointer;color #3897f0;' href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
								<h4><small style='color:black;'>Updated a post on <strong>$post_date</strong></small></h4>
							</div>
							<div class = 'col-sm-4'>
							</div>
						</div>
						<div class = 'row'>
							<div class = 'col-sm-12'>
								<img id='posts-img' src='imagepost/$upload_image' style='height:350px;'>
							</div>
						</div><br>
						<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-success'>View</button></a>
						<a href='functions/delete_post.php?post_id=$post_id' style='float:right;'><button class='btn btn-danger'>Delete</button></a>
					</div><br><br>
					";
				}
				else if(strlen($content) >= 1 && strlen($upload_image) >= 1)
				{
					echo"
					<div id = 'own_posts'>
						<div class = 'row'>
							<div class = 'col-sm-2'>
								<p><img src='users/$user_image' class='img-circle' width='100px' height='100px'></p>
							</div>
							<div class = 'col-sm-6'>
								<h3><a style='text-decoration:none; cursor:pointer;color #3897f0;' href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
								<h4><small style='color:black;'>Updated a post on <strong>$post_date</strong></small></h4>
							</div>
							<div class = 'col-sm-4'>
							</div>
						</div>
						<div class = 'row'>
							<div class = 'col-sm-12'>
								<p>$content</p>
								<img id='posts-img' src='imagepost/$upload_image' style='height:350px;'>
							</div>
						</div><br>
						<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-success'>View</button></a>
						<a href='functions/delete_post.php?post_id=$post_id' style='float:right;'><button class='btn btn-danger'>Delete</button></a>
					</div><br><br>
					";
				}
				else
				{
					echo"
					<div id = 'own_posts'>
						<div class = 'row'>
							<div class = 'col-sm-2'>
								<p><img src='users/$user_image' class='img-circle' width='100px' height='100px'></p>
							</div>
							<div class = 'col-sm-6'>
								<h3><a style='text-decoration:none; cursor:pointer;color #3897f0;' href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
								<h4><small style='color:black;'>Updated a post on <strong>$post_date</strong></small></h4>
							</div>
							<div class = 'col-sm-4'>
							</div>
						</div>
						<div class = 'row'>
							<div class = 'col-sm-2'>
							</div> 
							<div class = 'col-sm-6'>
								<h3><p>$content</p></h3>
							</div>
							<div class = 'col-sm-4'>
							</div>
						</div>
					"; //div is not closed here yet!!! See line 293 for closing div
					
					global $con;
					if(isset($_GET['u_id']))
					{
						$u_id = $_GET['u_id'];
					}
					$get_posts = "SELECT email FROM user WHERE user_id = '$u_id'";
					$run_user = mysqli_query($con, $get_posts);
					$row = mysqli_fetch_array($run_user);
					$user_email = $row['email'];
					$user = $_SESSION['email'];
					$get_user = "SELECT * FROM user WHERE email = '$user'";
					$run_user = mysqli_query($con, $get_user);
					$row = mysqli_fetch_array($run_user);
					$user_id = $row['user_id'];
					$u_email = $row['email'];
					
					if($u_email != $user_email)
					{
						echo "<script>window.open('profile.php?u_id=$user_id' , '_self')</script>";
					}
					else
					{
						echo"
						<a href='single.php?post_id=$post_id' style='float:right;'><button class='btn btn-success'>View</button></a>
						<a href='edit_post.php?post_id=$post_id' style='float:right;'><button class='btn btn-info'>Edit</button></a>
						<a href='functions/delete_post.php?post_id=$post_id' style='float:right;'><button class='btn btn-danger'>Delete</button></a>
						</div><br><br><br>
						";
					}
				}
				
				include("functions/delete_post.php");
			}	
		?>
	</div>
	<div class = 'col-sm-2'>
	</div>
</div>
</body>
</html>