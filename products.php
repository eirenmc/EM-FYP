<?php 
   session_start();
   include_once "dbCon.php";
?>

<!DOCTYPE html>
    <head>
        <script src="./js/script.js"></script>
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

                //echo "Hello World";
                //Pushes the selected product into the session
                array_push($_SESSION['productCartList'],$productSelectedId);
               // print_r($_SESSION['productCartList']);           
            }
            catch(PDOException $e){
                echo 'ERROR: ' . $e->getMessage();
            }
        }
        ?>

        <?php include "header.php" ?>
        
        <br>
        <!-- Filter Start -->
        <div class="flex-container-filter">
            <div class="flex-item">
                <form method="GET" action="products.php">
                <div class="titleBar">
                    <h2>Filter By :</h2>
                </div>
                  <!--  <div class="priceFilter">
                        <h3>Price</h3>
                        <button type="button" name="price" value="lh" class="buttonSort">Low - High</button>
                        <button type="button" name="price" value="hl" class="buttonSort">High - Low</button>
                    </div>
                    <hr>
                    <div class="sortFilter">
                        <h3>Sort</h3>
                        <button type="button" name="sortName" value="az" class="buttonSort2">A - Z</button>
                        <button type="button" name="sortName" value="za" class="buttonSort2">Z - A</button>
                    </div>
                <hr>-->
                <div class="ratingFilter">
                <h3>Rating</h3>
                <input type="radio" name="rating" value="1">
                <span class='rating five'>
                <span class='scoredRating'>☆</span>
                </span>
                <br>
                <input type="radio" name="rating" value="2">
                <span class='rating five'>
                    <span class='scoredRating'>☆</span><span class='scoredRating'>☆</span>
                </span>
                <br>
                <input type="radio" name="rating" value="3">
                <span class='rating five'>
                    <span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span class='scoredRating'>☆</span>
                </span>
                <br>
                <input type="radio" name="rating" value="4">
                <span class='rating five'>
                    <span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span class='scoredRating'>☆</span>
                </span>
                <br>
                <input type="radio" name="rating" value="5">
                <span class='rating five'>
                <span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span class='scoredRating'>☆</span>
                </span>
            </div>
            <hr>
            <div class="originFilter">
                <h3>Produced In:</h3>
                <p>(50 mile radius from each location in included)</p>
                    <span class="filterCheckbox">
                        <input type="radio" name="origin" value="Clonmel">Clonmel
                    </span>
                    <br>
                    <span class="filterCheckbox">
                        <input type="radio" name="origin" value="Thurles">Thurles
                    </span>
                    <br>
                    <span class="filterCheckbox">
                        <input type="radio" name="origin" value="Cahir">Cahir
                    </span>
                    <br>
                    <span class="filterCheckbox">
                        <input type="radio" name="origin" value="Carrick On Suir">Carrick On Suir
                    </span>
                    <br>
                    <span class="filterCheckbox">
                        <input type="radio" name="origin" value="Callan">Callan
                    </span>
                    <br>
                    <span class="filterCheckbox">
                        <input type="radio" name="origin" value="Mitchlestown">Mitchlestown
                    </span>
            </div>
            <hr>
            <div class="dietFilter">
            <h3>Dietary Requirements</h3>
                <span class="filterCheckbox">
                    <input type="radio" value="N" name="diet">Nut Free
                </span> 
                <br>
                <span class="filterCheckbox">
                    <input type="radio" value="O" name="diet">Organic
                </span>
                <br>         
                <span class="filterCheckbox">
                    <input type="radio" value="G" name="diet">Gluten Free
                </span>
                <br>
                <span class="filterCheckbox">
                    <input type="radio" value="L" name="diet">Lactose Intolerant
                </span>
                <?php
                    global $productType;
                    if(!empty($_GET["prodType"])){
                        $productType = $_GET["prodType"];
                    }else if(!empty($_GET["filterStoredType"])){
                        $productType = $_GET["filterStoredType"];
                    }
                    
                    $_SESSION['productType'] = $productType;
                    //echo $productType;
                    echo "<input type='hidden' name='filterStoredType' value='".$_SESSION['productType']."'>";
                ?>
                <br>
                <br>
                <input class='btn2' type='submit' value='Filter Products'>      
        </div>
        </form>
    </div>
</div>
        <div class="flex-container-prodPage">
            <div class="flex-item-product">
                <?php

                    global $productCartList;
                    global $uId;
                    global $typePage;
                    $type;

                   /* $page = $_SERVER["REQUEST_URI"];
                    $_SESSION['page'] = $page;
                    $typePage = "http://".$_SERVER['SERVER_NAME'].$_SESSION['page'];
                    //echo "http://".$_SERVER['SERVER_NAME'].$_SESSION['page'];*/

                    if(isset($_SESSION["productCartList"])){
                        $productCartArr = $_SESSION["productCartList"];
                    }else{
                        $_SESSION['productCartList'] = array();
                        $productCartArr = $_SESSION["productCartList"];
                    }

                    if(isset($_SESSION["userId"])){
                        $uId = $_SESSION["userId"];
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
                               // print_r($uId);
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

                    if(!empty($_GET['filterStoredType'])){
                        $type = $_GET['filterStoredType'];
                        //echo "Type chosen is : ".$type;
                    }
                    if(!empty($_GET['diet'])){
                        $diet = $_GET['diet'];
                        //echo "Diet chosen is : ".$diet;
                    }
                    if(!empty($_GET['origin'])){
                        $origin = $_GET['origin'];
                        //echo "origin chosen is : ".$origin;
                    }
                    if(!empty($_GET['rating'])){
                        $rating = $_GET['rating'];
                        //echo "rating chosen is : ".$rating;
                    }
                  /*  if(!empty($_GET['price'])){
                        $price = $_GET['price'];
                    }
                    if(!empty($_GET['sortName'])){
                        $sortName = $_GET['sortName'];
                    }*/
                    
                    try{   
                        if($prodDisplayType == 'FV' || $productDisplayed == 'FV' || $type == 'FV'){
                            if(!empty($_GET['filterStoredType'])){
                                /*
                                if((!empty($_GET['diet'])) && (!empty($_GET['origin'])) && (!empty($_GET['rating'])) && ($price == 'az')){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='FV' AND pDietType='$diet' AND pOrigin='$origin' AND pRating='$rating' ASC");
                                }else if((!empty($_GET['rating'])) && (!empty($_GET['origin'])) && ($price == 'az')){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='FV' AND pDietType='$diet' AND pRating='$rating' ASC");
                                }else if((!empty($_GET['diet'])) && (!empty($_GET['origin'])) && ($price == 'az')){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='FV' AND pDietType='$diet' AND pOrigin='$origin' ASC");
                                }else if((!empty($_GET['diet'])) && (!empty($_GET['rating'])) && ($price == 'az')){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='FV' AND pDietType='$diet' AND pRating='$rating' ASC");
                                }else if(!empty($_GET['diet']) && ($price == 'az')){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='FV' AND pDietType='$diet' ASC");
                                }else if(!empty($_GET['origin']) && ($price == 'az')){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='FV' AND pOrigin='$origin' ASC");
                                }else if(!empty($_GET['rating']) && ($price == 'az')){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='FV' AND pRating='$rating' ASC");
                                }else*/ 
                                if((!empty($_GET['diet'])) && (!empty($_GET['origin'])) && (!empty($_GET['rating']))){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='FV' AND pDietType='$diet' AND pOrigin='$origin' AND pRating='$rating'");
                                }else if((!empty($_GET['rating'])) && (!empty($_GET['origin']))){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='FV' AND pDietType='$diet' AND pRating='$rating'");
                                }else if((!empty($_GET['diet'])) && (!empty($_GET['origin']))){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='FV' AND pDietType='$diet' AND pOrigin='$origin'");
                                }else if((!empty($_GET['diet'])) && (!empty($_GET['rating']))){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='FV' AND pDietType='$diet' AND pRating='$rating'");
                                }else if(!empty($_GET['diet'])){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='FV' AND pDietType='$diet'");
                                }else if(!empty($_GET['origin'])){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='FV' AND pOrigin='$origin'");
                                }else if(!empty($_GET['rating'])){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='FV' AND pRating='$rating'");
                                }
                            }else{
                                $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='FV'");
                            }
                        }else if($prodDisplayType == 'MPF' || $productDisplayed == 'MPF' || $type == 'MPF'){

                            if(!empty($_GET['filterStoredType'])){
                                
                                if((!empty($_GET['diet'])) && (!empty($_GET['origin'])) && (!empty($_GET['rating']))){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='MPF' AND pDietType='$diet' AND pOrigin='$origin' AND pRating='$rating'");
                                }else if((!empty($_GET['rating'])) && (!empty($_GET['origin']))){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='MPF' AND pDietType='$diet' AND pRating='$rating'");
                                }else if((!empty($_GET['diet'])) && (!empty($_GET['origin']))){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='MPF' AND pDietType='$diet' AND pOrigin='$origin'");
                                }else if((!empty($_GET['diet'])) && (!empty($_GET['rating']))){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='MPF' AND pDietType='$diet' AND pRating='$rating'");
                                }else if(!empty($_GET['diet'])){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='MPF' AND pDietType='$diet'");
                                }else if(!empty($_GET['origin'])){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='MPF' AND pOrigin='$origin'");
                                }else if(!empty($_GET['rating'])){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='MPF' AND pRating='$rating'");
                                }
                            }else{
                                $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='MPF'");
                            }

                        }else if($prodDisplayType == 'BK' || $productDisplayed == 'BK' || $type == 'BK'){
                            
                            if(!empty($_GET['filterStoredType'])){
                                
                                if((!empty($_GET['diet'])) && (!empty($_GET['origin'])) && (!empty($_GET['rating']))){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='BK' AND pDietType='$diet' AND pOrigin='$origin' AND pRating='$rating'");
                                }else if((!empty($_GET['rating'])) && (!empty($_GET['origin']))){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='BK' AND pDietType='$diet' AND pRating='$rating'");
                                }else if((!empty($_GET['diet'])) && (!empty($_GET['origin']))){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='BK' AND pDietType='$diet' AND pOrigin='$origin'");
                                }else if((!empty($_GET['diet'])) && (!empty($_GET['rating']))){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='BK' AND pDietType='$diet' AND pRating='$rating'");
                                }else if(!empty($_GET['diet'])){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='BK' AND pDietType='$diet'");
                                }else if(!empty($_GET['origin'])){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='BK' AND pOrigin='$origin'");
                                }else if(!empty($_GET['rating'])){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='BK' AND pRating='$rating'");
                                }

                            }else{
                                $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='BK'");
                            }
                        }else if($prodDisplayType == 'D' || $productDisplayed == 'D' || $type == 'D'){
                            if(!empty($_GET['filterStoredType'])){
                                
                                if((!empty($_GET['diet'])) && (!empty($_GET['origin'])) && (!empty($_GET['rating']))){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='D' AND pDietType='$diet' AND pOrigin='$origin' AND pRating='$rating'");
                                }else if((!empty($_GET['rating'])) && (!empty($_GET['origin']))){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='D' AND pDietType='$diet' AND pRating='$rating'");
                                }else if((!empty($_GET['diet'])) && (!empty($_GET['origin']))){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='D' AND pDietType='$diet' AND pOrigin='$origin'");
                                }else if((!empty($_GET['diet'])) && (!empty($_GET['rating']))){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='D' AND pDietType='$diet' AND pRating='$rating'");
                                }else if(!empty($_GET['diet'])){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='D' AND pDietType='$diet'");
                                }else if(!empty($_GET['origin'])){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='D' AND pOrigin='$origin'");
                                }else if(!empty($_GET['rating'])){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='D' AND pRating='$rating'");
                                }

                            }else{
                                $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='D'");
                            }
                        }else if($prodDisplayType == 'BD' || $productDisplayed == 'BD' || $type == 'BD'){
                            if(!empty($_GET['filterStoredType'])){
                                
                                if((!empty($_GET['diet'])) && (!empty($_GET['origin'])) && (!empty($_GET['rating']))){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='BD' AND pDietType='$diet' AND pOrigin='$origin' AND pRating='$rating'");
                                }else if((!empty($_GET['rating'])) && (!empty($_GET['origin']))){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='BD' AND pDietType='$diet' AND pRating='$rating'");
                                }else if((!empty($_GET['diet'])) && (!empty($_GET['origin']))){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='BD' AND pDietType='$diet' AND pOrigin='$origin'");
                                }else if((!empty($_GET['diet'])) && (!empty($_GET['rating']))){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='BD' AND pDietType='$diet' AND pRating='$rating'");
                                }else if(!empty($_GET['diet'])){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='BD' AND pDietType='$diet'");
                                }else if(!empty($_GET['origin'])){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='BD' AND pOrigin='$origin'");
                                }else if(!empty($_GET['rating'])){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='BD' AND pRating='$rating'");
                                }

                            }else{
                                $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='BD'");
                            }
                        }else if($prodDisplayType == 'DE' || $productDisplayed == 'DE' || $type == 'DE'){
                            if(!empty($_GET['filterStoredType'])){
                                
                                if((!empty($_GET['diet'])) && (!empty($_GET['origin'])) && (!empty($_GET['rating']))){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='DE' AND pDietType='$diet' AND pOrigin='$origin' AND pRating='$rating'");
                                }else if((!empty($_GET['rating'])) && (!empty($_GET['origin']))){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='DE' AND pDietType='$diet' AND pRating='$rating'");
                                }else if((!empty($_GET['diet'])) && (!empty($_GET['origin']))){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='DE' AND pDietType='$diet' AND pOrigin='$origin'");
                                }else if((!empty($_GET['diet'])) && (!empty($_GET['rating']))){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='DE' AND pDietType='$diet' AND pRating='$rating'");
                                }else if(!empty($_GET['diet'])){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='DE' AND pDietType='$diet'");
                                }else if(!empty($_GET['origin'])){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='DE' AND pOrigin='$origin'");
                                }else if(!empty($_GET['rating'])){
                                    $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='DE' AND pRating='$rating'");
                                }

                            }else{
                                $insertProducts = $conn->prepare("SELECT * FROM products WHERE pType='DE'");
                            }
                        }
                        else{
                            $insertProducts = $conn->prepare("SELECT * FROM products");
                        }

                        //Execute
                        $insertProducts->execute();

                        //fetches all the products from the database
                        $products = $insertProducts->fetchAll(PDO::FETCH_ASSOC);

                        if(count($products) == 0){
                            echo "<p>Sorry were no products that match your filtering </p>";
                        }
                        
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
                            
                            echo "<form action='products.php' method='GET' class='formBtn2'>";
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
                                echo '<button class="favStar">&#x2606;</button></form>';
                            }       

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
                ?>
                
            </div>
        </div>
    </body>
    <script>
      /*  function showDiet(str) {
            if(str == "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            } else { 
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET","testfilter.php?d="+str,true);
                xmlhttp.send();
            }
        }

        function showRating(str) {
            if(str == "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            } else { 
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET","testfilter.php?r="+str,true);
                xmlhttp.send();
            }*/
    </script>
    </html>