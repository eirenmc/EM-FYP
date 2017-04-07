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
                   /* global $cutMobileNo;
                    $mobileNum = $_POST["mobileNo"];

                    if(!empty($_POST['mobileNo'])){
                        $mobileNum = clean_input($_POST['mobileNo']);
                        echo "Number entered: ".$mobileNum;
                        $cutMobileNo = substr($mobileNum, 1);
                        echo "<br>Number is now: ".$cutMobileNo;
                    }

                    function clean_input($data){
                        $data = strip_tags($data);
                        $data = trim($data);
                        $data = htmlentities($data);
                        $data = htmlspecialchars($data);
                        $data = strIpslashes($data);

                        return $data;
                    }
*/
                $nameSender = $_POST['fullName'];
                $emailSender = $_POST['email'];
                $orderAmount = = $_POST['orderAmount'];
                $orderMobileNo = $_POST['mobileNo'];
                $orderAddress = $_POST['address'];
                $orderTown = $_POST['town'];
                $orderCounty = $_POST['county'];
                $orderCountry = $_POST['country'];

                //Checks thats the input fields are not empty
                if((!empty($_POST['fullName'])) && (!empty($_POST['email'])) && (!empty($_POST['orderAmount'])) && (!empty($_POST['mobileNo'])) && (!empty($_POST['address'])) && (!empty($_POST['town']))&& (!empty($_POST['county'])) && (!empty($_POST['country']))){
                    
                    //Cleans the values entered in the inputs
                    $nameSender = clean_input($_POST['fullName']);
                    $emailSender = clean_input($_POST['email']);
                    $orderAmount = clean_input($_POST['orderAmount']);
                    $orderMobileNo = clean_input($_POST['mobileNo']);
                    $orderAddress = clean_input($_POST['address']);
                    $orderTown = clean_input($_POST['town']);
                    $orderCounty = clean_input($_POST['county']);
                    $orderCountry = clean_input($_POST['country']);

                    sendEmail($nameSender, $emailSender, $orderAmount, $orderMobileNo,  $orderAddress, $orderTown, $orderCounty, $orderCountry);
                }else{
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
                    echo "<br> <a href='contact.php'>";
                }

                //Function that cleans data and strips out tags and code so inputs can't be code
                function clean_input($data){
                    $data = strip_tags($data);
                    $data = trim($data);
                    $data = htmlentities($data);
                    $data = htmlspecialchars($data);
                    $data = strIpslashes($data);

                    return $data;
                }

                function sendEmail($nameSender, $emailSender, $messageSender){
                    $webOwnerEmail = '';
                    $to = $webOwnerEmail;

                    //Subject of the email
                    $subject = "Buy Local Order Confirmation";

                    //Headers of the email, includes whoses the email from,bcc
                    $headers = "From: ".strip_tags($emailSender)."\r\n";

                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-type: text/html; charset=ISO-8859-1\r\n";
                    $message = $messageSender;
                    wordwrap($message,100);
                    //Sends email
                    mail($to,$subject,$message,$headers);
                    
                    //Feedback for the user
                    echo "<center> <br> <h2> Thank you for contacting Buy Local !</h2>";
                    echo "<br> <a href='index.php'><button class='button'> Return Home </button></a></center>";
                }

                unset($_SESSION["productCartList"]);

                ?>
