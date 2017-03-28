<?php
    session_start();
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
        <?php 
            global $productCartList;
            
            print_r($_SESSION['productCartList']);
            
            if(!empty($_SESSION['productCartList'])){

                $productCartArr = $_SESSION["productCartList"];

                try{

                    //Connecting to database
                    $conn = new PDO();
                    $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        
                    var_dump($productCartArr);

                    //Loops through the product array session
                    for($pNumber = 0; $pNumber < count($productCartArr); $pNumber++){
                        $arrNum = $productCartArr[$pNumber];
                        
                        $pBasketView = $conn->prepare("SELECT * FROM products WHERE pId = :pId");   
                        $pBasketView->bindParam(':pId', $arrNum);
                        $pBasketView->execute();

                        //Fetchs the database details
                        $row = $pBasketView->fetch(PDO::FETCH_ASSOC);
                        extract($row);
                        echo "</br> <div class='container-fluid'  width:'200px'> <div class='row'>";
                        echo "<b><p class='aligning'> Name: </b>".$row['pName']."</p>";
                        echo "<b><p class='aligning'> Price: </b> €".$row['pPrice']."</p></br>";
                        
                    }

                    //Place order button
                    echo "<center><form action='placeOrder.php' method='GET'>
                    <input type='submit' name='placeOrder' value='Place Order'> </center>";
                    echo "</div> </div></br>";
                }
                catch(PDOException $e){
                    echo 'ERROR: '.$e -> getMessage();
                }          
        }else{
            //Displays if there isn't anything in the cart
            echo "</br> <center> Opps, it seems that you have nothing in your cart";
            echo "</br> <img src='images/sad.png' margin='100px' width='150px' height='150px' alt='sadCart'/>";
            echo "</br> <a href='products.php'><button> View Products </button></a> </center>";
        }
        ?>
    </body>
</html>