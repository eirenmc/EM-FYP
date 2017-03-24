<!DOCTYPE html>
    <?php
        session_start();
    ?>
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
            if(!empty($_SESSION['productCartList'])){

        $productCartArr = $_SESSION["productCartList"];

            try{

                //Connecting to database
               $conn = new PDO('mysql:host=localhost; dbname=ttbgqu_embl', 'ttbgqu_emweb', 'T9&O+m1uVD98');
               $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                //var_dump($productCartArr);

                //Loops through the product array session
                for($pCounter = 0; $pCounter < count($productCartArr); $pCounter++){
                    $arrNum = $productCartArr[$pCounter];
                    
                    $viewCart = $conn->prepare("SELECT * FROM products WHERE pid = :pid");   
                    $viewCart->bindParam(':pid', $arrNum);
                    $viewCart->execute();

                    //Fetchs the database details
                    $row = $viewCart->fetch(PDO::FETCH_ASSOC);
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
