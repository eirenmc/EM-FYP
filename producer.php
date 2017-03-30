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
        <br>
        <?php include "filter.php" ?>

        <div class="flex-container-prodPage">
            <div class="flex-item-product">
                <?php

                    if(isset($_SESSION["userId"])){
                        $uId = $_SESSION["userId"];
                    }


                    try{   
                        $insertProducers = $conn->prepare("SELECT * FROM producers");

                        //Execute
                        $insertProducers->execute();

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
                            echo "<form action='productDetail.php' method='GET'>
                            <input type='hidden'  name='productViewId' value='".$row['pId']."'>
                            <input class='btn ".$row['pId']."' type='submit' value='View Product'></form>";
                            
                            echo "<form action='products.php' method='GET'>";
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
                            echo "<form action='products.php' method='GET'>
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