<?php
ob_start();
include("header.php"); //adding top of the page and logo

if((isset($_SESSION["user_name"])) && (isset($_SESSION["password"]))){
       	
		if(time()-$_SESSION["last-update"] >1200){	 //session time
			session_unset(); 
			session_destroy(); 	
			header('Location: mainpage.php');
			
		}
		else{
			$_SESSION["last-update"]=time();
		}
	}
	ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online store</title>
    <link rel="stylesheet" href="CSS/bootstrap-337.min.css">
    <link rel="stylesheet" href="font-awsome/css/font-awesome.min.css">
    <link rel="stylesheet" href="CSS/style.css">
</head>

<body>

    
<!----------------------Slideshow -------------------------->
    <div class="container" id="slider">

        <div class="col-md-12">

            <div class="carousel slide" id="myCarousel" data-ride="carousel">

                <ol class="carousel-indicators">

                    <li class="active" data-target="#myCarousel" data-slide-to="0"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                    <li data-target="#myCarousel" data-slide-to="3"></li>

                </ol>

                <div class="carousel-inner">

                    <div class="item active">

                        <img src="image/slideShow/code.jpg" alt="Image 1">

                    </div>

                    <div class="item">

                        <img src="image/slideShow/cover.jpg" alt="Image 2">

                    </div>

                    <div class="item">

                        <img src="image/slideShow/cover3.jpg" alt="Image 3">

                    </div>

                    <div class="item">

                        <img src="image/slideShow/cover7.jpg" alt="Image 4">

                    </div>

                </div>

                <a href="#myCarousel" class="left carousel-control" data-slide="prev"> <!-- An arrow for the previous slide -->

                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>

                </a>

                <a href="#myCarousel" class="right carousel-control" data-slide="next"><!-- An arrow for the next slide -->
                    

                    <span class="glyphicon glyphicon-chevron-right"></span> 
                    <span class="sr-only">Next</span>

                </a>

            </div>

        </div>

    </div>
<!----------------------End of slideshow -------------------------->
    <div id="hot"> <!-- Box with text about newsest models-->
       
       <div class="box">
           
           <div class="container">
               
               <div class="col-md-12">
                   
                   <h2>
                       Our Newest models
                   </h2>
                   
               </div>
               
           </div>
           
       </div>
       
   </div>
   
   <div id="content" class="container">
       
       <div class="row">
           <?php $get_models = "SELECT * FROM model order by 1 DESC "; //Getting models from database and showing basic information about them
                             
                             $run_models = mysqli_query($con,$get_models);
                              
                             while($row_models=mysqli_fetch_array($run_models)){
                                 
                                 $mod_id = $row_models['id'];
         
                                 $mod_name = $row_models['modelname'];
 
                                 $mod_price = $row_models['price'];
 
                                 $mod_imageurl = $row_models['imageurl'];
                                 
                                 echo "
                                 
                                     <div class='col-md-4 col-sm-6 center-responsive'>
                                     
                                         <div class='model'>
                                         
                                             <a href='details.php?mod_id=$mod_id'>
                                             
                                                 <img class='img-responsive' src='$mod_imageurl'>
                                             
                                             </a>
                                             
                                             <div class='text'>
                                             
                                                 <h3>
                                                 
                                                     <a href='details.php?mod_id=$mod_id'> $mod_name </a>
                                                 
                                                 </h3>
                                             
                                                 <p class='price'>
 
                                                 €$mod_price
 
                                                 </p>
 
                                                 <p class='buttons'>
 
                                                     <a class='btn btn-default' href='details.php?mod_id=$mod_id'>
 
                                                         View Details
 
                                                     </a>
 
                                                     <a class='btn btn-primary' href='details.php?mod_id=$mod_id'>
 
                                                         <i class='fa fa-shopping-cart'></i> Add To Cart
 
                                                     </a>
 
                                                 </p>
                                             
                                             </div>
                                         
                                         </div>
                                     
                                     </div>
                                 
                                 ";
                                 
                         }
                         
                    ?>
                
                </div>
          
       </div>
       
   </div>
   
    <script src="js/jquery-331.min.js"></script>
    <script src="js/bootstrap-337.min.js"></script>


</body>

</html>