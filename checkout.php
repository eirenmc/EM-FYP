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
        
        <div class="content">
            <form class="modal-content" action="placeOrder.php" method="POST">
                <div class="container">
                    <br>
                    <h2>Contact Details</h2>
                    <label>Email :</label>
                    <input type="text" placeholder="Enter Email Address" name="email" class="field" required>
                    <br><br>
                    <label>Phone Number :</label>
                    <input type="number" placeholder="Enter Phone Number" name="phoneNo" class="field" required>
                    <br><br>

                    <h2>Shipping Address</h2>
                    <label>Full Name :</label>
                    <input type="text" placeholder="Enter Password" name="password" class="field" required>
                    <br><br>
                    <label>Address line 1 :</label>
                    <input type="text" placeholder="Enter Password" name="password" class="field" required>
                    <br><br>
                    <label>Address line 2 :</label>
                    <input type="text" placeholder="Enter Password" name="password" class="field" required>
                    <br><br>
                    <label>Town/City :</label>
                    <input type="text" placeholder="Enter Password" name="password" class="field" required>
                    <br><br>
                    <label>County/State :</label>
                    <input type="text" placeholder="Enter Password" name="password" class="field" required>
                    <br><br>
                    <label>Postcode/Zip :</label>
                    <input type="number" placeholder="Enter Password" name="password" class="field" required>
                    <br><br>
                    <label>Country :</label>
                    <input type="text" placeholder="Enter Password" name="password" class="field" required>
                    <br><br>

                    <h2>Payment Details</h2>
                    <label>Card Type :</label>
                    <input type="text" placeholder="Enter Password" name="password" class="field" required>
                    <select>
                        <option value="visa" name="cardType">Visa</option>
                        <option value="mastercard" name="cardType">Mastercard</option>
                    </select>
                    <br><br>
                    <label>Card Number :</label>
                    <input type="number" name="cardNo" class="field" required>
                    <br><br>
                    <label>Valid To :</label>
                    <select>
                        <option value="01" name="validFromMonth">01</option>
                        <option value="02" name="validFromMonth">02</option>
                        <option value="03" name="validFromMonth">03</option>
                        <option value="04" name="validFromMonth">04</option>
                        <option value="05" name="validFromMonth">05</option>
                        <option value="06" name="validFromMonth">06</option>
                        <option value="07" name="validFromMonth">07</option>
                        <option value="08" name="validFromMonth">08</option>
                        <option value="09" name="validFromMonth">09</option>
                        <option value="10" name="validFromMonth">10</option>
                        <option value="11" name="validFromMonth">11</option>
                        <option value="12" name="validFromMonth">12</option>
                    </select>
                    <select>
                        <option value="2017" name="validToYear">2017</option>
                        <option value="2018" name="validToYear">2018</option>
                        <option value="2019" name="validToYear">2019</option>
                        <option value="2020" name="validToYear">2020</option>
                        <option value="2021" name="validToYear">2021</option>
                        <option value="2022" name="validToYear">2022</option>
                        <option value="2023" name="validToYear">2023</option>
                        <option value="2024" name="validToYear">2024</option>
                        <option value="2025" name="validToYear">2025</option>
                        <option value="2026" name="validToYear">2026</option>
                        <option value="2027" name="validToYear">2027</option>
                        <option value="2028" name="validToYear">2028</option>
                        <option value="2029" name="validToYear">2029</option>
                        <option value="2030" name="validToYear">2030</option>
                        <option value="2031" name="validToYear">2031</option>
                        <option value="2032" name="validToYear">2032</option>
                        <option value="2033" name="validToYear">2033</option>
                        <option value="2034" name="validToYear">2034</option>
                        <option value="2035" name="validToYear">2035</option>
                    </select>
                    <br><br>
                    <label>Name on Card :</label>
                    <input type="text" placeholder="Enter Password" name="password" class="field" required>
                    <br><br>
                    <label>CVV2 Number :</label>
                    <input type="text" placeholder="Enter Password" name="password" class="field" required>
                    <br><br>
                    <button class="button" type="submit">Login</button>
                </div>
            </form>
        </div>

        <div class="BasketSummary">
            <h4>Basket Summary</h4>
            <?php

            global $productCartList;
            global $productTotal;
            global $pSumTotal;

            $productTotal = array();
            
            if(!empty($_SESSION['productCartList'])){
                $productCartList = $_SESSION["productCartList"];

                try{    
  
                    //Loops through the product array session
                    for($pNumber = 0; $pNumber < count($productCartList); $pNumber++){
                        $arrNum = $productCartList[$pNumber];
                        
                        $pBasketView = $conn->prepare("SELECT * FROM products WHERE pId = :pId");   
                        $pBasketView->bindParam(':pId', $arrNum);
                        $pBasketView->execute();

                        //Fetchs the database details
                        $row = $pBasketView->fetch(PDO::FETCH_ASSOC);
                        extract($row);
                        echo "<p".$row['pName']."</p>";
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
            ?>
        </div>
        