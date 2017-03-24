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

        <img src="images/frontImage2.jpg" alt="front intro img"/>

        <div class="flex-container-frontPage">
            <div class="flex-item-frontPage">
                <center><h1>Be Local, Support Local, Buy Local</h1></center>
            </div>
        </div>
        <div class="flex-container-frontPage">
            <div class="flex-item-frontPage">
                <p> Buy Local provides you with easy accessibilty to purchase locally produced products. You can quickly find out about different local producers, where your food is coming from and and guaranteeing you high quality local produce the way you want it.</p>
                <p> With Buy Local you can be assured that you are buying local ! </p>
            </div>
        </div>
        <br>
        <center>
            <h3> Top Pick</h3>
        </center>
        <div class="flex-container-frontPage">
            <div class="flex-item-product">
                <div class="productBox">
                <?php
                    try{   
                //Connecting to the database
                $conn = new PDO('mysql:host=localhost; dbname=ttbgqu_embl', 'ttbgqu_emweb', 'T9&O+m1uVD98');
                $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                //Using a prepared statement to select all the products in the products table
                $insertProducts = $conn->prepare("SELECT * FROM products WHERE pName = 'Vegetable Bundle - Large'");

                //Execute
                $insertProducts->execute();

                //fetches all the products from the database
                $products = $insertProducts->fetchAll(PDO::FETCH_ASSOC);
                
                //Loops through all the products and displays the image, name, price and ass to cart button
                for($i=0; $i < count($products); $i++){
                    $row = $products[$i];
                    echo "<center><b>".$row['pName']."</b><br><br>";
                    echo "<img src='./images/".$row['pImage'].".jpg' alt='product'/></br>";
                    echo "<b> Price: </b> €".$row['pPrice']." <b class='rate'> Rating: </b>";
                    
                    //Checks the rating and creates the stars deending on its rating
                    if($row['pRating'] == 5){
                        echo "<span class='rating five'>";
                        echo "<span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span class='scoredRating'>☆</span>";
                        echo "</span>";
                    }else if($row['pRating'] == 4){
                        echo "<span class='rating five'>";
                        echo "<span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span>☆</span>";
                        echo "</span>";
                    }else if($row['pRating'] == 3){
                        echo "<span class='rating five'>";
                        echo "<span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span>☆</span><span>☆</span>";
                        echo "</span>";
                    }else if($row['pRating'] == 2){
                        echo "<span class='rating five'>";
                        echo "<span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span>☆</span><span>☆</span><span>☆</span>";
                        echo "</span>";
                    }else if($row['pRating'] == 1){
                        echo "<span class='rating five'>";
                        echo "<span class='scoredRating'>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span>";
                        echo "</span>";
                    }
                    echo "<input class='btn ".$row['pId']."' type='submit' value='View Details'>";
                    echo "<form action='products.php' method='GET'>
                    <input type='hidden'  name='productId' value='".$row['pId']."'>
                    <input class='btn2 ".$row['pId']."' type='submit' value='Add To Cart'></form>";
                    echo "</center></div></div>";
                }
            
            }catch(PDOException $e){
                echo 'ERROR: '.$e -> getMessage();
            }
        /*
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
                        
                }
                catch(PDOException $e){
                    echo 'ERROR: ' . $e->getMessage();
                }
            }*/
                ?>
                
            </div>
        </div>

        <div class="flex-container-frontPage">
            <div class="flex-item-frontPage">
                <h3>Popular Picks </h3>
                
            </div>
        </div>
  <?php include "footer.php" ?>
</body>