<?php 
   session_start();
   include_once "dbCon.php";
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


                    try{   
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
                            echo "<form action='productDetail.php' method='GET'>
                            <input type='hidden'  name='productViewId' value='".$row['pId']."'>
                            <input class='btn ".$row['pId']."' type='submit' value='View Product'></form>";
                            
                            echo "<form action='index.php' method='GET'>";
                            echo "<input type='hidden'  name='productDisplayed' value='".$row['pType']."'>";
                           
                            $currentPId = $row['pId'];

                            if(isset($_SESSION["userId"])){
                                global $conn;
                                $checkFavStatus;
                                $itAFav;
                                $favStatus;

                            /*  echo "uId value:";
                                var_dump($uId);
                                echo "CurrentId value:";
                                var_dump($currentPId);*/
                               
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
                                    echo "<button>&#x2606;</button>";
                               }

                               if($itAFav == 1){
                                    echo "<input type='hidden'  name='productSelectFavId' value='".$row['pId']."'>";
                                    echo "<button>&#x2605;</button>";
                               }
                            }else{
                                echo "<button>&#x2606;</button>";
                            }
                            
                            echo "<input class='btn2 ".$row['pId']."' type='submit' value='Add To Favourties'></form>";           

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

                    if(!empty($_GET['productFavId'])){
                        global $conn;
                       // print_r($userLoggedInId);
                        $prodId = $_GET["productFavId"];
                         print_r($uId);
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

                    if(!empty($_GET['productSelectFavId'])){
                        global $conn;
                        $prodSelectId = $_GET["productSelectFavId"];
                        
                        try{
                            $stmt = $conn -> prepare("DELETE * FROM favourites WHERE uId = '$uId' AND pId = '$currentPId'");
                            
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
               
                    if(!empty($_GET['productBasketId'])){
                        //Gets the id stored with each product
                        $productSelectedId = $_GET["productBasketId"];
                        
                        try{  
                            //Using a prepared statement to select the product that matches the id that is attached to the 
                            $stat = $conn->prepare('SELECT * FROM products WHERE pId = :pId');
                            $stat->bindParam(':pId', $productSelectedId);
                            $stat->execute();

                            echo "Hello World";
                            //Pushes the selected product into the session
                            array_push($_SESSION['productCartList'],$productSelectedId);
                            print_r($_SESSION['productCartList']);           
                        }
                        catch(PDOException $e){
                            echo 'ERROR: ' . $e->getMessage();
                        }
                    }        
                ?>
                </div>
            </div>
        </div>

        <br>
        <br>

        <div class="flex-container-frontPage">
            <div class="flex-item-productPop">
                <h3>Popular Picks </h3>
                
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

                    try{   
                        //Using a prepared statement to select all the products in the products table
                        $insertProducts = $conn->prepare("SELECT * FROM products LIMIT 4");

                        //Execute
                        $insertProducts->execute();

                        //fetches all the products from the database
                        $products = $insertProducts->fetchAll(PDO::FETCH_ASSOC);
                        
                        //Loops through all the products and displays the image, name, price and ass to cart button
                        for($i=0; $i < count($products); $i++){
                            echo "<div class='productBoxPop'>";
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
                            echo "<form action='productDetail.php' method='GET'>
                            <input type='hidden'  name='productViewId' value='".$row['pId']."'>
                            <input class='btn ".$row['pId']."' type='submit' value='View Product'></form>";
                            
                            echo "<form action='index.php' method='GET'>";
                            echo "<input type='hidden'  name='productDisplayed' value='".$row['pType']."'>";
                           
                            $currentPId = $row['pId'];

                            if(isset($_SESSION["userId"])){
                                global $conn;
                                $checkFavStatus;
                                $itAFav;
                                $favStatus;

                            /*  echo "uId value:";
                                var_dump($uId);
                                echo "CurrentId value:";
                                var_dump($currentPId);*/
                               
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
                                    echo "<button>&#x2606;</button>";
                               }

                               if($itAFav == 1){
                                    echo "<input type='hidden'  name='productSelectFavId' value='".$row['pId']."'>";
                                    echo "<button>&#x2605;</button>";
                               }
                            }else{
                                echo "<button>&#x2606;</button>";
                            }
                            
                            echo "<input class='btn2 ".$row['pId']."' type='submit' value='Add To Favourties'></form>";           

                            //Add an if statement to decide which fav button to show
                            echo "<form action='index.php' method='GET'>
                            <input type='hidden'  name='productPopBasketId' value='".$row['pId']."'>
                            <input type='hidden'  name='productDisplayed' value='".$row['pType']."'>
                            <input class='btn2 ".$row['pId']."' type='submit' value='Add To Cart'></form>";
                            echo "</div>";
                        }
                    }catch(PDOException $e){
                        echo 'ERROR: '.$e -> getMessage();
                    }

                    if(!empty($_GET['productFavId'])){
                        global $conn;
                       // print_r($userLoggedInId);
                        $prodId = $_GET["productFavId"];
                         print_r($uId);
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

                    if(!empty($_GET['productSelectFavId'])){
                        global $conn;
                       // print_r($userLoggedInId);
                        $prodSelectId = $_GET["productSelectFavId"];
                        
                        try{
                            $stmt = $conn -> prepare("DELETE * FROM favourites WHERE uId = '$uId' AND pId = '$currentPId'");
                            
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
               
                    if(!empty($_GET['productPopBasketId'])){
                        //Gets the id stored with each product
                        $productSelectedId = $_GET["productPopBasketId"];
                        
                        try{  
                            //Using a prepared statement to select the product that matches the id that is attached to the 
                            $stat = $conn->prepare('SELECT * FROM products WHERE pId = :pId');
                            $stat->bindParam(':pId', $productSelectedId);
                            $stat->execute();

                            echo "Hello World";
                            //Pushes the selected product into the session
                            array_push($_SESSION['productCartList'],$productSelectedId);
                            print_r($_SESSION['productCartList']);           
                        }
                        catch(PDOException $e){
                            echo 'ERROR: ' . $e->getMessage();
                        }
                    }
                ?>
            </div>
        </div>

        <br>

        <?php include "deliveryInfo.php" ?>
  <?php include "footer.php" ?>
</body>