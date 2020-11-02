<?php
session_start();
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
	else{
		header('Location: mainpage.php');
	}

?>
<!DOCTYPE html>
<html>
<head>
    <title>My Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">

    <!-- Local Stylesheet. -->
    <link rel="stylesheet" href="CSS/style.css">
    <!-- Latest compiled and minified bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Google Maps scripts. -->
    <script src="https://maps.googleapis.com/maps/api/js?libraries-places&key=AIzaSyDhoh0Ac_BMn1o0P_yhaglY8a71xevLjis&callback=createMap" async defer></script>
    <!-- Font Awesome. -->
    <script src="https://kit.fontawesome.com/1a97578772.js" crossorigin="anonymous"></script>


</head>
<body>
<div class="text-center"><img src="image/logo.png" alt="Logo"></div>
<div class="container">
    <div class="form-control bg-dark form-group">
        <div class="pull-right"><p class="text-center font-weight-bolder text-light">1. Delivery Options</p></div>
    </div>

    <div class="row mb-2 collapse show multi-collapse">
        <div class="col">
            <div class="row form-group">
                <div class="col deliveryoptions">
                    <input type="text" class="form-control" placeholder="First Name">
                </div>
                <div class="col deliveryoptions">
                    <input type="text" class="form-control" placeholder="Last Name">
                </div>
            </div>

            <div class="row form-group">
                <div class="col deliveryoptions zip">
                    <input type="text" class="form-control" placeholder="Zip Code.." id="zip" autocomplete="off"/>
                </div>
                <div class="col actions">
                    <input type="submit" class="btn btn-success btn-block" data-toggle="collapse" data-target="#find_locations" id="get_map" name="get_map" value="Find Places!" disabled="disabled">
                </div>
            </div>
        </div>
    </div>


        <div id="find_locations" class="col collapse multi-collapse">
            <div class="row mb-2">
                <div class="col">
                    <div class="row form-group">
                        <div class="col">
                            <div class="radio">
                                <p class="text-muted" id="deliverypointPostNord"></p>
                                <p class="text-muted" id="deliverypointBring"></p>
                            </div>
                        </div>
                        <div class="col">
                            <div id="map"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    <div class="form-control bg-dark form-group">
        <div class="pull-right"><p class="text-center font-weight-bolder text-light">2. Payment Method</p></div>
    </div>
    <div id="payment_method" class="col collapse multi-collapse">
        <div class="row mb-2">
            <p class="font-weight-bold">Invoice Address:</p>
        </div>

        <div class="row form-group">
            <div class="col dropdown">
                        <select class="form-control" required name="Title" id="Title">
                            <option value="Mr.">Mr.</option>
                            <option value="Mrs.">Mrs.</option>
                            <option value="Ms.">Ms.</option>
                        </select>
            </div>
            <div class="col">
                <input type="text" class="form-control" placeholder="Country: Sweden" disabled>
            </div>
        </div>

        <div class="row form-group">
            <div class="col paymentmethod">
                <input type="text" class="form-control" placeholder="First Name">
            </div>

            <div class="col paymentmethod">
                <input type="text" class="form-control" placeholder="Last Name">
            </div>
        </div>

        <div class="row form-group">
            <div class="col paymentmethod">
                <input type="text" class="form-control" placeholder="Address">
            </div>

            <div class="col">
                <input type="text" class="form-control" placeholder="Additional Address Information (appartment stairs etc.)">
            </div>
        </div>

        <div class="row form-group">
            <div class="col">
                <div class="paymentmethod">
                    <input type="text" value="<?php echo $_SESSION['user_name'];?>" class="form-control" name="email" placeholder="Email">
                </div>
                <div class="actions2">
                    <input type="submit" class="btn btn-success btn-block" data-toggle="collapse" data-target="#card_data" value="Enter Card Information" disabled="disabled">
                </div>
            </div>
        </div>
    </div>

    <div class="row collapse" id="card_data"> <!--collapse-->
        <div class="col mx-auto tab-content">
            <div id="credit-card" class="tab-pane fade show active pt-3">
                <div class="form-group">
                    <h6>Card Holder</h6>
                    <input type="text" name="username" placeholder="First and Last Name" required class="form-control ">
                </div>
                <div class="form-group">

                    <h6>Card number</h6>

                    <div class="input-group"> <input type="text" name="cardNumber" placeholder="Card Number" class="form-control " required>
                        <span class="input-group-text text-muted">
                            <i class="fab fa-cc-visa mr-2 ml-2"></i>
                            <i class="fab fa-cc-mastercard mr-2 ml-2"></i>
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <h6>Valid Thru</h6>
                            <div class="input-group">
                                <input type="text" name="" class="form-control" required placeholder="mm">
                                <input type="text" name="" class="form-control" required placeholder="yy">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group mb-4">
                            <h6>CVC</h6>
                            <input type="text" required class="form-control">
                        </div>
                    </div>
                </div>
                <form method="post" action="confirm.php">
                    <a href="confirm.php" type="button" class="btn btn-success btn-block"> Confirm! </a>
                </form>
            </div>
        </div>
    </div>

    <script src="js/adam.js"></script>

</body>
</html>
