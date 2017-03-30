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
        <?php
            $nameSender = $_POST['name'];
            $emailSender = $_POST['emailSender'];
            $messageSender = $_POST['messageSender'];

            //Checks thats the input fields are not empty
            if((!empty($_POST['name'])) && (!empty($_POST['emailSender'])) && (!empty($_POST['messageSender']))){
                
                //Cleans the values entered in the inputs
                $nameSender = clean_input($_POST['name']);
                $emailSender = clean_input($_POST['emailSender']);
                $messageSender = clean_input($_POST['messageSender']);

                sendEmail($nameSender, $emailSender, $messageSender);
            }else{
                $email = NULL;
                $emailSender = NULL;
                $messageSender = NULL;
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
                $webOwnerEmail = 'eiren.mcloughlin@gmail.com';
                $to = $webOwnerEmail;

                //Subject of the email
                $subject = "Buy Local Response";

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
        ?>