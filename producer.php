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
        <?php include "header.php" ?>
        <br>
        <br>
        <div class="flex-container-producer">
            <div class="flex-item-producer">
                <?php
                    //Checking tthat the userId session has been set
                    if(isset($_SESSION["userId"])){
                        $uId = $_SESSION["userId"];
                    }

                    try{ 
                        //Selects the producers from the database so they can later be displayed
                        $insertProducers = $conn->prepare("SELECT * FROM producers");

                        //Execute
                        $insertProducers->execute();

                        //fetches all the products from the database
                        $producer = $insertProducers->fetchAll(PDO::FETCH_ASSOC);
                        
                        //Loops through all the products and displays the image, name, price and ass to cart button
                        for($i=0; $i < count($producer); $i++){
                            $row = $producer[$i];
                            echo "<div class='producerBox'>";
                            echo "<img src='./images/".$row['producerImage'].".jpg' alt='producer'/></br>";
                            echo "<center><b>".$row['producerName']."</b><br>";
                            echo "</center>";  
                            /*echo "<form action='producerDetail.php' method='GET'>
                            <input type='hidden'  name='producerViewId' value='".$row['producerId']."'>
                            <input class='btn2 ".$row['producerId']."' type='submit' value='View Producer'></form>";*/
                            echo "</div>";
                            
                            $currentPId = $row['pId'];
                        }
                    }catch(PDOException $e){
                        echo 'ERROR: '.$e -> getMessage();
                    }
                ?>
                
            </div>
        </div>
        
        <br>
        <br><!--
        <div id="producerLocations">
            <center>
                <iframe src="https://www.google.com/maps/d/embed?mid=1Cxlpp8xZ6U-ZvufNIRdYODxYyH8" width="640" height="480" id="producerMap"></iframe>
            </center>
        </div>-->
        <br>
        <?php include "footer.php" ?>
        </body>