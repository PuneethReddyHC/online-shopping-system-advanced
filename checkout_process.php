<?php
session_start();
include "db.php";
if (isset($_SESSION["uid"])) {
	
	// SECURITY FIX: Validate and sanitize all input
	$f_name = mysqli_real_escape_string($con, trim($_POST["firstname"]));
	$email = mysqli_real_escape_string($con, trim($_POST['email']));
	$address = mysqli_real_escape_string($con, trim($_POST['address']));
    $city = mysqli_real_escape_string($con, trim($_POST['city']));
    $state = mysqli_real_escape_string($con, trim($_POST['state']));
    $zip = mysqli_real_escape_string($con, trim($_POST['zip']));
    $cardname = mysqli_real_escape_string($con, trim($_POST['cardname']));
    $cardnumber = mysqli_real_escape_string($con, trim($_POST['cardNumber']));
    $expdate = mysqli_real_escape_string($con, trim($_POST['expdate']));
    $cvv = mysqli_real_escape_string($con, trim($_POST['cvv']));
    $user_id = $_SESSION["uid"];
    
    // SECURITY FIX: Fetch cart items directly from database instead of trusting POST
    $sql_cart_validate = "SELECT a.product_id, a.product_price, b.qty 
						  FROM products a 
						  INNER JOIN cart b ON a.product_id = b.p_id 
						  WHERE b.user_id = ?";
    $stmt_cart_validate = mysqli_prepare($con, $sql_cart_validate);
    
    if (!$stmt_cart_validate) {
        die("Error preparing statement: " . mysqli_error($con));
    }
    
    mysqli_stmt_bind_param($stmt_cart_validate, "i", $user_id);
    mysqli_stmt_execute($stmt_cart_validate);
    $result_cart_validate = mysqli_stmt_get_result($stmt_cart_validate);
    
    // Build validated cart items array
    $validated_cart = array();
    $calculated_total = 0;
    
    while ($cart_item = mysqli_fetch_assoc($result_cart_validate)) {
        $product_id = (int)$cart_item['product_id'];
        $product_price = (float)$cart_item['product_price'];
        $qty = (int)$cart_item['qty'];
        
        // Validate quantity is positive and reasonable
        if ($qty > 0 && $qty <= 100 && $product_price > 0) {
            $validated_cart[] = array(
                'product_id' => $product_id,
                'product_price' => $product_price,
                'qty' => $qty,
                'subtotal' => $product_price * $qty
            );
            $calculated_total += $product_price * $qty;
        }
    }
    mysqli_stmt_close($stmt_cart_validate);
    
    // SECURITY FIX: Validate that cart is not empty
    if (empty($validated_cart)) {
        echo "<script>alert('Your cart is empty or contains invalid items!'); window.location.href='cart.php';</script>";
        exit();
    }
    
    // SECURITY FIX: Cross-validate POST data with database cart
    $total_count = (int)$_POST['total_count'];
    if ($total_count != count($validated_cart)) {
        echo "<script>alert('Cart mismatch detected. Please try again.'); window.location.href='cart.php';</script>";
        exit();
    }
    
    // SECURITY FIX: Validate each product ID from POST matches cart
    for ($i = 1; $i <= $total_count; $i++) {
        if (!isset($_POST['prod_id_'.$i])) {
            echo "<script>alert('Invalid order data.'); window.location.href='cart.php';</script>";
            exit();
        }
        
        $post_product_id = (int)$_POST['prod_id_'.$i];
        $found = false;
        
        foreach ($validated_cart as $cart_item) {
            if ($cart_item['product_id'] == $post_product_id) {
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            echo "<script>alert('Product mismatch detected. Please try again.'); window.location.href='cart.php';</script>";
            exit();
        }
    }
    
    // Get next order ID
    $sql0 = "SELECT MAX(order_id) AS max_val FROM `orders_info`";
    $runquery = mysqli_query($con, $sql0);
    if ($runquery && mysqli_num_rows($runquery) > 0) {
        $row = mysqli_fetch_array($runquery);
        $order_id = (int)$row["max_val"] + 1;
    } else {
        $order_id = 1;
    }
    
    // SECURITY FIX: Use prepared statement for order insertion
    $sql = "INSERT INTO `orders_info` 
			(`order_id`,`user_id`,`f_name`, `email`,`address`, 
			`city`, `state`, `zip`, `cardname`,`cardnumber`,`expdate`,`prod_count`,`total_amt`,`cvv`) 
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt_order = mysqli_prepare($con, $sql);
    if (!$stmt_order) {
        die("Error preparing order statement: " . mysqli_error($con));
    }
    
    $prod_count = count($validated_cart);
    $zip_int = (int)$zip;
    $cvv_int = (int)$cvv;
    $calculated_total_int = (int)round($calculated_total);
    mysqli_stmt_bind_param($stmt_order, "iisssssisssiii", 
        $order_id, $user_id, $f_name, $email, $address, 
        $city, $state, $zip_int, $cardname, $cardnumber, $expdate, 
        $prod_count, $calculated_total_int, $cvv_int);
    
    if (mysqli_stmt_execute($stmt_order)) {
        mysqli_stmt_close($stmt_order);
        
        // SECURITY FIX: Insert order products using validated data from database
        $sql1 = "INSERT INTO `order_products` 
                 (`order_pro_id`,`order_id`,`product_id`,`qty`,`amt`) 
                 VALUES (NULL, ?, ?, ?, ?)";
        $stmt_order_product = mysqli_prepare($con, $sql1);
        
        if (!$stmt_order_product) {
            die("Error preparing order product statement: " . mysqli_error($con));
        }
        
        $all_products_inserted = true;
        
        foreach ($validated_cart as $cart_item) {
            $product_id = $cart_item['product_id'];
            $qty = $cart_item['qty'];
            $subtotal = (int)round($cart_item['subtotal']);
            
            mysqli_stmt_bind_param($stmt_order_product, "iiii", 
                $order_id, $product_id, $qty, $subtotal);
            
            if (!mysqli_stmt_execute($stmt_order_product)) {
                $all_products_inserted = false;
                break;
            }
        }
        
        mysqli_stmt_close($stmt_order_product);
        
        if ($all_products_inserted) {
            // Clear cart after successful order
            $del_sql = "DELETE FROM cart WHERE user_id = ?";
            $stmt_del = mysqli_prepare($con, $del_sql);
            if ($stmt_del) {
                mysqli_stmt_bind_param($stmt_del, "i", $user_id);
                mysqli_stmt_execute($stmt_del);
                mysqli_stmt_close($stmt_del);
            }
            
            echo "<script>window.location.href='order_successful.php'</script>";
        } else {
            echo "<script>alert('Error processing order. Please contact support.'); window.location.href='cart.php';</script>";
        }
    } else {
        mysqli_stmt_close($stmt_order);
        echo "<script>alert('Error creating order. Please try again.'); window.location.href='cart.php';</script>";
    }
    
} else {
    echo "<script>window.location.href='index.php'</script>";
}
	




?>