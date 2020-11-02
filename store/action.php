<?php
    
    include('dbConnect.php');

     if(isset($_POST['searchItem'])) {
         $searchText=$_POST['searchItem'];
         $query = "SELECT * FROM model WHERE `modelname` LIKE '%$searchText%' LIMIT 5";
         $result = mysqli_query($connect, $query);
         if(mysqli_num_rows($result) > 0){
             while($row = mysqli_fetch_assoc($result)) {
                echo "<a href='#' class='list-group-item list-group-action border-1'>".$row['modelname']."</a>";
             }
         }

        else {
        echo "<p class='list-group border-1'>Item doesnt exist</p>";
    }
    }
    
?>