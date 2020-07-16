<?php

include("../db.php");
error_reporting(0);
if(isset($_GET['action']) && $_GET['action']!="" && $_GET['action']=='delete')
{
$order_id=$_GET['order_id'];

/*this is delet query*/
mysqli_query($con,"delete from orders where order_id='$order_id'")or die("delete query is incorrect...");
} 

///pagination
$page=$_GET['page'];

if($page=="" || $page=="1")
{
$page1=0;	
}
else
{
$page1=($page*10)-10;	
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
<script src="style/js/jquery.min.js"></script>
</head>
<body>
  <?php include("include/header.php");?>
   	<div class="container-fluid main-container">
	<?php include("include/side_bar.php");?>
    <div class="col-md-9 content" style="margin-left:10px">
    <div class="panel-heading" style="background-color:#c4e17f">
	<h1>Orders  / Page <?php echo $page;?> </h1></div><br>
<div class='table-responsive'>  
<div style="overflow-x:scroll;">
<table class="table  table-hover table-striped" style="font-size:18px">
<tr><th>Customer Name</th><th>Products</th><th>Contact | Email</th><th>Address</th><th>amount</th><th>quantity</th><th></th></tr>
<?php
                      $query = "SELECT * FROM orders_info";
                      $run = mysqli_query($con,$query);
                      if(mysqli_num_rows($run) > 0){

                       while($row = mysqli_fetch_array($run)){
                         $order_id = $row['order_id'];
                         $email = $row['email'];
                         $f_name = $row['f_name'];
                         $address = $row['address'];
                         $total_amount = $row['total_amt'];
                         $user_id = $row['user_id'];
                         $qty = $row['prod_count'];

                      ?>
                          <tr>
                            <td><?php 
                               echo $f_name;

                             ?></td>
                           <td> <?php
                            $query1 = "SELECT * FROM order_products where order_id = $order_id";
                            $run1 = mysqli_query($con,$query1); 
                              while($row1 = mysqli_fetch_array($run1)){
                               $product_id = $row1['product_id'];

                               $query2 = "SELECT * FROM products where product_id = $product_id";
                               $run2 = mysqli_query($con,$query2);

                               while($row2 = mysqli_fetch_array($run2)){
                               $product_title = $row2['product_title'];
                           ?>
                              <?php echo $product_title ?><br>
                            <?php }}?></td>
                            <td><?php echo $email ?></td>
                            <td><?php echo $address ?></td>
                            <td><?php echo $total_amount ?></td>
                            <td><?php echo $qty ?></td>
                            <td></td>
                         </tr>
                         <?php } ?>
                        
                     <?php
                   }else {
                     echo "<center><h2>No users Available</h2><br><hr></center>";
                     }
                  ?>
                  
</table>
</div></div>
<nav align="center"> 
<?php 
//counting paging

$paging=mysqli_query($con,"select product_id,product_image, product_title,product_price from products");
$count=mysqli_num_rows($paging);

$a=$count/5;
$a=ceil($a);
echo "<bt>";echo "<bt>";
for($b=1; $b<=$a;$b++)
{
?> 
<ul class="pagination " style="border:groove #666">
<li><a class="label-info" href="orders.php?page=<?php echo $b;?>"><?php echo $b." ";?></a></li></ul>
<?php	
}
?>
</nav>
</div></div>
<?php include("include/js.php");?>
</body>
</html>