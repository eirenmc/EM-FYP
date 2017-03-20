 <?php
    //Connecting to the database
   

    if(!empty($_POST['searchTerm'])){
        $term = $_POST['searchTerm'];   

        try{
            $conn = new PDO('mysql:host=localhost; dbname=fyp', 'root', '');
            $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //Using a prepared statement to select all the products in the products table
            $searchProducts = $conn->prepare("SELECT * FROM products WHERE pName LIKE '%{$term}%' OR '{$term}%' OR '%{$term}'");

            //Execute
            $searchProducts->execute();

            //fetches all the products from the database
            $products2 = $searchProducts->fetchAll(PDO::FETCH_ASSOC);
            
            for($i=0; $i < count($products2); $i++){
                $row = $products2[$i];
                echo "<b>Name:</b>".$row['pName'];
                echo "<b> Price: </b> €".$row['pPrice']."<br><br>";
            }
        }catch(PDOException $e){
            echo 'ERROR: '.$e -> getMessage();
        }
    }
?>

<?php  
         /*   try{   
                //Connecting to the database
                $conn = new PDO('mysql:host=localhost; dbname=fyp', 'root', '');
                $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                //Using a prepared statement to select all the products in the products table
                $insertProducts = $conn->prepare("SELECT * FROM products");
                
                //Execute
                $insertProducts->execute();

                //fetches all the products from the database
                $products = $insertProducts->fetchAll(PDO::FETCH_ASSOC);
                
                //Loops through all the products and displays the image, name, price and ass to cart button
                for($i=0; $i < $products; $i++){
                    $row = $products[$i];
                    echo "<b>".$row['pName']."</b><br><br>";
                    echo "<b> Price: </b> €".$row['pPrice'];
                }
            }catch(PDOException $e){
                echo 'ERROR: '.$e -> getMessage();
            }
            */    
        ?>

