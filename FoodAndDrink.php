<?php
    try{   
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
        for($i=0; $i < count($products); $i++){
            $row = $products[$i];
            echo " <div class='col-xs-6 col-md-4 productBox'>";
            echo "<b> Name: </b>".$row['pName']."</br>";
            echo "<img src='./images/".$row['pImage'].".jpg' alt='product'/></br>";
            echo "<b> Price: </b> €".$row['pPrice']." <b> Rating: </b> <div class='star-five'></div>";
            echo "<form action='products.php' method='GET'>
            <input type='hidden'  name='productId' value='".$row['pId']."'> </br>
            <input class='btn btn-default ".$row['pId']."' type='submit' value='Add To Cart'></form></br>";
            echo "</div>";
        }
    
    }catch(PDOException $e){
        echo 'ERROR: '.$e -> getMessage();
    }

    if(!empty($_GET['productId'])){

        //Gets the id stored with each product
        $productSelectedId = $_GET["productId"];
        
        try{
            //Connects to database
            $conn = new PDO('mysql:host=localhost; dbname=fyp', 'root', '');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);                    
            
            //Using a prepared statement to select the product that matches the id that is attached to the 
            $stat = $conn->prepare('SELECT * FROM products WHERE pid = :id');
            $stat->bindParam(':id', $productSelectedId);
            $stat->execute();

            //Pushes the selected product into the session
            array_push($_SESSION['productCartList'],$productSelectedId);                   
        }
        catch(PDOException $e){
            echo 'ERROR: ' . $e->getMessage();
        }
    }
?>