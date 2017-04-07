<?php 
    //Start or restore session variables
    session_start();
    //Including the database connection file
    include_once "dbCon.php";
?>
<!DOCTYPE html>
    <head>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="styles.css"/>

        <meta charset="UTF-8">
        <meta name="description" content="Online eccomerce site of local producers in Ireland">
        <meta name="keywords" content="Local Producers,eccommerce,local,buy,online,shopping">
        <meta name="author" content="Eiren McLoughlin">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>

        <?php 
        //This code is set above all other php statements as I need to check if products are in the basket first and display 
        //the number otherwise it requires a full page refresh or changing of pages to update the basket item total
        if(!empty($_GET['productBasketId'])){
            //Gets the id stored with each product
            global $conn;
            $productSelectedId = $_GET["productBasketId"];
            
            try{  
                //Using a prepared statement to select the product that matches the id that is attached to the product
                $stat = $conn->prepare('SELECT * FROM products WHERE pId = :pId');
                $stat->bindParam(':pId', $productSelectedId);
                $stat->execute();

                //Pushes the selected product into the session
                array_push($_SESSION['productCartList'],$productSelectedId);        
            }
            catch(PDOException $e){
                echo 'ERROR: ' . $e->getMessage();
            }
        }
        ?>

        <?php include "header.php" ?>
        <div class="flex-container-prodDetailPage">
                <?php
                    //Global Variables
                    global $productCartList;
                    global $storePId;
                    global $uId;

                    //Checks if there is a session for the cart
                    if(isset($_SESSION["productCartList"])){
                        $productCartArr = $_SESSION["productCartList"];
                    }
                    else{
                        $_SESSION['productCartList'] = array();
                        $productCartArr = $_SESSION["productCartList"];
                    }

                    if(isset($_SESSION["userId"])){
                        $uId = $_SESSION["userId"];
                    }

                    $prodDisplayType = $_GET["prodType"];
                    $productViewId = $_GET["productViewId"];
                    $productSelectedId = $_GET["productSelected"];
                    
                    if(!empty($_GET['productFavId'])){
                        global $conn;
                        $prodId = $_GET["productFavId"];

                        //Inserts into the favourites if the user is logged in and they press the star button
                        if(isset($_SESSION["userId"])){
                            try{
                                $stmt = $conn -> prepare('INSERT INTO favourites VALUES (:fId, :uId, :pId)');
                                
                                $stmt->bindParam(':fId', $fId);
                                $stmt->bindParam(':uId', $uId);
                                $stmt->bindParam(':pId', $pId);

                                $fId = null;
                                //print_r($uId);
                                $uId = $uId;
                                $pId = $prodId;
                            
                                $stmt->execute();
                            }catch(PDOException $e){
                                echo 'ERROR: ' . $e->getMessage();
                            }
                        }
                    }

                    //If the user clicks on the favourite star (That has already been favourite as this line would 
                    //not execute if the user didnt already have the product as a favourite), it removes it from the favourites
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

                    //Checkes if the clicked add to basket or view product from the products page it will show the right product
                    if(!empty($_GET['productSelected'])){
                        try{

                            //Using a prepared statement to select the product that matches the id that is attached to the 
                            $stat = $conn->prepare('SELECT * FROM products WHERE pId = :pId');
                            $stat->bindParam(':pId', $productSelectedId);
                            $stat->execute();

                            //Pushes the selected product into the session
                            array_push($_SESSION['productCartList'],$productSelectedId);           
                        }
                        catch(PDOException $e){
                            echo 'ERROR: ' . $e->getMessage();
                        }  
                    }
                    
                    try{   
                        //Depending on whether the user is viewing the page by clciking to it or the page has refreshed for a reason such as
                        //adding to basket or adding/removing a favourite this makes sure the display the right product from the database
                        if(!empty($_GET['productToDisplay'])){
                            $productCurrentView = $_GET['productToDisplay'];
                            $insertProducts = $conn->prepare("SELECT * FROM products WHERE pId = '$productCurrentView'");
                        }else{
                            $insertProducts = $conn->prepare("SELECT * FROM products WHERE pId = '$productViewId' OR pId = '$storePId'");
                        
                        }
                        //Execute
                        $insertProducts->execute();

                        //fetches all the products from the database
                        $products = $insertProducts->fetchAll(PDO::FETCH_ASSOC);
                        
                        //Loops through all the products and displays the image, name, price and ass to cart button
                        for($i=0; $i < count($products); $i++){
                        
                            $row = $products[$i];
            
                            //Structure for the product
                            echo "<img src='./images/".$row['pImage'].".jpg' alt='productDetail'/>";
                            echo "<b><h2 id='alignHeaderDetail'>".$row['pName']."</h2></b>";
                            echo "<p>Produced By: ".$row['pProducer']."</p>";
                            echo "<p>Made in: ".$row['pOrigin']."</p>";
                            echo "<p id='desc'>".$row['pDesc']."</p>";
                            echo "<b> Price: </b> €".$row['pPrice']."<br> <b> Rating: </b>";
                            
                            //Checks the rating and creates the stars depending on its rating it shows the relevant stars
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
                            
                            echo "<br><br>";
                            echo "<form action='productDetail.php' method='GET' class='formBtn2'>";
                            echo "<input type='hidden'  name='productDisplayed' value='".$row['pType']."'>";

                            $currentPId = $row['pId'];

                            if(isset($_SESSION["userId"])){
                                //Variables for if the user is logged in
                                global $conn;
                                $checkFavStatus;
                                $itAFav;
                                $favStatus;
                               
                               try{
                                   //Selects the favourite where the user id matches the one logged in
                                   //and the product id that is the current product selected
                                    $checkFavStatus = $conn->prepare("SELECT fId FROM favourites WHERE uId = '$uId' AND pId = '$currentPId'");
                                    $checkFavStatus->execute();
                                    $favStatus = $checkFavStatus->fetch(PDO::FETCH_ASSOC);
                                }catch(PDOException $e){
                                    echo 'ERROR: ' . $e->getMessage();
                                }

                                //Sets the product a variable depending on whether the user logged in has the product favourited or not
                                if(!empty($favStatus['fId'])){
                                    $itAFav = 1;
                                }else{
                                    $itAFav = 0;
                                }
 
                               if($itAFav == 0){
                                   //If product is not a favourite
                                    echo "<input type='hidden'  name='productFavId' value='".$row['pId']."'>";
                                    echo "<input type='hidden'  name='productSelectFavId' value='".$row['pId']."'>";
                                    echo "<input type='hidden'  name='productToDisplay' value='".$row['pId']."'>";
                                    echo "<button class='favStar'>&#x2606;</button></form>";
                               }

                               if($itAFav == 1){
                                   //If product is a favourite
                                    echo "<input type='hidden'  name='productSelectFavId' value='".$row['pId']."'>";
                                    echo "<input type='hidden'  name='productToDisplay' value='".$row['pId']."'>";
                                    echo "<button class='favStar'>&#x2605;</button></form>";
                               }
                            }else{
                                //If user is not logged in
                                echo "<input type='hidden'  name='productSelectFavId' value='".$row['pId']."'>";
                                echo "<input type='hidden'  name='productToDisplay' value='".$row['pId']."'>";
                                echo '<button class="favStar">&#x2606;</button></form>';
                            }       

                            //Button code for adding to basket
                            echo "<form action='productDetail.php' method='GET' class='formBtn2'>
                            <input type='hidden'  name='productBasketId' value='".$row['pId']."'>
                            <input type='hidden'  name='productToDisplay' value='".$row['pId']."'>
                            <input id='addCart' class='btn2 ".$row['pId']."' type='submit' value='Add To Basket'></form>";
                            echo "</div>";
                        }
                    
                    }catch(PDOException $e){
                        echo 'ERROR: '.$e -> getMessage();
                    }
            ?>
        </div>
        <br>
        <br>
        <br>
        <?php include "footer.php" ?>
    </body>
</html>