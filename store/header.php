<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "storedb"); //Connecting to database

include("functions.php");

?>
<?php

if (isset($_GET['mod_id'])) { //Getting data about particular model in variables for easier use

    $id = $_GET['mod_id'];

    $get_model = "SELECT * FROM model WHERE id='$id'";

    $run_model = mysqli_query($con, $get_model);

    $row_model = mysqli_fetch_array($run_model);

    $mod_name = $row_model['modelname'];

    $mod_price = $row_model['price'];

    $mod_imageurl = $row_model['imageurl'];
}

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>

    <div id="top">

        <div class="container">

            <div class="col-md-6 offer">

                <a href="checkout.php" class="btn btn-success btn-sm">Go to the checkout</a>
                <a href="checkout.php"><?php if((isset($_SESSION["user_name"])) && (isset($_SESSION["password"]))){items();} ?> Article(s) In Your Cart | Total Price: <?php 
				if((isset($_SESSION["user_name"])) && (isset($_SESSION["password"]))){total_price();}else {echo "€0";} ?> </a>

            </div>

            <div class="col-md-6">

                <ul class="menu"> <!--Menu for navigating through pages -->
                    <li>
                        <a href="mainpage.php">Main page</a>
                    </li>
                    <li>
                        <a href="registerpage.php">Register</a>
                    </li>
                    <li>
                        <a href="loginpage.php">Login</a>
                    </li>
                    <li>
                        <a href="shopping_cart.php">Shopping Cart</a>
                    </li>
                    <li>
                        <a href="checkout.php">Checkout</a>
                    </li>
                    
					<?php if((isset($_SESSION["user_name"])) && (isset($_SESSION["password"]))){ 
				echo '<li>
				<a href="Logout.php">Logout</a>
				</li>';
			}?>
               
                </ul>

            </div>

        </div>

    </div>

    <div id="navbar" class="navbar navbar-default">

        <div class="container">

            <div class="navbar-header">
                
                    <a href="mainpage.php" class="navbar-brand home">

                        <img class="logo" src="image/logo.png" alt="Logo">
                
                </a>

                <button class="navbar-toggle" data-toggle="collapse" data-target="#navigation">

                    <span class="sr-only">Toggle Navigation</span>

                    <i class="fa fa-align-justify"></i>

                </button>

                <button class="navbar-toggle" data-toggle="collapse" data-target="#search">

                    <span class="sr-only">Toggle Search</span>

                    <i class="fa fa-search"></i>

                </button>

            </div>

            <div class="navbar-collapse collapse" id="navigation">


                <a href="shopping_cart.php" class="btn navbar-btn btn-primary right">

                    <i class="fa fa-shopping-cart"></i>

                    <span><?php if((isset($_SESSION["user_name"])) && (isset($_SESSION["password"]))){items();} ?> Articles In Your Cart</span>

                </a>

                <div class="navbar-collapse collapse right">
                    

                    <button class="btn btn-primary navbar-btn" type="button" data-toggle="collapse" data-target="#search">
                        

                        <span class="sr-only">Toggle Search</span>

                        <i class="fa fa-search"></i>

                    </button>

                </div>

                <div class="collapse clearfix" id="search">
                    

                    <form method="post" action="" class="navbar-form">
                        

                        <div class="input-group">
                            
                            <!--Text from searchbar -->
                            <input type="text" class="form-control" placeholder="Search" name="user_query" id="user_query" required>
                            <div class="col-mb-5" style="position:absolute; z-index:100; margin-top:3.5rem;">
                                <div class="list-group" id="show-item"></div>
                            </div>

                            <span class="input-group-btn">
                                

                                <button type="submit" name="search" value="Search" class="btn btn-primary">
                                    

                                    <i class="fa fa-search"></i>

                                </button>

                            </span>

                            <script>

                                $("#user_query").keyup(function(){
                                    var searchItem = $(this).val();

                                    console.log(searchItem);

                                    if(searchItem !== ''){
                                        $.ajax({
                                            url:'action.php',
                                            method:'post',
                                            data:{searchItem:searchItem},
                                            success:function(response){
                                                $("#show-item").html(response);
                                            }
                                        });
                                    }

                                    else{
                                        $("#show-item").html('');
                                    }
                                });
                                

                            </script>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>
</body>
</html>