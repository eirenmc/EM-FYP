<div class="flex-container-filter">
    <div class="flex-item">
        <div class="titleBar">
            <h2>Filter By :</h2>
        </div>
        <div class="ratingFilter">
            <h3>Rating</h3>
            <input type="checkbox" name="1Star" value="1">
            <span class='rating five'>
               <span class='scoredRating'>☆</span>
            </span>
            <br>
            <input type="checkbox" name="2Star" value="2">
            <span class='rating five'>
                <span class='scoredRating'>☆</span><span class='scoredRating'>☆</span>
            </span>
            <br>
            <input type="checkbox" name="3Star" value="3">
            <span class='rating five'>
                <span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span class='scoredRating'>☆</span>
            </span>
            <br>
            <input type="checkbox" name="4Star" value="4">
            <span class='rating five'>
                <span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span class='scoredRating'>☆</span>
            </span>
            <br>
            <input type="checkbox" name="5Star" value="5">
            <span class='rating five'>
               <span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span class='scoredRating'>☆</span>
            </span>
        </div>
        <hr>
        <div class="priceFilter">
            <h3>Price</h3>
            <button class="button">Low - High</button>
            <button class="button">High - Low</button>
        </div>
        <hr>
        <div class="sortFilter">
            <h3>Sort</h3>
            <button class="button">A - Z</button>
            <button class="button">Z - A</button>
        </div>
        <hr>
        <div class="originFilter">
            <h3>Product Origin</h3>
            <p>(50 mile radius from each location in included)</p>
            <form>
                <span class="filterCheckbox">
                    <input type="checkbox" name="origin1" value="Clonmel">Clonmel
                </span>
                <br>
                <span class="filterCheckbox">
                    <input type="checkbox" name="origin2" value="Thurles">Thurles
                </span>
                <br>
                <span class="filterCheckbox">
                    <input type="checkbox" name="origin3" value="Cahir">Cahir
                </span>
                <br>
                <span class="filterCheckbox">
                    <input type="checkbox" name="origin4" value="Carrick On Suir">Carrick On Suir
                </span>
                <br>
                <span class="filterCheckbox">
                    <input type="checkbox" name="origin5" value="Callan">Callan
                </span>
                <br>
                <span class="filterCheckbox">
                    <input type="checkbox" name="origin6" value="Mitchlestown">Mitchlestown
                </span>
            </form>
        </div>
        <hr>
        <div class="dietFilter">
            <h3>Dietary Requirements</h3>
            <form>
                <span class="filterCheckbox">
                    <input type="checkbox" name="diet1" value="Organic">Organic
                </span>
                <br>
                <span class="filterCheckbox">
                    <input type="checkbox" name="diet4" value="Nut Free">Nut Free
                </span> 
                <br>               
                <span class="filterCheckbox">
                    <input type="checkbox" name="diet3" value="Gluten Free">Gluten Free
                </span>
                <br>
                <span class="filterCheckbox">
                    <input type="checkbox" name="diet2" value="Lactose Intolerant">Lactose Intolerant
                </span>
            </form>
        </div>
    </div>
</div>

<?php
                /*    try{                           
                        if($_GET["sortPriceLH"]){
                            //Using a prepared statement to select all the products in the products table
                            $insertProducts = $conn->prepare("SELECT * FROM products ORDER BY pPrice ASC");
                        }else if($_GET["sortPriceHL"]){
                             $insertProducts = $conn->prepare("SELECT * FROM products ORDER BY pPrice DESC");
                        }else if ($_GET["sortAZ"]){
                             $insertProducts = $conn->prepare("SELECT * FROM products ORDER BY pName ASC");
                        }else if($_GET["sortZA"]){
                             $insertProducts = $conn->prepare("SELECT * FROM products ORDER BY pName DESC");
                        }else if($_GET["location..."]){
                             $insertProducts = $conn->prepare("SELECT * FROM products WHERE location = 'Clonmel'");
                        }else if($_GET["location..."]){
                             $insertProducts = $conn->prepare("SELECT * FROM products WHERE location = 'Thurles'");
                        }else if($_GET["location..."]){
                             $insertProducts = $conn->prepare("SELECT * FROM products WHERE location = 'Cahir'");
                        }else if($_GET["location..."]){
                             $insertProducts = $conn->prepare("SELECT * FROM products WHERE location = 'Callan'");
                        }else if($_GET["location..."]){
                             $insertProducts = $conn->prepare("SELECT * FROM products WHERE location = 'Mitchlestown'");
                        }else if($_GET["location..."]){
                             $insertProducts = $conn->prepare("SELECT * FROM products WHERE location = 'Carrick'");
                        }
                        //Execute
                        $insertProducts->execute();

                        //fetches all the products from the database
                        $products = $insertProducts->fetchAll(PDO::FETCH_ASSOC);
                        
                        //Loops through all the products and displays the image, name, price and ass to cart button
                        for($i=0; $i < count($products); $i++){
                            echo "<div class='productBox'>";
                            $row = $products[$i];
                            echo "<center><b>".$row['pName']."</b><br><br>";
                            echo "<img src='./images/".$row['pImage'].".jpg' alt='product'/></br>";
                            echo "<b> Price: </b> €".$row['pPrice']." <b class='rate'> Rating: </b>";
                            
                            //Checks the rating and creates the stars depending on its rating
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
                            echo "</center></div>";
                        }
                    
                    }catch(PDOException $e){
                        echo 'ERROR: '.$e -> getMessage();
                    }*/
?>