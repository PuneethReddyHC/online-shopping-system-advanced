<?php
session_start();
include "db.php";
if (isset($_POST["review"])) {

	$name = $_POST["name"];
	$email = $_POST["email"];
	$review = $_POST['review'];
	$rating = $_POST['rating'];
	$product_id =$_POST['product_id'];
    $datetime =  date('Y-m-d H:i:s');
		
		$sql = "SELECT review_id FROM reviews WHERE email = '$email' AND product_id = '$product_id' ";
		$check_query = mysqli_query($con,$sql);
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
			$sql = "INSERT INTO `reviews` (`review_id`, `product_id`, `name`, `email`, `review`, `datetime`, `rating`) 
			VALUES  (NULL, '$product_id','$name', '$email', 
			'$review','$datetime', '$rating')";
			
			if(mysqli_query($con,$sql)){
				echo "Thanks for Better reach ";
				echo "<script> location.href='product.php?q=$product_id'; </script>";
				exit;
			}else {
				echo "something went wrong";
			}
		}
	
}



?>






















































