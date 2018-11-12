<?php

include("../db.php");
$user_id=$_REQUEST['user_id'];

$result=mysqli_query($con,"select user_id, email, password from user_info where user_id='$user_id'")or die ("query 1 incorrect.......");

list($user_id,$user_name,$user_password)=mysqli_fetch_array($result);

if(isset($_POST['btn_save'])) 
{
$user_name=$_POST['email'];
$user_password=$_POST['password'];

mysqli_query($con,"update user_info set email='$user_name', password='$user_password' where user_id='$user_id'")or die("Query 2 is inncorrect..........");

header("location: manage_users.php");
mysqli_close($con);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Admin Panel</title>
 <meta name="viewport" content="width=device-width, initial-scale=1">
<link href="style/css/bootstrap.min.css" rel="stylesheet">
<link href="style/css/k.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
</head>
<body>
<?php include("include/header.php"); ?>
   	<div class="container-fluid main-container">
	<?php include("include/side_bar.php");?>
    
	<div class="col-md-9 content" align="center">  
<div class="panel-heading" style="background-color:#c4e17f">
	<h1>Edit User Details </h1></div><br>
<form action="edit_user.php" name="form" method="post" enctype="multipart/form-data">
<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id;?>" />


<div class="col-sm-7 ">
    <label style="font-size:18px;">Email</label><br>
    <input class="input-lg" style="font-size:18px; width:200px" name="email" type="text"  id="email" value="<?php echo $user_name; ?>" autofocus><br><br>
    </div>


<div class="col-sm-7 ">
<label style="font-size:18px;">Password</label><br>
<input class="input-lg" style="font-size:18px; width:200px" name="password" type="text"  id="password" value="<?php echo $user_password; ?>">
    <br><br></div>
    <div class="col-sm-7">
        <button type="submit" class="btn btn-success " name="btn_save" id="btn_save" style="font-size:18px">Submit</button></div>
</form>
</div></div>
<?php include("include/js.php");?>
</body>
</html>