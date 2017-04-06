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
        <center><h1>Favourites </h1></center>
        <br>


        <div class="flex-container-favPage">
            <div class="flex-item-product">
                <?php

                    global $productCartList;
                    global $uId;
                    global$itAFav;

                    //Putting into Basket
                    if(isset($_SESSION["productCartList"])){
                        $productCartArr = $_SESSION["productCartList"];
                    }else{
                        $_SESSION['productCartList'] = array();
                        $productCartArr = $_SESSION["productCartList"];
                    }

                    //Storing the session user id in a variable
                    if(isset($_SESSION["userId"])){
                        $uId = $_SESSION["userId"];

                        if(!empty($_GET['productSelectFavId'])){
                            echo "trying to unfavourite";
                            $prodSelectId = $_GET["productSelectFavId"];
                            
                            try{  
                                $stmt = $conn -> prepare("DELETE FROM favourites WHERE pId = '$prodSelectId' AND uId = '$uId'");                        
                                $stmt->execute();
                            }catch(PDOException $e){
                                echo 'ERROR: ' . $e->getMessage();
                            }
                        }

                        try{   
                            $insertProducts = $conn->prepare("SELECT * FROM products JOIN favourites ON favourites.pId=products.pId WHERE uId = '$uId'");
                            
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
                                
                                echo "<form action='favourites.php' method='GET' class='formBtn2'>";
                                echo "<input type='hidden'  name='productDisplayed' value='".$row['pType']."'>";

                                echo "<input type='hidden'  name='productSelectFavId' value='".$row['pId']."'>";
                                echo "<button class='favStar'>&#x2605;</button></form>";

                                //Add an if statement to decide which fav button to show
                                echo "<form action='favourites.php' method='GET'>
                                <input type='hidden'  name='productBasketId' value='".$row['pId']."'>
                                <input type='hidden'  name='productDisplayed' value='".$row['pType']."'>
                                <input class='btn2 ".$row['pId']."' type='submit' value='Add To Cart'></form>";
                                echo "</div>";
                            }
                        }catch(PDOException $e){
                            echo 'ERROR: '.$e -> getMessage();
                        }
                    }
                ?>
            </div>
        </div>
        <?php include "footer.php" ?>
    </body>
</html>