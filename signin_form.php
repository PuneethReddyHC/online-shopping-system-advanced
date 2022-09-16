<?php
#this is Login form page , if user is already logged in then we will not allow user to access this page by executing isset($_SESSION["uid"])
#if below statment return true then we will send user to their profile.php page
//in action.php page if user click on "ready to checkout" button that time we will pass data in a form from action.php page
if(isset($_SESSION["uid"])){
	header('Location:index.php');
}
if (isset($_POST["login_user_with_product"])) {
	//this is product list array
	$product_list = $_POST["product_id"];
	//here we are converting array into json format because array cannot be store in cookie
	$json_e = json_encode($product_list);
	//here we are creating cookie and name of cookie is product_list
	setcookie("product_list",$json_e,strtotime("+1 day"),"/","","",TRUE);

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Login Page</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">


<!-- Google font -->
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet"/>

<!-- Bootstrap -->
<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>

<!-- Font Awesome Icon -->
<link rel="stylesheet" href="css/font-awesome.min.css">


<link rel="stylesheet" type="text/css" href="css/login_reg.css">
<link rel="stylesheet" type="text/css" href="css/utils.css">
<style>
		#toast {
    visibility: hidden;
    max-width: 50px;
    height: 50px;
    /*margin-left: -125px;*/
    margin: auto;
    background-color: #333;
    color: #fff;
    text-align: center;
    border-radius: 2px;

    position: fixed;
    z-index: 10;
    left: 0;right:0;
	bottom:30px;
    font-size: 17px;
    white-space: nowrap;
}
#toast #img{
width: 50px;
height: 50px;
    
    float: left;
    
    padding-top: 16px;
    padding-bottom: 16px;
    
    box-sizing: border-box;

    
    background-color: #111;
    color: #fff;
}
#toast #desc{

    
    color: #fff;
   
    padding: 16px;
    
    overflow: hidden;
white-space: nowrap;
}

#toast.show {
    visibility: visible;
    -webkit-animation: fadein 0.5s, expand 0.5s 0.5s,stay 3s 1s, shrink 0.5s 2s, fadeout 0.5s 2.5s;
    animation: fadein 0.5s, expand 0.5s 0.5s,stay 3s 1s, shrink 0.5s 4s, fadeout 0.5s 4.5s;
}

@-webkit-keyframes fadein {
    from {bottom: 0; opacity: 0;} 
    to {bottom: 30px; opacity: 1;}
}

@keyframes fadein {
    from {bottom: 0; opacity: 0;}
    to {bottom: 30px; opacity: 1;}
}

@-webkit-keyframes expand {
    from {min-width: 50px} 
    to {min-width: 350px}
}

@keyframes expand {
    from {min-width: 50px}
    to {min-width: 350px}
}
@-webkit-keyframes stay {
    from {min-width: 350px} 
    to {min-width: 350px}
}

@keyframes stay {
    from {min-width: 350px}
    to {min-width: 350px}
}
@-webkit-keyframes shrink {
    from {min-width: 350px;} 
    to {min-width: 50px;}
}

@keyframes shrink {
    from {min-width: 350px;} 
    to {min-width: 50px;}
}

@-webkit-keyframes fadeout {
    from {bottom: 30px; opacity: 1;} 
    to {bottom: 60px; opacity: 0;}
}

@keyframes fadeout {
    from {bottom: 30px; opacity: 1;}
    to {bottom: 60px; opacity: 0;}
}
	</style>
</head>
	<body style="background-color: #999999;">
    <div id="toast"><div id="desc"> login desc</div></div>
		<div class="limiter">
		<div class="container-login100">
		
		<div class="wrap-login100 p-l-50 p-r-50 p-t-72 p-b-50">
		<form  onsubmit="return false" id="login" class="login100-form validate-form">
		<span class="login100-form-title p-b-59">
		Login
		</span>
		<div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
		<span class="label-input100">Email</span>
		<input class="input100" type="email" name="email" placeholder="Email addess...">
		<span class="focus-input100"></span>
		</div>
		<div class="wrap-input100 validate-input" data-validate="Password is required">
		<span class="label-input100">Password</span>
		<input class="input100" type="password" name="password" placeholder="*************">
		<span class="focus-input100"></span>
		</div>
		<div class="flex-m w-full p-b-33">
		<div class="contact100-form-checkbox">
		<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
		<label class="label-checkbox100" for="ckb1">
		<span class="txt1">
		I agree to the
		<a href="#" class="txt2 hov1">
		Terms of User
		</a>
		</span>
		</label>
		</div>
		</div>
		<div class="container-login100-form-btn">
		<div class="wrap-login100-form-btn">
		<div class="login100-form-bgbtn"></div>
		<button class="login100-form-btn" type="submit">
		Sign in
		</button>
		</div>
		<a href="signup_form.php" class="dis-block txt3 hov1 p-r-30 p-t-10 p-b-10 p-l-30">
		Sign up
		<i class="fa fa-long-arrow-right m-l-5"></i>
		</a>
		<a href="index.php" class="dis-block txt3 hov1 p-r-30 p-t-40 p-b-10 p-l-150">
		Skip SignIn
		<i class="fa fa-long-arrow-right m-l-5"></i>
		</a>
		</div>
        <div class="alert alert-danger"><h4 id="e_msg"></h4></div>
		</form>
		</div>
        <div class="login100-more" style="background-image: url('img/slider_1.jpg');"></div>
		</div>
		</div>

		<script src="js/jquery.min.js"></script>
				<script src="js/bootstrap.min.js"></script>
				
				<script src="js/login_reg.js"></script>
				<script src="js/actions.js"></script>

		
	</body>
</html>