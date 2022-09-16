  <?php 
include("../../db.php");
 
  ?>

  <div class="row" style="padding-top: 10vh;">
      <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
          <div class="card card-stats">
              <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                      <i class="material-icons">content_copy</i>
                  </div>
                  <p class="card-category">Total users</p>
                  <h3 class="card-title">
                      <?php  $query = "SELECT user_id FROM user_info"; 
                                      $result = mysqli_query($con, $query); 
                                       if ($result) 
                        { 
                            // it return number of rows in the table. 
                            $row = mysqli_num_rows($result); 
                              
                            printf(" " . $row); 
                        
                            // close the result. 
                        }  ?>
                  </h3>
              </div>

          </div>
      </div>
      <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
          <div class="card card-stats">
              <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                      <i class="material-icons">store</i>
                  </div>
                  <p class="card-category">Total Catagories</p>
                  <h3 class="card-title"> <?php  $query = "SELECT cat_id FROM categories"; 
                                      $result = mysqli_query($con, $query); 
                                       if ($result) 
                    { 
                        // it return number of rows in the table. 
                        $row = mysqli_num_rows($result); 
                          
                        printf(" " . $row); 
                    
                        // close the result. 
                    } ?></h3>
              </div>

          </div>
      </div>
      <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
          <div class="card card-stats">
              <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                      <i class="material-icons">info_outline</i>
                  </div>
                  <p class="card-category">Total sellers</p>
                  <h3 class="card-title"><?php  $query = "SELECT user_id FROM user_info"; 
                                      $result = mysqli_query($con, $query); 
                                       if ($result) 
                    { 
                        // it return number of rows in the table. 
                        $row = mysqli_num_rows($result); 
                          
                        printf(" " . $row); 
                    
                        // close the result. 
                    } ?></h3>
              </div>

          </div>
      </div>
      <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
          <div class="card card-stats">
              <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                      <i class="fa fa-twitter"></i>
                  </div>
                  <p class="card-category">Total Orders</p>
                  <h3 class="card-title"><?php  $query = "SELECT order_id FROM orders_info"; 
                                      $result = mysqli_query($con, $query); 
                                       if ($result) 
                        { 
                            // it return number of rows in the table. 
                            $row = mysqli_num_rows($result); 
                              
                            printf(" " . $row); 
                        
                            // close the result. 
                        }  ?></h3>
              </div>

          </div>
      </div>
  </div>