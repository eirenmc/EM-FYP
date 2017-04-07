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
        <meta name="description" content="Online eccomerce site of local producers">
        <meta name="keywords" content="Local Producers,eccommerce,local,buy,online,shopping">
        <meta name="author" content="Eiren McLoughlin">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php
            //Checks if the productBasketId is not empty meaning a product was added to the basket
            if(!empty($_GET['productBasketId'])){
                global $conn;
                $productSelectedId = $_GET["productBasketId"];
                
                try{  
                    //Selects all the entries int eh database which match with the shopping basket it and the product id in
                    //the database
                    $stat = $conn->prepare('SELECT * FROM products WHERE pId = :pId');
                    //Binding
                    $stat->bindParam(':pId', $productSelectedId);
                    //Executes
                    $stat->execute();
                    //Pushes the selected products into the session array
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
        <br

        <div class="flex-container-favPage">
            <div class="flex-item-fav">
                <?php
                    //Gloabl variables
                    global $productCartList;
                    global $uId;
                    global$itAFav;

                    //Setting sessions for the Basket
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
                            //Holds the value of the favourite sthaat has been clicked
                            $prodSelectId = $_GET["productSelectFavId"];
                            
                            try{
                                //Deletes from the favourites table where the product id and user id match
                                $stmt = $conn -> prepare("DELETE FROM favourites WHERE pId = '$prodSelectId' AND uId = '$uId'");                        
                                $stmt->execute();
                            }catch(PDOException $e){
                                echo 'ERROR: ' . $e->getMessage();
                            }
                        }

                        try{  
                            //Selects all the products that are favourites for the user who is logged in, it retrieves all the
                            //products data by joining both tables 
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
                                
                                //Checks the rating and creates the stars depending on its rating it will show the rigt number of stars
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
                                //View Product Button
                                echo "<form action='productDetail.php' method='GET' class='formBtn'>
                                <input type='hidden'  name='productViewId' value='".$row['pId']."'>
                                <input class='btn ".$row['pId']."' type='submit' value='View Product'></form>";
                                
                                //Favourites Buttno
                                echo "<form action='favourites.php' method='GET' class='formBtn2'>";
                                echo "<input type='hidden'  name='productDisplayed' value='".$row['pType']."'>";
                                echo "<input type='hidden'  name='productSelectFavId' value='".$row['pId']."'>";
                                echo "<button class='favStar'>&#x2605;</button></form>";

                                //Show the filled in star as the user is already on the favourites page
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