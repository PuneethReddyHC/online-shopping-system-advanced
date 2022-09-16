<?php
include "db.php";

include "header.php";


                         
?>

<link href="css/myorders.css" rel="stylesheet"/>					
<section class="section main main-raised">       
	<div class="container-fluid ">
		<div class="wrap cf">
            <h1 class="projTitle">All Your Orders</h1>
            <div class="heading cf">
                <h1>My Orders</h1>
                <h1 style="margin-left:55%">qty</h1>
                <a href="store.php" class="continue">Continue Shopping</a>
            </div>
            <div class="cart">
                <ul class="cartWrap">
                <?php
                if (isset($_SESSION["uid"])) {
                    $sql="SELECT c.order_id,a.product_id,a.product_title,a.product_price,a.product_image,b.qty,b.amt,c.total_amt FROM products a,order_products b,orders_info c WHERE a.product_id=b.product_id AND c.user_id='$_SESSION[uid]' AND b.order_id=c.order_id ORDER BY `c`.`order_id` DESC";
                    $query = mysqli_query($con,$sql);
                    //display cart item in dropdown menu
                    
                    if (mysqli_num_rows($query) > 0) {
                        $prev_old = 0;
                        $prev_total = 0;
                        $i = 1;
                        $numRows = mysqli_num_rows($query);
                        while ($row=mysqli_fetch_array($query)) {
                            
                            $product_id = $row["product_id"];
                            $product_title = $row["product_title"];
                            $product_price = $row["product_price"];
                            $product_image = $row["product_image"];
                            $qty = $row["qty"];
                            $amt=$row["amt"];
                            $total_amt=$row["total_amt"];
                            $order_id=$row["order_id"];
                            
                            if ($prev_old==0 || $prev_old==$order_id){
                                $prev_old=$order_id;
                                $prev_total = $total_amt;
                                $i++;
                                echo '<li class="items even">
                                    <tr>
                                    <div class="infoWrap"> 
                                        <div class="cartSection">
                                        <img src="product_images/'.$product_image.'" alt="'.$product_title.'" class="itemImg" />
                                        <p class="itemNumber">#'.$product_id.'</p>
                                        <h3>'.$product_title.'</h3>
                                        
                                        <p> '.$qty.' x &#x20B9; '.$product_price.'</p>
                                        
                                        <p class="stockStatus"> Delivered</p>
                                        </div>  
                                    
                                        <div class="prodTotal cartSection"><p>'.$qty.'</p></div>
                                        <td>
                                        <div class="prodTotal cartSection">
                                        <p>&#x20B9; '.$product_price.'</p>
                                        </div>
                                        </td>
                                        <div class="cartSection removeWrap">
                                            <a href="#" class="remove">x</a>
                                        </div>
                                    </div>
                                    </tr>
                            </li>';
                            
                            
                            }else{
                                $prev_old=$order_id;
                                $i++;
                                echo'
                            </ul>
                        </div>  
                        <div class="special"><div class="specialContent">
                                Thanks for Using our Platform
                        </div></div>
                        <div class="subtotal cf">
                            <ul>
                            <li class="totalRow"><span class="label">Subtotal</span><span class="value">&#x20B9; '.$prev_total.'</span></li>
                            
                                <li class="totalRow"><span class="label">Shipping</span><span class="value">&#x20B9; 0.00</span></li>
                            
                                    <li class="totalRow"><span class="label">Tax</span><span class="value">&#x20B9; 0.00</span></li>
                                    <li class="totalRow final"><span class="label">Total</span><span class="value">&#x20B9;'.$prev_total.'</span></li>
                            
                            </ul>
                        </div>
            
                        
                        <div class="cart">
                            <ul class="cartWrap">
                                <li class="items even">
                                <tr>
                                    <div class="infoWrap"> 
                                        <div class="cartSection">
                                        <img src="product_images/'.$product_image.'" alt="'.$product_title.'" class="itemImg" />
                                        <p class="itemNumber">#'.$product_id.'</p>
                                        <h3>'.$product_title.'</h3>
                                        
                                        <p> '.$qty.' x &#x20B9; '.$product_price.'</p>
                                        
                                        <p class="stockStatus out"> Shipping</p>
                                        </div>  
                                    
                                        <div class="prodTotal cartSection"><p>'.$qty.'</p></div>
                                        <td>
                                        <div class="prodTotal cartSection">
                                        <p>&#x20B9; '.$product_price.'</p>
                                        </div>
                                        </td>
                                        <div class="cartSection removeWrap">
                                            <a href="#" class="remove">x</a>
                                        </div>
                                    </div>
                                    </tr>
                                </li>
                                ';
                                $prev_total = $total_amt;
                            }
                            if($i==$numRows+1){
                                echo '
                                 
                                    <div class="special"><div class="specialContent">
                                            Thanks for Using our Platform
                                    </div></div>
                                    <div class="subtotal cf">
                                        <ul>
                                        <li class="totalRow"><span class="label">Subtotal</span><span class="value">&#x20B9; '.$prev_total.'</span></li>
                                        
                                            <li class="totalRow"><span class="label">Shipping</span><span class="value">&#x20B9; 0.00</span></li>
                                        
                                                <li class="totalRow"><span class="label">Tax</span><span class="value">&#x20B9; 0.00</span></li>
                                                <li class="totalRow final"><span class="label">Total</span><span class="value">&#x20B9;'.$prev_total.'</span></li>
                                        
                                        </ul>
                                    </div>
                                ';
                            }
                            
                            
                        }
                    }else{
                    }
                }
                ?>
                
                
                </ul>
            </div> 
                <!--<li class="items even">Item 2</li>-->
            
                
        </div>
    </div>
 </section>

<?php
include "footer.php";
?>