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
            //Creating a global variable to handle variable scope
            global $productCartList;
            
            //Storing the value of the GET request in a variable for later reference
            $removeBasketItem = $_GET["removeFromBasket"];
           
            //Checking that the variable isnt empty and if its not empty it runs
            if(!empty($removeBasketItem)){
               
               //Searchs the session for the basket/cart which holds an array of products that have
               //been added to te basket/cart. It checks the array stored in the session for the value
               //of removeBasketItem and returns its index position in the array
                $key=array_search($removeBasketItem, $_SESSION['productCartList']);
                if($key!==false)
                //By unsetting the session and the newly found index position, it removes the relevant entry
                unset($_SESSION['productCartList'][$key]);
                //Updates the alues in the session array so that it excludes the one the user was trying to
                //delete
                $_SESSION["productCartList"] = array_values($_SESSION["productCartList"]);
       
            }

        ?>
        <?php include "header.php" ?>
        <center><h1> Basket </h1></center>
        <?php 
            //Global variables
            global $productCartList;
            global $productTotal;
            global $pSumTotal;

            //Making the variable hold the same value as the session
            $pSumTotal = $_SESSION["sumTotal"];
            //Creating an array that holds all the products total so later a total can be totted up
            $productTotal = array();
            
            //Checks that there is something in the shopping basket/cart
            if(!empty($_SESSION['productCartList'])){
                //Making te variable hold the same data as the session
                $productCartList = $_SESSION["productCartList"];
                
                try{    
                    //Loops through the product array session
                    for($pNumber = 0; $pNumber < count($productCartList); $pNumber++){
                        //Stores each in a variable
                        $arrNum = $productCartList[$pNumber];
                        
                        //Selecting data from the database, binding it and executing it so that the data can be called and used
                        $pBasketView = $conn->prepare("SELECT * FROM products WHERE pId = :pId");   
                        $pBasketView->bindParam(':pId', $arrNum);
                        $pBasketView->execute();

                        //Fetchs the database details and creates the code to display/rendered
                        $row = $pBasketView->fetch(PDO::FETCH_ASSOC);
                        extract($row);
                        echo "</br><div class='container-fluid'>";
                        echo "<img src='./images/".$row['pImage'].".jpg' alt='basketItem'/> ";
                        echo "<div class='basketContent'>";
                        echo "<h3 class='aligning'>".$row['pName']."</h3>";
                        echo "<form action='basket.php' method='GET' class='formBtn'>
                            <input type='hidden'  name='removeFromBasket' value='".$row['pId']."'>
                           <b><input class='button ".$row['pId']."' type='submit' value='Remove Item'></b></form>";
                        echo "</div>";
                        echo "<br>";
                        echo "<h3 class='alignRight'> €".$row['pPrice']."</h3></div></div></br><hr class='basketHr'>";

                        //Storing the price of each product in the basket into an array
                        $productTotal[] = $row['pPrice'];   
                    }
      
                    //Calculates the summary and displays it
                    $pSumTotal = array_sum($productTotal);
                        echo "</br><div class='container-fluid'>";
                        echo "<h1 class='alignTotal'>Sub-Total: €".$pSumTotal."</h1></div></div>";
                }catch(PDOException $e){
                    //shows error messages
                    echo 'ERROR: '.$e -> getMessage();
                }          
        }else{
            //If the session is empty, I am creating one and storing it as an array
            $_SESSION['productCartList'] = array();
            //Storing the session value in a variable
            $productCartList = $_SESSION["productCartList"];

            //Displays if there isn't anything in the cart
            echo "</br> <center> Opps, it seems that you have nothing in your cart";
            echo "</br> <img src='images/sad.png' margin='100px' width='150px' height='150px' alt='sadCart'/>";
            echo "</br> <a href='products.php'><button> View Products </button></a> </center>";
        }
        ?>

        </br>
            <div class='container-fluid'>
            <a href="products.php?prodType=BK&submit3=Bakery"><input type='button' name='return' value='Continue Shopping' class='button'></a>
            <center>
                <?php
                    //Checks if the shopping baskeet/cart is empty if not it renders a checkout button and shows the subtotal of
                    //all the products giving the user the total cost
                    if(!empty($_SESSION['productCartList'])){
                        echo "<form action='checkout.php' method='GET'>";
                        echo "<input type='hidden' name='totalBasket' value='".$pSumTotal."'>";
                        echo "<input type='submit' name='checkout' value='Proceed To Checkout' class='alignCheckoutBtn button'>";
                        echo "</form>";
                    }
                ?>
            </center>
            </br>

    </body>
</html>