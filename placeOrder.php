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

        <div class="flex-container-producer">
            <div class="flex-item-producer">
                <?php
                    global $cutMobileNo;
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



                                    ?>
