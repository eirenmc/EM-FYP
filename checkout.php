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
        <!-- HTML content for the checkout form -->
        <div class="content">
            <form class="modal-content" action="placeOrder.php" method="POST">
                <div class="container processOrder">
                    <br>
                    
                    <h2>Contact Details</h2>
                    <br>
                    <label>Email :</label><br>
                    <input type="text" name="email" class="field fieldSpace" required>
                    <br><br>
                    <label>Mobile Number :</label>
                    <br>
                    <input type="number" name="mobileNo" class="field fieldSpace" required>
                    <br>
                    <br>
                    <br>

                    <h2>Shipping Address</h2>
                    <br>
                    <label>Full Name :</label><br>
                    <input type="text" name="fullName" class="field fieldSpace" required>
                    <br><br>
                    <label>Address line :</label><br>
                    <input type="text" name="address" class="field fieldSpace" required>
                    <br><br>
                    <label>Town/City :</label><br>
                    <input type="text" name="town" class="field fieldSpace" required>
                    <br><br>
                    <label>County :</label><br>
                    <input type="text" name="county" class="field fieldSpace" required>
                    <br><br>
                    <label>Country :</label><br>
                    <input type="text" name="country" class="field fieldSpace" required>
                    <br><br>

                    <h2>Payment Details</h2>
                    <img src="/images/visa.png" alt="card" width="50px" height="50px"/>
                    <img src="images/mastercard.png" alt="card" width="50px" height="50px"/>
                    <br>
                    <label>Card Type :</label>
                    <br>
                    <select>
                        <option value="visa" name="cardType">Visa</option>
                        <option value="mastercard" name="cardType">Mastercard</option>
                    </select>
                    <br><br>
                    <label>Card Number :</label><br>
                    <input type="number" name="cardNo" class="field fieldSpace" required>
                    <br><br>
                    <label>Valid To :</label><br>
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
                    </select>
                    <br>
                    <br>
                    <label>Name on Card :</label><br>
                    <input type="text" name="cardName" class="field fieldSpace" required>
                    <br>
                    <br>
                    <label>CVV2 Number :</label><br>
                    <input type="text" name="cvv2" class="field fieldSpace" required>
                    <br>
                    <br>
                    <?php
                        //Global variable to access the total of the basket cost
                        global $pSumTotal;

                        //Storing and getting the value in the order total being passed on from the basket page
                        $productTotal = array();
                        $pSumTotal = $_GET['totalBasket'];

                        //Checks if the basket page is not empty and if so displays the order total
                        if(!empty($_GET['totalBasket'])){
                            echo "<input type='hidden' name='orderAmount' value='".$pSumTotal."'>";
                        }
                    ?>
                    <div class="BasketSummary">
                        <h2>Basket Total:</h2>
                        <?php
                            //Global variable to access the total of the basket cost
                            global $pSumTotal;
                            global $productTotal;

                            //Storing and getting the value in the order total being passed on from the basket page
                            $productTotal = array();
                            $pSumTotal = $_GET['totalBasket'];

                            //Checks if the basket page is not empty and if so displays the order total
                            if(!empty($_GET['totalBasket'])){
                                echo "<h1>".$pSumTotal."</h1>";
                                echo "<input type='hidden' value='.$pSumTotal.' name='orderAmount'>";
                            }
                        ?>
                        <br>
                        <button type='submit' name='placeOrder' value='Place Order' class="button">Place Order </button>
                </div>
            </form>
        </div>
        </div>
        <?php include "footer.php" ?>
    </body>
        