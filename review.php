<?php
session_start();
include "db.php";
if (isset($_POST["review"])) {

	$name       = $_POST["name"];
	$email      = $_POST["email"];
	$review     = $_POST['review'];
	$rating     = (int) $_POST['rating'];
	$product_id = (int) $_POST['product_id'];
    $datetime   = date('Y-m-d H:i:s');

		$stmt = $con->prepare("SELECT review_id FROM reviews WHERE email = ? AND product_id = ?");
		$stmt->bind_param("si", $email, $product_id);
		$stmt->execute();
		$check_query = $stmt->get_result();
		$count_email = mysqli_num_rows($check_query);
		if($count_email > 0){
			echo "
				<div class='alert alert-danger'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<b>Multiple reviews are not Allowed</b>
				</div>
			";
			exit();
		}else{
			$stmt = $con->prepare("INSERT INTO `reviews` (`review_id`, `product_id`, `name`, `email`, `review`, `datetime`, `rating`) VALUES (NULL, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("issssi", $product_id, $name, $email, $review, $datetime, $rating);

			if($stmt->execute()){
				echo "Thanks for Better reach ";
				echo "<script> location.href='product.php?q=$product_id'; </script>";
				exit;
			}else {
				echo "something went wrong";
			}
		}
	
}



?>






















































