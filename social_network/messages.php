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
	<title>Messages</title>
	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style/home_style2.css">
</head>
<style>


#scroll_messages
{
    max-height: 500px;
    overflow: scroll;
}


#btn-msg
{
    width: 20%;
    height: 28px;
    border-radius: 5px;
    margin: 5px;
    border: none;
    color: #fff;
    float: right;
    background-color: #2ecc71;
}


#select_user
{
    max-height: 500px;
    overflow: scroll;
}
#green
{
    background-color: #2ecc71;
    border-color: #27ae60;
    width= 45%;
    padding: 2.5px;
    font-size: 16px;
    border-radius: 3px;
    float: left;
    margin-bottom: 5px;
}
#blue
{
    background-color: #3498db;
    border-color: #2980b9;
    width= 45%;
    padding: 2.5px;
    font-size: 16px;
    border-radius: 3px;
    float: right;
    margin-bottom: 5px;
}
#msg_timestamp_blue
{
    text-color: #e6e6e6;
    font-size: 10px;
    float: right;
}
#msg_timestamp_green
{
    text-color: #e6e6e6;
    font-size: 10px;
    float: left;
}
</style>
<body>
<div class='row'>
    <?php
        if(isset($_GET['u_id']))
        {
            global $con;
            $get_id = $_GET['u_id'];
            $get_user = "SELECT * FROM user WHERE user_id='$get_id'";
            $run_user = mysqli_query($con, $get_user);
            $row_user = mysqli_fetch_array($run_user);

            $user_to_msg = $row_user['user_id'];
            //$user_to_name = $row_user['user_name'];
        }

        $user = $_SESSION['email'];
        $get_user = "SELECT * FROM user WHERE email='$user'";
        $run_user = mysqli_query($con, $get_user);
        $row = mysqli_fetch_array($run_user);

        $user_from_msg = $row['user_id'];
        //$user_from_name = $row['user_name'];
    ?>

    <div class='col-sm-3' id='select-user'>
        <?php
            $user = "SELECT * FROM user";
            $run_user = mysqli_query($con, $user);
            while($row_user = mysqli_fetch_array($run_user))
            {
                $user_id = $row_user['user_id'];
                //$user_name = $row_user['user_name'];
                $first_name = $row_user['f_name'];
                $last_name = $row_user['l_name'];
                $user_image = $row_user['user_image'];

                echo"
                    <div class='container-fluid'>
                        <a style='text-decoration: none; cursor: pointer; color: #3897f0' href='messages.php?u_id=$user_id'>
                            <img class='img-circle' src='users/$user_image' width='90px' height='80px title='$first_name'><strong>&nbsp $first_name $last_name</strong><br><br>
                        </a>
                    </div>
                ";
            }
        ?>
    </div>
    <div class='col-sm-6'>
            <div class='load_msg' id='scroll_messages'>
            <?php
                if(isset($_POST['send_msg']))
                {
                    $msg = htmlentities($_POST['msg_box']);
                    if($msg == "")
                    {
                        echo "<h4 style='color: red; text-align: center;'> Unable to send message</h4>";
                    }
                    
                    else 
                    {
                        $insert = "insert into messages (user_to, user_from, msg_body, date, msg_seen) values('$user_to_msg', '$user_from_msg', '$msg', NOW(), 'no')";
                        $run_insert = mysqli_query($con, $insert);
                    }
                }
            ?>








                <?php
                    $sel_msg = "SELECT * FROM messages WHERE (user_to = '$user_to_msg' AND user_from = '$user_from_msg') OR (user_from = '$user_to_msg' AND user_to = '$user_from_msg') order by 1 asc";
                    $run_msg = mysqli_query($con, $sel_msg);

                    while($row_msg = mysqli_fetch_array($run_msg))
                    {
                        $user_to = $row_msg['user_to'];
                        $user_from = $row_msg['user_from'];
                        $msg_body = $row_msg['msg_body'];
                        $msg_date = $row_msg['date'];
                        $msg_seen = $row_msg['msg_seen'];
                        $msg_id = $row_msg['id'];
                        ?>

                        <div id='loaded_msg'>
                            <p>
                            <?php
                                if($user_to == $user_to_msg AND $user_from == $user_from_msg)
                                {
                                    echo"
                                        <div class='message' id='blue' data-toggle='tooltip' title='$msg_date'>$msg_body</div><br><br>
                                        <div id='msg_timestamp_blue'>Sent at $msg_date
                                    ";
                                    if($msg_seen == "yes"){
                                        echo"(Seen)</div><br><br>";
                                    }
                                    else{
                                        echo"</div><br><br>";
                                    }
                                }
                                else if($user_from == $user_to_msg AND $user_to == $user_from_msg)
                                {
                                    echo"
                                        <div class='message' id='green' data-toggle='tooltip' title='$msg_date'>$msg_body</div><br><br>
                                        <div id='msg_timestamp_green'>Sent at $msg_date
                                    ";
                                    if($msg_seen == "yes"){
                                        echo"(Seen)</div><br><br>";
                                    }
                                    else{
                                        echo"</div><br><br>";
                                    }
                                    $seen_query = "UPDATE messages SET msg_seen = 'yes' WHERE id = '$msg_id'";
                                    $run_seen_query = mysqli_query($con, $seen_query);
                                }
                            ?>
                            </p>
                        </div>

                        <?php
                    }
                ?>
            </div>
            <?php
                if(isset($_GET['u_id']))
                {
                    $u_id = $_GET['u_id'];
                    if($u_id == "new")
                    {
                        echo"
                            <form>
                                <center><h3>Select someone to talk to</h3></center>
                                <textarea disabled class='form-control' placeholder='Enter your message'></textarea>
                                <input type='submit' class='btn btn-default' disabled value='Send'>
                            </form><br><br>
                        ";
                    }
                    else
                    {
                        echo"
                            <form action='' method='POST'>
                                <textarea class='form-control' placeholder='Enter your message' name='msg_box' id='message_textarea'></textarea>
                                <input type='submit' name='send_msg' id='btn-msg' value='Send'>
                            </form><br><br>
                        ";
                    }
                }
            ?>

    </div>
    <div class='col-sm-3'>
        <?php
            if(isset($_GET['u_id']))
            {
                $u_id = $_GET['u_id'];
                $get_user = "SELECT * FROM user WHERE user_id='$get_id'";
                $run_user = mysqli_query($con, $get_user);
                $row = mysqli_fetch_array($run_user);

                $user_id = $row['user_id'];
                $f_name = $row['f_name'];
                $l_name = $row['l_name'];
                $country = $row['country'];
                $gender = $row['gender'];
                $user_image = $row['user_image'];
            }
            if($get_id != "new")
            {
                echo"
                    <div class='row'>
                        <div class='col-sm-2'>
                        </div>
                        <center>
                        <div style='background-color: #e6e6e6;' class='col-sm-9'>
                            <h2>Information</h2>
                            <img class='img-circle' src='users/$user_image' width='150' height='150'><br><br>
                            <ul class='list-group'>
                                <li class='list-group-item' title='Username'><strong>$f_name $l_name</strong></li>
                            </ul>
                        </div>
                        <div class='col-sm-1'>
                        </div>
                    </div>
                ";
            }
        ?>
    </div>
</div>
<script>
    var div = document.getElementById("scroll_messages");
    div.scrollTop = div.scrollHeight;
</script>
</body>
</html>