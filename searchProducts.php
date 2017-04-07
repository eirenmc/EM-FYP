 <?php
    //Starts/Resumes sessions
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
        <?php

            if(!empty($_GET['productBasketId'])){
                global $conn;
                $productSelectedId = $_GET["productBasketId"];
                
                try{  
                    $stat = $conn->prepare('SELECT * FROM products WHERE pId = :pId');
                    $stat->bindParam(':pId', $productSelectedId);
                    $stat->execute();
                    array_push($_SESSION['productCartList'],$productSelectedId);         
                }
                catch(PDOException $e){
                    echo 'ERROR: ' . $e->getMessage();
                }
            }
        ?>
        <?php include "header.php" ?>
        <br>        
        <div class="flex-container-searchPage">
            <div class="flex-item-search">
                <?php
                    global $productCartList;
                    global $uId;
                    global $term;

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

                    if((!empty($_POST['searchTerm'])) || (!empty($_GET['productSearchDisplayed']))){
                        
                        if(!empty($_GET['productSearchDisplayed'])){
                            $term = $_GET['productSearchDisplayed'];
                        }else if(!empty($_POST['searchTerm'])){
                            $term = $_POST['searchTerm'];
                        }   
                        
                        $term = strtolower($term);

                        try{
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
                                echo "<form action='productDetail.php' method='GET' class='formBtn'>
                                <input type='hidden'  name='productViewId' value='".$row['pId']."'>
                                <input class='btn ".$row['pId']."' type='submit' value='View Product'></form>";
                                
                                echo "<form action='searchProducts.php' method='GET' class='formBtn2'>";
                                echo "<input type='hidden' name='productSearchDisplayed' value='".$term."'>";

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
                            
                                // echo "<input class='btn2 ".$row['pId']."' type='submit' value='Add To Favourties'></form>";           

                                //Add an if statement to decide which fav button to show
                                echo "<form action='searchProducts.php' method='GET'>
                                <input type='hidden'  name='productBasketId' value='".$row['pId']."'>
                                <input type='hidden'  name='productSearchDisplayed' value='".$term."'>
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