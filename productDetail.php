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
        <meta name="description" content="Online eccomerce site of local producers in Ireland">
        <meta name="keywords" content="Local Producers,eccommerce,local,buy,online,shopping">
        <meta name="author" content="Eiren McLoughlin">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>

        <?php include "header.php" ?>
        <div class="flex-container-prodPage">
            <div class="flex-item-product">
                <?php

                    global $productCartList;
                    global $storePId;

                    if(isset($_SESSION["productCartList"])){
                        $productCartArr = $_SESSION["productCartList"];
                    }
                    else{
                        $_SESSION['productCartList'] = array();
                        $productCartArr = $_SESSION["productCartList"];
                    }

                    $prodDisplayType = $_GET["prodType"];
                    $productViewId = $_GET["productViewId"];
                    $productSelectedId = $_GET["productSelected"];

                    echo "<br>Store p id is:";
                    print_r($storePId);
                          
                    try{   
                        $insertProducts = $conn->prepare("SELECT * FROM products WHERE pId = '$productViewId' OR pId = '$storePId'");
                       
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
                            
                            echo "<form action='productDetail.php' method='GET'>";
                            echo "<input type='hidden' name='productSelected' value='".$row['pId']."'>";
                            echo "<input type='submit' class='btn2' value='Add to basket'>";
                            echo "</form>";
                           // echo "<input class='btn2' type='submit' value='Add To Cart'></form>";
                            echo "</div>";
                            
                            echo "<br> Store p id take 2 is:";
                            print_r($storePId);
                            $storePId = $row['pId'];
                        }
                    
                    }catch(PDOException $e){
                        echo 'ERROR: '.$e -> getMessage();
                    }

                    if(!empty($_GET['productSelected'])){
                        try{

                            //Using a prepared statement to select the product that matches the id that is attached to the 
                            $stat = $conn->prepare('SELECT * FROM products WHERE pId = :pId');
                            $stat->bindParam(':pId', $productSelectedId);
                            $stat->execute();

                           // echo "Hello World";
                            //Pushes the selected product into the session
                            array_push($_SESSION['productCartList'],$productSelectedId);
                           // print_r($_SESSION['productCartList']);           
                        }
                        catch(PDOException $e){
                            echo 'ERROR: ' . $e->getMessage();
                        }  

                    }
            ?>
                
            </div>
        </div>