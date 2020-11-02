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
	
if(isset($_SESSION["user_name"])){
    $username=$_SESSION["user_name"];
    include('dbConnect.php');
    $sql = "SELECT * FROM `account` WHERE `email` = '$username'";
    $check = $connect->query($sql);
    if($check->num_rows == 1 ) {
        while($row = $check->fetch_assoc()) {
            $firstName = $row['fname'];
            $lastName=$row['lname'];
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Succeeded</title>
    <!-- Latest compiled and minified bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome. -->
    <script src="https://kit.fontawesome.com/1a97578772.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="container border border-info rounded-lg shadow-lg p-4 mb-4 bg-white">
    <h1 class="fas fa-check-double fa-10x"></h1>
    <h2>Your order has been recieved and your item will be shipped soon.</h2>
    <p>Thank you for shopping with us <?php echo $firstName . " " . $lastName?>.</p>
    <p>The delivery information will be sent to your email in a minute.</p>
</div>
</body>
</html>
