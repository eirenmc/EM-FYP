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
        <br>
        <br>
        <center>
        <h1> Thank you, your order has been placed </h1>
        </center>
        <div class="flex-container-producer">
            <div class="flex-item-producer">
                <?php
                    //Stores the post values into variables
                    $emailSender = $_POST['email'];
                    $orderMobileNo = $_POST['mobileNo'];
                    $nameSender = $_POST['fullName'];
                    $orderAddress = $_POST['address'];
                    $orderTown = $_POST['town'];
                    $orderCounty = $_POST['county'];
                    $orderCountry = $_POST['country'];
                    $orderAmount = $_POST['orderAmount'];
 
                    //Checks thats the input fields are not empty
                    if((!empty($_POST['fullName'])) && (!empty($_POST['email'])) && (!empty($_POST['orderAmount'])) && (!empty($_POST['mobileNo'])) && (!empty($_POST['address'])) && (!empty($_POST['town'])) && (!empty($_POST['county'])) && (!empty($_POST['country']))){
                        //Cleans the values entered in the inputs to make sure no invalid characters or code is submitted
                        //If so then it rips it out
                        $nameSender = clean_input($_POST['fullName']);
                        $emailSender = clean_input($_POST['email']);
                        $orderAmount = clean_input($_POST['orderAmount']);
                        $orderMobileNo = clean_input($_POST['mobileNo']);
                        $orderAddress = clean_input($_POST['address']);
                        $orderTown = clean_input($_POST['town']);
                        $orderCounty = clean_input($_POST['county']);
                        $orderCountry = clean_input($_POST['country']);
                    
                        //Calls the sendEmail function
                        sendEmail($nameSender, $emailSender, $orderAmount, $orderMobileNo,  $orderAddress, $orderTown, $orderCounty, $orderCountry);
                    }else{
                        //If no Post values, it makes the variables equal null
                        $email = NULL;
                        $nameSender = NULL;
                        $emailSender = NULL;
                        $orderAmount = NULL;
                        $orderMobileNo = NULL;
                        $orderAddress = NULL;
                        $orderTown = NULL;
                        $orderCounty = NULL;
                        $orderCountry = NULL;
                        echo "<h2> Opps ....</h2> <p> You dont seem have entered your details, please enter all the data</p>";
                        echo "<br> <a href='checkout.php'>";
                    }

                    //Function that cleans data and strips out tags and code so inputs can't be code
                    function clean_input($data){
                        //Cleans teh data that has been submitted in the form
                        $data = strip_tags($data);
                        $data = trim($data);
                        $data = htmlentities($data);
                        $data = htmlspecialchars($data);
                        $data = strIpslashes($data);

                        return $data;
                    }

                    function sendEmail($nameSender, $emailSender, $orderAmount, $orderMobileNo,  $orderAddress, $orderTown, $orderCounty, $orderCountry){
                        //Who the email will be send to
                        $to = $emailSender;
                        //Who the email will be sent from
                        $from = "orderconfirmation@buylocal.ie";
                
                        //Subject of the email
                        $subject = "Buy Local Order Confirmation";

                        //Headers of the email, includes whoses the email from,bcc
                        $headers = "From: ".strip_tags($from)."\r\n";

                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-type: text/html; charset=ISO-8859-1\r\n";
                        //Email message
                        $emailCustomerMsg = "<p> Hi ".$nameSender."</p>
                        <p>Thank you for placing an order with Buy Local. 
                        Your delivery will arrive shortly, if you have any problems please contact us</p></br>
                        <p> We are excited to let you know that you order has been dispatched </p>  
                        <p> Below are your delivery details: </p> <br>
                        <b> Delivery To: </b>".$nameSender."<br><b> Delivery Address: </b><p>".$orderAddress."</p>
                        <p>".$orderTown."</p><p>".$orderCounty."</p><p>".$orderCountry."</p>
                        <h3>Contact Number: </h3><p>".$orderMobileNo."</p><br><h3>Total Order Cost</h3>
                        <p>".$orderAmount."</p>";
                        wordwrap($message,100);
                        
                        //Sends email
                        mail($to,$subject,$emailCustomerMsg,$headers);
                    }

                    unset($_SESSION["productCartList"]);

                ?>
            </div>
        </div>