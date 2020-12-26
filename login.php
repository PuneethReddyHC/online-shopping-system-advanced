<?php
include "db.php";

session_start();

#Login script is begin here
#If user given credential matches successfully with the data available in database then we will echo string login_success
#login_success string will go back to called Anonymous funtion $("#login").click() 

if (!empty(trim($_POST["email"])) && !empty(trim($_POST["password"]))) {
	//sanitize post params
	$filterPost = filter_input_array(INPUT_POST, [
		"password" => FILTER_SANITIZE_STRING,
		"email" => FILTER_SANITIZE_EMAIL
	]);

	$email = mysqli_real_escape_string($con, $filterPost["email"]);
	$password = $filterPost["password"];

	$stmt = $con->prepare("SELECT * FROM user_info WHERE email = ? AND password = ?");
	$stmt->bind_param("ss", $email, $password);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_array(MYSQLI_ASSOC);

	//if user record is available in database
	if (!empty($row)) {
		//we have created a cookie in login_form.php page so if that cookie is available means user is not login	
		$_SESSION["uid"] = $row["user_id"];
		$_SESSION["name"] = $row["first_name"];
		$ip_add = getenv("REMOTE_ADDR");

		if (isset($_COOKIE["product_list"])) {
			$p_list = stripcslashes($_COOKIE["product_list"]);
			//here we are decoding stored json product list cookie to normal array
			$product_list = json_decode($p_list, true);
			for ($i = 0; $i < count($product_list); $i++) {
				//After getting user id from database here we are checking user cart item if there is already product is listed or not
				$verify_cart = "SELECT id FROM cart WHERE user_id = $_SESSION[uid] AND p_id = " . $product_list[$i];
				$result  = mysqli_query($con, $verify_cart);
				if (mysqli_num_rows($result) < 1) {
					//if user is adding first time product into cart we will update user_id into database table with valid id
					$update_cart = "UPDATE cart SET user_id = '$_SESSION[uid]' WHERE ip_add = '$ip_add' AND user_id = -1";
					mysqli_query($con, $update_cart);
				} else {
					//if already that product is available into database table we will delete that record
					$delete_existing_product = "DELETE FROM cart WHERE user_id = -1 AND ip_add = '$ip_add' AND p_id = " . $product_list[$i];
					mysqli_query($con, $delete_existing_product);
				}
			}
			//here we are destroying user cookie
			setcookie("product_list", "", strtotime("-1 day"), "/");
			//if user is logging from after cart page we will send cart_login
			echo "cart_login";


			exit();
		}
		//if user is login from page we will send login_success
		echo "login_success";
		$BackToMyPage = $_SERVER['HTTP_REFERER'];
		if (!isset($BackToMyPage)) {
			header('Location: ' . $BackToMyPage);
			echo "<script type='text/javascript'>
					
					</script>";
		} else {
			header('Location: index.php'); // default page
		}


		exit;
	} else {

		$stmt = $con->prepare("SELECT * FROM admin_info WHERE admin_email = ? AND admin_password = ?");
		$stmt->bind_param("ss", $email, md5($password));
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_array(MYSQLI_ASSOC);

		//if admin record is available in database 
		if (!empty($row)) {

			$_SESSION["uid"] = $row["admin_id"];
			$_SESSION["name"] = $row["admin_name"];
			$ip_add = getenv("REMOTE_ADDR");
			//we have created a cookie in login_form.php page so if that cookie is available means user is not login


			//if user is login from page we will send login_success
			echo "login_success";

			echo "<script> location.href='admin/add_product.php'; </script>";
			exit;
		} else {
			echo "<span style='color:red;'>Please register before login..!</span>";
			exit();
		}
	}
}
?>