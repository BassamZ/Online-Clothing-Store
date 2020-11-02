<?php 

$db = mysqli_connect("localhost","root","","storedb");



function getIp(){
    
    
            if( array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
                if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',')>0) {
                    $addr = explode(",",$_SERVER['HTTP_X_FORWARDED_FOR']);
                    return trim($addr[0]);
                } else {
                    return $_SERVER['HTTP_X_FORWARDED_FOR'];
                }
            }
            else {
                return $_SERVER['REMOTE_ADDR'];
            }
            
    
    
}


function add_cart(){ //For adding model to shopping cart
    
    global $db;
    
    if(isset($_GET['add_cart'])){
        
        $ip_add = getIp();
        
        $m_id = $_GET['add_cart'];
        
        $model_qty = $_POST['model_qty'];
        
        $model_size = $_POST['model_size'];
        
        
            $query = "INSERT INTO shopping_cart (m_id,ip_add,qty,size) VALUES ('$m_id','$ip_add','$model_qty','$model_size')";
            
            $run_query = mysqli_query($db,$query);
            
            echo "<script>window.open('details.php?mod_id=$m_id','_self')</script>";
            
	}
        
    
    
}


function items(){
    
    global $db;
    
    $ip_add = getIp();
    
    $get_items = "SELECT * from shopping_cart where ip_add='$ip_add'";
    
    $run_items = mysqli_query($db,$get_items);
    
    $count_items = mysqli_num_rows($run_items);
    
    echo $count_items;
    
}


function total_price(){
    
    global $db;
    
    $ip_add = getIp();
    
    $total = 0;
    
    $select_cart = "SELECT * from shopping_cart where ip_add='$ip_add'";
    
    $run_cart = mysqli_query($db,$select_cart);
    
    while($record=mysqli_fetch_array($run_cart)){
        
        $mod_id = $record['m_id'];
        
        $mod_qty = $record['qty'];
        
        $get_price = "SELECT * from model where id='$mod_id'";
        
        $run_price = mysqli_query($db,$get_price);
        
        while($row_price=mysqli_fetch_array($run_price)){
            
            $sub_total = $row_price['price']*$mod_qty;
            
            $total += $sub_total;
            
        }
        
    }
    
    echo "€" . $total;
    
}


?>