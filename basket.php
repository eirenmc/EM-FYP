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
        <center><h1> Basket </h1></center>
        <?php 
            global $productCartList;
            global $productTotal;
            global $pSumTotal;

            $productTotal = array();
            
           // print_r($_SESSION['productCartList']);
           $removeBasketItem = $_GET["removeFromBasket"];
           
           if(!empty($removeBasketItem)){
               //Searching for the array for the value of the removeBasketItem varaible in the productCartList array and
               //Storing it in a variable
                echo "Remove BasketItem Value: ".$removeBasketItem."<br>";
                $itemToRemove = array_search($removeBasketItem, $productCartList);
                echo "ItemToRemove value is: ".$itemToRemove."<br>";
                unset($GLOBALS[$removeBasketItem][$productCartList]);
                unset($productCartList[$removeBasketItem]);
                array_splice($productCartList, $itemToRemove, 1);
                array_splice($productCartList, $removeBasketItem, 1);
                //array_splice($productCartList, $itemToRemove, 1);
           }
            
            if(!empty($_SESSION['productCartList'])){

                $productCartList = $_SESSION["productCartList"];

                try{    
                   // var_dump($productCartArr);

                    //Loops through the product array session
                    for($pNumber = 0; $pNumber < count($productCartList); $pNumber++){
                        $arrNum = $productCartList[$pNumber];
                        
                        
                        $pBasketView = $conn->prepare("SELECT * FROM products WHERE pId = :pId");   
                        $pBasketView->bindParam(':pId', $arrNum);
                        $pBasketView->execute();

                        //Fetchs the database details
                        $row = $pBasketView->fetch(PDO::FETCH_ASSOC);
                        extract($row);
                        echo "</br><div class='container-fluid'>";
                        echo "<img src='./images/".$row['pImage'].".jpg' alt='basketItem'/> ";
                        echo "<div class='basketContent'>";
                        echo "<h3 class='aligning'>".$row['pName']."</h3>";
                        echo "<em><p> Quantity: </p></em>";
                        echo "<div class='quantity'>";
                        echo "</div>";

                        echo "<form action='basket.php' method='GET' class='formBtn'>
                            <input type='hidden'  name='removeFromBasket' value='".$row['pId']."'>
                           <b><input class='button alignTotal ".$row['pId']."' type='submit' value='Remove Item'></b></form>";

                        echo "<h3 class='alignRight'> €".$row['pPrice']."</h3></div></div></br><hr class='basketHr'>";

                        $productTotal[] = $row['pPrice'];
                        
                        
                        //print_r($_SESSION['productCartList']);     
                    }

                    //array_push($productTotal);
                    //print_r($productTotal);
                    $pSumTotal = array_sum($productTotal);
                        echo "</br><div class='container-fluid'>";
                        echo "<h1 class='alignTotal'>Total: €".$pSumTotal."</h1></div></div>";
                    //Place order button
                    /*echo "<center><form action='checkout.php' method='GET'>
                    <input type='submit' name='checkout' value='Proceed To Checkout'>";
                    echo "</form></center></br>";*/
                }
                catch(PDOException $e){
                    echo 'ERROR: '.$e -> getMessage();
                }          
        }else{
            $_SESSION['productCartList'] = array();
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
               <!-- <form action='checkout.php' method='GET'>-->
                <form action='placeOrder.php' method='POST'>
                     <input type='number' name='mobileNo'>
                     <input type='submit' name='checkout' value='Proceed To Checkout' class='alignTotal button'>
                </form>
            </center>
            </br>

    </body>
</html>