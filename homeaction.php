<?php
session_start();
$ip_add = getenv("REMOTE_ADDR");
include "db.php";

if(isset($_POST["categoryhome"])){
	
	echo "
		
				<!-- responsive-nav -->
				<div id='responsive-nav'>
					<!-- NAV -->
					<ul class='main-nav nav navbar-nav'>
						<li class='active'><a href='index.php'>Home</a></li>";
						$category_query = "SELECT * FROM categories";
						$run_query = mysqli_query($con,$category_query) or die(mysqli_error($con));
						if(mysqli_num_rows($run_query) > 0){
							while($row = mysqli_fetch_array($run_query)){
								
								$cid = $row["cat_id"];
								$cat_name = $row["cat_title"];

								echo"<li><a href='products.php?cat_id=".$cid."'>$cat_name</a></li>";
							}
						}

						// <li><a href='electronics.php'>Electronics</a></li>
						// <li><a href='ladies_wears.php'>Ladies Wears</a></li>
						// <li><a href='mens_wear.php'>Mens Wear</a></li>
						// <li><a href='kids_wear.php'>Kids Wear</a></li>
						// <li><a href='furnitures.php'>Furnitures</a></li>
						// <li><a href='home_appliances.php'>Home Appliances</a></li>
						// <li><a href='electronics_gadgets.php'>Electronics Gadgets</a></li>
                    
				 echo"</ul>
					<!-- /NAV -->
				</div>
				<!-- /responsive-nav -->
               
			";

}


if(isset($_POST["page"])){
	$sql = "SELECT * FROM products";
	$run_query = mysqli_query($con,$sql);
	$count = mysqli_num_rows($run_query);
	$pageno = ceil($count/2);
	for($i=1;$i<=$pageno;$i++){
		echo "
			<li><a href='#product-row' page='$i' id='page'>$i</a></li>
            
            
		";
	}
}
if(isset($_POST["getProducthome"])){
	$limit = 3;
	if(isset($_POST["setPage"])){
		$pageno = $_POST["pageNumber"];
		$start = ($pageno * $limit) - $limit;
	}else{
		$start = 0;
	}
	$product_query = "SELECT * FROM products,categories WHERE product_cat=cat_id LIMIT $start,$limit";
	$run_query = mysqli_query($con,$product_query);
	if(mysqli_num_rows($run_query) > 0){
		while($row = mysqli_fetch_array($run_query)){
			$pro_id    = $row['product_id'];
			$pro_cat   = $row['product_cat'];
			$pro_brand = $row['product_brand'];
			$pro_title = $row['product_title'];
			$pro_price = $row['product_price'];
			$pro_image = $row['product_image'];
            
            $cat_name = $row["cat_title"];
			echo "
				
                       <div class='product-widget'>
                                <a href='product.php?p=$pro_id'> 
									<div class='product-img'>
										<img src='product_images/$pro_image' alt=''>
									</div>
									<div class='product-body'>
										<p class='product-category'>$cat_name</p>
										<h3 class='product-name'><a href='product.php?p=$pro_id'>$pro_title</a></h3>
										<h4 class='product-price'>$pro_price<del class='product-old-price'>$990.00</del></h4>
									</div></a>
								</div>
                        
			";
		}
	}
}


if(isset($_POST["gethomeProduct"])){
	$limit = 9;
	if(isset($_POST["setPage"])){
		$pageno = $_POST["pageNumber"];
		$start = ($pageno * $limit) - $limit;
	}else{
		$start = 0;
	}
    
	$product_query = "SELECT * FROM products,categories WHERE product_cat=cat_id AND product_id BETWEEN 71 AND 74";
	$run_query = mysqli_query($con,$product_query);
	if(mysqli_num_rows($run_query) > 0){
        
		while($row = mysqli_fetch_array($run_query)){
			$pro_id    = $row['product_id'];
			$pro_cat   = $row['product_cat'];
			$pro_brand = $row['product_brand'];
			$pro_title = $row['product_title'];
			$pro_price = $row['product_price'];
			$pro_image = $row['product_image'];
            
            $cat_name = $row["cat_title"];
            
			echo "
				
                        
                                <div class='col-md-3 col-xs-6'>
								<a href='product.php?p=$pro_id'><div class='product'>
									<div class='product-img'>
										<img src='product_images/$pro_image' style='max-height: 170px;' alt=''>
										<div class='product-label'>
											<span class='sale'>-30%</span>
											<span class='new'>NEW</span>
										</div>
									</div></a>
									<div class='product-body'>
										<p class='product-category'>$cat_name</p>
										<h3 class='product-name header-cart-item-name'><a href='product.php?p=$pro_id'>$pro_title</a></h3>
										<h4 class='product-price header-cart-item-info'>$pro_price<del class='product-old-price'>$990.00</del></h4>
										<div class='product-rating'>";
										$rating_query = "SELECT ROUND(AVG(rating),1) AS avg_rating  FROM reviews WHERE product_id='$pro_id '";
										$run_review_query = mysqli_query($con,$rating_query);
										$review_row = mysqli_fetch_array($run_review_query);
										
										if($review_row > 0){
											$avg_count=$review_row["avg_rating"];
												$i=1;
												while($i <= round($avg_count)){
													$i++;
													echo'
													<i class="fa fa-star"></i>';
												}
												$i=1;
												while($i <= 5-round($avg_count)){
													$i++;
													echo'
													<i class="fa fa-star-o empty"></i>';
												}
											
										}
										echo "</div>
										<div class='product-btns'>
											<button pid='$pro_id' id='wishlist' class='add-to-wishlist'><i class='fa fa-heart-o'></i><span class='tooltipp'>add to wishlist</span></button>
											<button class='add-to-compare'><i class='fa fa-exchange'></i><span class='tooltipp'>add to compare</span></button>
											<button class='quick-view'><i class='fa fa-eye'></i><span class='tooltipp'>quick view</span></button>
										</div>
									</div>
									<div class='add-to-cart'>
										<button pid='$pro_id' id='product' class='add-to-cart-btn block2-btn-towishlist' href='#'><i class='fa fa-shopping-cart'></i> add to cart</button>
									</div>
								</div>
                                </div>
							
                        
			";
		}
        ;
      
}
    
	}
    
