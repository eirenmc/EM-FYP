<?php 
   session_start();
   include_once "dbCon.php";
?>
<!DOCTYPE html>
    <head>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="styles.css"/>

        <script src="./js/script.js"></script>

        <meta charset="UTF-8">
        <meta name="description" content="Online eccomerce site of local producers">
        <meta name="keywords" content="Local Producers,eccommerce,local,buy,online,shopping">
        <meta name="author" content="Eiren McLoughlin">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
<!-- Testing -->
        <?php 
            //This code is set above all other php statements as I need to check if products are in the basket first and display 
            //the number otherwise it requires a full page refresh or changing of pages to update the basket item total
            if(!empty($_GET['productBasketId'])){
                //Gets the id stored with each product
                global $conn;
                $productSelectedId = $_GET["productBasketId"];
                
                try{  
                    //Using a prepared statement to select the product that matches the id that is attached to the 
                    $stat = $conn->prepare('SELECT * FROM products WHERE pId = :pId');
                    $stat->bindParam(':pId', $productSelectedId);
                    $stat->execute();

                   // echo "Hello World";
                    //Pushes the selected product into the session
                    array_push($_SESSION['productCartList'],$productSelectedId);
                    //print_r($_SESSION['productCartList']);           
                }
                catch(PDOException $e){
                    echo 'ERROR: ' . $e->getMessage();
                }
            }

            //Checks if value recieved from the logout button
            if(!empty($_GET['logout'])){
                //if so it unsets the session so the user is no longer logged in
                unset($_SESSION['userId']);
                unset($_SESSION['uname']);
                //Message notifying the user they have logged out
                echo "<div id='logoutBox'>
                        <h3>You have successfully logged out</h3>
                    </div>";
            }
        ?>

        <?php include "header.php" ?>

        <img src="images/frontImage2.jpg" alt="front intro img"/>

        <div class="flex-container-frontPage">
            <div class="flex-item-frontPage">
                <center><h1>Be Local, Support Local, Buy Local</h1></center>
            </div>
        </div>
        <br>
        <br>
        <div class="flex-container-frontPage">
            <div class="flex-item-frontPage">
                <p>'BuyLocal is an ecommerce's and mobile networking platform for local consumers and local producers to support growth in the local economy</p>
                <p> Buy Local provides you with easy accessibilty to purchase locally produced products. You can quickly find out about different local producers, where your food is coming from and and guaranteeing you high quality local produce the way you want it.</p>
                <p> With Buy Local you can be assured that you are buying local ! </p>
            </div>
        </div>
        <br>
        <center>
        <h3>Popular Picks </h3>
        <div class="flex-container-frontPage">
            <div class="flex-item-productPop">
                <?php
                    global $productCartList;
                    global $uId;

                    if(isset($_SESSION["productCartList"])){
                        $productCartArr = $_SESSION["productCartList"];
                    }else{
                        $_SESSION['productCartList'] = array();
                        $productCartArr = $_SESSION["productCartList"];
                    }

                    if(isset($_SESSION["userId"])){
                        $uId = $_SESSION["userId"];
                    }

                    $prodDisplayType = $_GET["prodType"];
                    $productDisplayed = $_GET['productDisplayed'];

                    $_SESSION['productDisplayed'] = $prodDisplayType;

                    if(!empty($_GET['productFavId'])){
                        global $conn;
                        $prodId = $_GET["productFavId"];

                        if(isset($_SESSION["userId"])){
                            try{
                                $stmt = $conn -> prepare('INSERT INTO favourites VALUES (:fId, :uId, :pId)');
                                
                                $stmt->bindParam(':fId', $fId);
                                $stmt->bindParam(':uId', $uId);
                                $stmt->bindParam(':pId', $pId);

                                $fId = null;
                                print_r($uId);
                                $uId = $uId;
                                $pId = $prodId;
                            
                                $stmt->execute();
                            }catch(PDOException $e){
                                echo 'ERROR: ' . $e->getMessage();
                            }
                        }
                    }

                    if(!empty($_GET['productSelectFavId'])){
                        global $conn;
                        $prodSelectId = $_GET["productSelectFavId"];
                        
                        try{  
                            $stmt = $conn -> prepare("DELETE FROM favourites WHERE uId = '$uId' AND pId = '$prodSelectId'");                        
                            $stmt->execute();
                         }catch(PDOException $e){
                            echo 'ERROR: ' . $e->getMessage();
                        }
                    }

                    try{   
                        $insertProducts = $conn->prepare("SELECT * FROM products LIMIT 3");

                        //Execute
                        $insertProducts->execute();

                        //fetches all the products from the database
                        $products = $insertProducts->fetchAll(PDO::FETCH_ASSOC);
                        
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
                            echo "<form action='productDetail.php' method='GET' class='formBtn'>
                            <input type='hidden'  name='productViewId' value='".$row['pId']."'>
                            <input class='btn ".$row['pId']."' type='submit' value='View Product'></form>";
                            
                            echo "<form action='index.php' method='GET' class='formBtn2'>";
                            echo "<input type='hidden'  name='productDisplayed' value='".$row['pType']."'>";

                            $currentPId = $row['pId'];

                            if(isset($_SESSION["userId"])){
                                global $conn;
                                $checkFavStatus;
                                $itAFav;
                                $favStatus;
                               
                               try{
                                    $checkFavStatus = $conn->prepare("SELECT fId FROM favourites WHERE uId = '$uId' AND pId = '$currentPId'");
                                    $checkFavStatus->execute();
                                    $favStatus = $checkFavStatus->fetch(PDO::FETCH_ASSOC);
                                }catch(PDOException $e){
                                    echo 'ERROR: ' . $e->getMessage();
                                }

                                if(!empty($favStatus['fId'])){
                                    $itAFav = 1;
                                }else{
                                    $itAFav = 0;
                                }
 
                               if($itAFav == 0){
                                    echo "<input type='hidden'  name='productFavId' value='".$row['pId']."'>";
                                    echo "<button class='favStar'>&#x2606;</button></form>";
                               }

                               if($itAFav == 1){
                                    echo "<input type='hidden'  name='productSelectFavId' value='".$row['pId']."'>";
                                    echo "<button class='favStar'>&#x2605;</button></form>";
                               }
                            }else{
                                echo "<button class='favStar'>&#x2606;</button></form>";
                            }          

                            //Add an if statement to decide which fav button to show
                            echo "<form action='index.php' method='GET'>
                            <input type='hidden'  name='productBasketId' value='".$row['pId']."'>
                            <input type='hidden'  name='productDisplayed' value='".$row['pType']."'>
                            <input class='btn2 ".$row['pId']."' type='submit' value='Add To Cart'></form>";
                            echo "</div>";
                        }
                    }catch(PDOException $e){
                        echo 'ERROR: '.$e -> getMessage();
                    }
            ?>
        </div>
    </div>
    </center>
    <br>
    <?php include "deliveryInfo.php" ?>
    <?php include "footer.php" ?>
    <script>
        /* Javascript code to timeout the logout notification box */
        document.getElementById('logoutBox').style.display = 'block';
        setTimeout(function() {
            document.getElementById('logoutBox').style.display = 'none';
        },4000);
    </script>
</body>