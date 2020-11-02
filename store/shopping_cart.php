<?php
ob_start();
include("header.php");
if((isset($_SESSION["user_name"])) && (isset($_SESSION["password"]))){
       	
		if(time()-$_SESSION["last-update"] >1200){	 //session time
			session_unset(); 
			session_destroy(); 	
			header('Location: mainpage.php');
		}
		else{
			$_SESSION["last-update"]=time();
		}
	}else{
            header('Location: mainpage.php');	
	}
	
    
ob_end_flush();
?>
   
   <div id="content">
       <div class="container">
       
            <div id="cart" class="col-md-10">
               
               <div class="box">
                   
                   <form action="shopping_cart.php" method="post" enctype="multipart/form-data"><!-- Form begins -->
                       
                       <h1>Shopping Cart</h1>
                       
                       <?php 
                       
                       $ip_add = getIp();
                       
                       $select_cart = "SELECT * from shopping_cart where ip_add='$ip_add'";
                       
                       $run_cart = mysqli_query($con,$select_cart);
                       
                       $count = mysqli_num_rows($run_cart);
                       
                       ?>
                       
                       <p class="text-muted">You currently have <?php echo $count; ?> article(s) in your cart.</p>
                       
                       <div class="table-responsive">
                           
                           <table class="table"><!-- Table begins -->
                               
                               <thead>
                                   
                                   <tr>
                                       
                                       <th colspan="2">Model</th>
                                       <th>Quantity</th>
                                       <th>Unit Price</th>
                                       <th>Size</th>
                                       <th colspan="1">Delete</th>
                                       <th colspan="2">Sub-Total</th>
                                       
                                   </tr>
                                   
                               </thead>
                               
                               <tbody> <!-- Data in the table is from database -  table shopping_cart-->
                                  
                                  <?php 
									if((isset($_SESSION["user_name"])) && (isset($_SESSION["password"]))){
                                   $total = 0;
                                   
                                   while($row_cart = mysqli_fetch_array($run_cart)){
                                       
                                     $mod_id = $row_cart['m_id'];
                                       
                                     $mod_size = $row_cart['size'];
                                       
                                     $mod_qty = $row_cart['qty'];
                                       
                                       $get_models = "SELECT * from model where id='$mod_id'";
                                       
                                       $run_models = mysqli_query($con,$get_models);
                                       
                                       while($row_models = mysqli_fetch_array($run_models)){
                                           
                                           $modelname = $row_models['modelname'];
                                           
                                           $imageurl = $row_models['imageurl'];
                                           
                                           $only_price = $row_models['price'];
                                           
                                           $sub_total = $row_models['price']*$mod_qty; //Calculating price of a row for one model
                                           
                                           $total += $sub_total; //Calculating total price
									   }
                                   ?>
                                   
                                   <tr>
                                       
                                       <td>
                                           
                                           <img class="img-responsive" src="<?php echo $imageurl; ?>" alt="Article">
                                           
                                       </td>
                                       
                                       <td>
                                           
                                           <a href="details.php?mod_id=<?php echo $mod_id; ?>"> <?php echo $modelname; ?> </a>
                                           
                                       </td>
                                       
                                       <td>
                                          
                                           <?php echo $mod_qty; ?>
                                           
                                       </td>
                                       
                                       <td>
                                           
                                           <?php echo $only_price; ?>
                                           
                                       </td>
                                       
                                       <td>
                                           
                                           <?php echo $mod_size; ?>
                                           
                                       </td>
                                       
                                       <td>
                                           
                                           <input type="checkbox" name="remove[]" value="<?php echo $mod_id; ?>">
                                           
                                       </td>
                                       
                                       <td>
                                           
                                           €<?php echo $sub_total; ?>
                                           
                                       </td>
                                       
                                   </tr>
                                   
                                   <?php } } ?>
                                   
                               </tbody>
                               
                               <tfoot>
                                   
                                   <tr>
                                       
                                       <th colspan="5">Total</th>
                                       <th colspan="2">€<?php if((isset($_SESSION["user_name"])) && (isset($_SESSION["password"]))){echo $total;}else{echo "0";} ?></th>
                                       
                                   </tr>
                                   
                               </tfoot>
                               
                           </table>
                           
                       </div>
                       
                       <div class="box-footer">
                           
                           <div class="pull-left">
                               
                               <a href="mainpage.php" class="btn btn-default"><!-- If customer wants to continue with shopping, they are sent to mainpage again. -->
                                   
                                   <i class="fa fa-chevron-left"></i> Continue Shopping
                                   
                               </a>
                               
                           </div>
                           
                           <div class="pull-right">
                               
                               <button type="submit" name="update" value="Update Cart" class="btn btn-default">
                                   
                                   <i class="fa fa-refresh"></i> Update Cart <!--If customer change their mind and wants to delete some model(s), page is refreshed with changed data -->
                                   
                               </button>
                               
                               <a href="checkout.php" class="btn btn-primary"><!--If customer wants to finish their purchase, they are sent to checkout page -->
                                   
                                   Proceed Checkout <i class="fa fa-chevron-right"></i>
                                   
                               </a>
                               
                           </div>
                           
                       </div>
                       
                   </form>
                   
               </div>
               
               <?php 
               
                function update_cart(){ //If customer wants to delete some model from shopping cart, this function does that
                    
                    global $con;
                    
                    if(isset($_POST['update'])){
                        
                        foreach($_POST['remove'] as $remove_id){
                            
                            $delete_model = "DELETE FROM shopping_cart WHERE m_id='$remove_id'";
                            
                            $run_delete = mysqli_query($con,$delete_model);
                            
                            if($run_delete){
                                
                                echo "<script>window.open('shopping_cart.php','_self')</script>";
                                
                            }
                            
                        }
                        
                    }
                    
                }
               
               echo @$up_cart = update_cart();
               
               ?>
               
               
               
           </div>
           
       </div>
   </div>
   
    
    <script src="js/jquery-331.min.js"></script>
    <script src="js/bootstrap-337.min.js"></script>
    
    
</body>
</html>