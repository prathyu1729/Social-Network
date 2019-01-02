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
<body>
	<br><br>
<div class="row">
	<div class="col-sm-12">
		<div class="main-content">
			<div class="header">
				<h3 style="text-align: center;"><strong>Do you want to really remove your account?<br><br></strong></h3>
			</div>
			<div class="l-part">
					<form action="" method="post">
						<center><button id="yes" class="btn btn-info btn-lg" name="yes">Yes</button></center><br>
						<center><button id="no" class="btn btn-info btn-lg" name="no">No</button></center>
						<?php include("remove.php"); ?>
					</form>
			</div>
		</div>
	</div>
</div>

</body>
</html>