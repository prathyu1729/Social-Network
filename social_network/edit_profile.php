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
	
	<title>Edit account settings</title>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style/home_style2.css">
</head>
<body>
<div class="row">
	<div class="col-sm-2">
	</div>
	<div class="col-sm-8">
		<form action=" "method="post" enctype="mutlipart/form-data">
		<table class="table table-bordered table-hover">
			<tr align="center">
			<td colspan="6" class="active"><h2>Edit your profile</h2></td>
		</tr>
		<tr>
			<td style="font-weight:bold; ">Change Your Firstname</td>
			<td> 
				<input class="form control" type="text" name="f_name" required value="<?php echo $first_name;?>">

			</td>

		</tr>

		<tr>
			<td style="font-weight:bold; ">Change Your Lastname</td>
			<td> 
				<input class="form control" type="text" name="l_name" required value="<?php echo $last_name;?>">

			</td>

		</tr>

		<tr>
			<td style="font-weight:bold; ">Change Your Password</td>
			<td> 
				<input class="form control" type="password" name="u_pass" id="mypass">
				

			</td>

		</tr>

		<tr>
			<td style="font-weight:bold; ">Email</td>
			<td> 
				<input class="form control" type="email" name="u_email" required value="<?php echo $user_email;?>">

			</td>

		</tr>

		<tr>
			<td style="font-weight:bold; ">Country</td>
			<td> 
				<select class="form-control"  name="u_country">
				<option><?php echo $user_country?></option>
							<option>India</option>
							<option>United States of America</option>
							<option>Pakistan</option>
							<option>Japan</option>
							<option>UK</option>
							<option>France</option>
							<option>Germany</option>
					</select> 

			</td>

		</tr>

           <tr>
			<td style="font-weight:bold; ">Gender</td>
			<td> 
				<select class="form-control"  name="u_gender">
				<option><?php echo $user_gender?></option>
							<option>Male</option>
							<option>Female</option>
							<option>Others</option>
					</select> 

			</td>

		   </tr>

		    

		    <tr>
			<td style="font-weight:bold; ">Change Password Recovery details</td>
			<td> 
				<button type="button"
				class="btn btn-default" data-toggle="modal"
				data-target="#myModal">Click here</button>

				<div id="myModal" class="modal fade" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">
								Modal Header</h4>
							</div>
						<div class="modal-body">
							<form action="recovery.php?id=<?php echo $user_id;?>" method="post" id="f">
								<strong>Who is your bestfriend?</strong>
								<input type="text" class="form-control"
								 name="content" placeholder="someone">
									
								</textarea>
								<br>
								<input type="submit" name="sub" value="Submit"

								style="width:100px;"><br><br>
								<pre>Answer the above question.<br>This question will be asked when you forget your password.</pre>
								<br><br>
							</form>
							<?php

							if(isset($_POST['sub']))
							{

								$bfn=htmlentities($_POST['content']);

								if($bfn=='')
								{

								echo "<script>alert('please enter something')</script>";
								echo "<script>window.open('edit_profile.php?u_id$user_id','_self')</script>";

								exit();

								}

								else
								{
									$update="update user set recovery_account='$bfn'
									where user_id='$user_id'";

									$run=mysqli_query($con,$update);

									if($run)
									{
										echo"<script >alert('Password recovery details changed')</script>";
										echo"<script >window.open('edit_profile.php?u_id$user_id','_self')</script>";

									}

									else
									{
										echo"<script>alert('Error while updating information')</script>";
										echo" <script >window.open('edit_profile.php?u_id$user_id','_self'</script>";



									}

								}



							}

							?>



						</div>
						
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>

			</td>

			</tr>

			<tr align="center">
				<td colspan="6">
				<input type="submit"class="btn btn-info" name="update" style="width:250px;" value="Update">
				</td>

			</tr>

		</table>
		</form>
	</div>
<div class="col-sm-2">
	
</div>


</div>

</body>
</html>
<?php
if(isset($_POST['update']))
{

$f_name=htmlentities($_POST['f_name']);
$l_name=htmlentities($_POST['l_name']);
$country=htmlentities($_POST['u_country']);
$password=htmlentities($_POST['u_pass']);
$gender=htmlentities($_POST['u_gender']);
$email=htmlentities($_POST['u_email']);
echo "$country";
$passnew=sha1($password);
$update="update user set f_name='$f_name',l_name='$l_name',country='$country',password='$passnew',gender='$gender',email='$email' where user_id='$user_id'";

$run=mysqli_query($con,$update);

if($run)
{
	echo"<script >alert('profile edited')</script>";
	echo"<script >window.open('edit_profile.php?u_id$user_id','_self')</script>";

}

else
{
	echo"<script>alert('Error while updating information')</script>";
	echo("error description:".mysqli_error($con));
	echo" <script >window.open('edit_profile.php?u_id$user_id','_self'</script>";
}







}




?>