 <?php
    //Starts/Resumes sessions
    session_start();
?>
 <!DOCTYPE html>
    <head>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="styles.css"/>

        <meta charset="UTF-8">
        <meta name="description" content="Online eccomerce site of local producers">
        <meta name="keywords" content="Local Producers,eccommerce,local,buy,online,shopping">
        <meta name="author" content="Eiren McLoughlin">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php include "header.php" ?>
        <br>
        <?php include "filter.php" ?>
        
        <div class="flex-container-prodPage">
            <div class="flex-item-product">
                <?php

                    if(!empty($_POST['searchTerm'])){
                        $term = $_POST['searchTerm'];   
                         $term = strtolower($term);

                    try{
                        $conn = new PDO();
                        $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                       

                        if($term == 'meat' || $term == 'fish' || $term == 'poultry' || $term == 'chicken'){
                            $searchProducts = $conn->prepare("SELECT * FROM products WHERE pType='MPF'");
                        }else if($term == 'fruit' || $term == 'veg' || $term == 'vegetable'){
                            $searchProducts = $conn->prepare("SELECT * FROM products WHERE pType='FV'");
                        }else  if($term == 'juice' || $term == 'drink'){
                            $searchProducts = $conn->prepare("SELECT * FROM products WHERE pType='D'");
                        }else if($term == 'box' || $term == 'bundle' || $term == 'package' || $term == 'group' || $term == 'deal' || $term == 'offer' || $term == 'saving'){
                            $searchProducts = $conn->prepare("SELECT * FROM products WHERE pType='BD'");
                        }else if($term == 'dairy' || $term == 'calcium'){
                            $searchProducts = $conn->prepare("SELECT * FROM products WHERE pType='DE'");
                        }else if($term == 'baked' || $term == 'bake' || $term == 'bakery' || $term == 'Home' || $term == 'made' || $term == 'homemade' || $term == 'sugary' || $term == 'desert' || $term == 'dessert'){
                            $searchProducts = $conn->prepare("SELECT * FROM products WHERE pType='BK'");
                        }else{
                            //Using a prepared statement to select all the products in the products table
                            $searchProducts = $conn->prepare("SELECT * FROM products WHERE pName LIKE '%{$term}%' OR '{$term}%' OR '%{$term}'");
                        }
                        //Execute
                        $searchProducts->execute();

                        //fetches all the products from the database
                        $products = $searchProducts->fetchAll(PDO::FETCH_ASSOC);

                        echo "<h3> Search results for: $term </h3> <br>";        
                         //Loops through all the products and displays the image, name, price and ass to cart button
                        for($i=0; $i < count($products); $i++){
                            echo "<div class='productBox'>";
                            $row = $products[$i];
                            echo "<center><b>".$row['pName']."</b><br>";
                            echo "<img src='./images/".$row['pImage'].".jpg' alt='product'/></br>";
                            echo "</center>";
                            echo "<b class='alignPrice'> Price: </b> €".$row['pPrice']." <b class='rate'> Rating: </b>";
                            
                            //Checks the rating and creates the stars depending on its rating
                            if($row['pRating'] == 5){
                                echo "<span class='rating five'>";
                                echo "<span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span class='scoredRating'>☆</span>";
                                echo "</span>";
                            }
                            if($row['pRating'] == 4){
                                echo "<span class='rating five'>";
                                echo "<span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span class='scoredRating'>☆</span>";
                                echo "</span>";
                            }
                            if($row['pRating'] == 3){
                                echo "<span class='rating five'>";
                                echo "<span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span class='scoredRating'>☆</span>";
                                echo "</span>";
                            }
                            if($row['pRating'] == 2){
                                echo "<span class='rating five'>";
                                echo "<span class='scoredRating'>☆</span><span class='scoredRating'>☆</span>";
                                echo "</span>";
                            }
                            if($row['pRating'] == 1){
                                echo "<span class='rating five'>";
                                echo "<span class='scoredRating'>☆</span>";
                                echo "</span>";
                            }
                            echo "<input class='btn ".$row['pId']."' type='submit' value='View Details'>";
                            echo "<form action='products.php' method='GET'>
                            <input type='hidden'  name='productId' value='".$row['pId']."'>
                            <input class='btn2 ".$row['pId']."' type='submit' value='Add To Cart'></form>";
                            echo "</div>";
                        }
                    }catch(PDOException $e){
                        echo 'ERROR: '.$e -> getMessage();
                    }
                 }else{
                     echo "Too bad, next time try to type something into the search";
                 }

            ?>
                
            </div>
        </div>



 <?php

    
?>