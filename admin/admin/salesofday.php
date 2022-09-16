
    <?php
session_start();
include("./includes/db.php");

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

include "sidenav.php";
include "topheader.php";

?>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="col-md-14">
            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">sales / Page <?php echo $page;?> </h4>
              </div>
              <div class="card-body">
                <div class="table-responsive ps">
                  <table class="table table-hover tablesorter " id="">
                    <thead class=" text-primary">
                      <tr><th>order_id</th><th>Products</th><th>Contact | Email</th><th>Address</th><th>amount</th><th>Quantity</th>
                    </tr></thead>
                    <tbody>
                      <?php
                      $query = "SELECT * FROM orders_info";
                      $run = mysqli_query($con,$query);
                      if(mysqli_num_rows($run) > 0){


                       while($row = mysqli_fetch_array($run)){
                         $order_id = $row['order_id'];
                         $email = $row['email'];
                         $address = $row['address'];
                         $total_amount = $row['total_amt'];
                         $user_id = $row['user_id'];
                         $qty = $row['prod_count'];

                      ?>
                          <tr>
                            <td><?php echo $order_id ?></td>
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
                         </tr>
                         <?php } ?>
                        
                    </tbody>
                     <?php
                   }else {
                     echo "<center><h2>No users Available</h2><br><hr></center>";
                     }
                  ?>
                  </table>
                  
                <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
              </div>
            </div>
          </div>
          
        </div>
      </div>
      <?php
include "footer.php";
?>