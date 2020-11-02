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

        <div class="col-md-12">
            <div id="modelMain" class="row">
                <div class="col-sm-6">
                    <div id="mainImage">
                        <img src="<?php echo $mod_imageurl; ?>" alt="model" class="img-responsive">

                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="box">

                    <?php add_cart(); ?>
                       <h1 class="text-center"> <?php echo $mod_name; ?> </h1> 

                        

                        <form action="details.php?add_cart=<?php echo $id; ?>" class="form-horizontal" method="post">

                            <div class="form-group">

                                <label for="" class="col-md-5 control-label">Models quantity</label>

                                <div class="col-md-7">

                                    <select name="model_qty" id="" class="form-control">

                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                        <option>6</option>
                                        <option>7</option>
                                        <option>8</option>

                                    </select>

                                </div>

                            </div>

                            <div class="form-group">
                                <label class="col-md-5 control-label">Model Size</label>

                                <div class="col-md-7">


                                    <select name="model_size" class="form-control" required oninput="setCustomValidity('')" oninvalid="alert('Must pick 1 size for the model')">
                                        <!--Customer needs to pick size of a model -->

                                        <option disabled selected>Select a Size</option>
                                        <option>Small</option>
                                        <option>Medium</option>
                                        <option>Large</option>
                                        <option>Extra large</option>

                                    </select>
                                     </div> </div> <p class="price">€ <?php echo $mod_price; ?></p>

                                        <p class="text-center buttons"><button class="btn btn-primary i fa fa-shopping-cart"> Add to cart</button></p>

                        </form>

                    </div>

                </div>


            </div>
        </div>


        <script src="js/jquery-331.min.js"></script>
        <script src="js/bootstrap-337.min.js"></script>


        </body>

        </html>