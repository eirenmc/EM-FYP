<?php 
   //session_start();
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
        <?php //include "header.php";
         ?>
        
        <div class="flex-container-aboutPage">
            <div class="flex-item-frontPage">
                <img src="images/aboutImg.jpg" alt="front" id="imgForText"/>
                <h1 id="textAlignImg">Buy Local</h1>
            </div>
        </div>
       
        <br>
        <br>

        <div class="flex-container-frontPage beginning">
            <div class="flex-item-frontPage">
                <p>Buy Local is an Irish Local Producer source for locally produced food. Our hope is to encourage the purchasing of locally produced products in supporting locally, healthy food choices and knowing what you buy and where you buy are important.</p>
                <p>We provide you the opportunity not only to purchase locally produced food but to know who your getting it from so that you know it is high quality and food is the way you want it </p>
            </div>
        </div>

        <br>
        <br>
         <?php include "deliveryInfo.php" ?>

        <br>

         <div class="flex-container-frontPage aboutContainer">
            <div class="flex-item-frontPage">
                <h1>Local Producers</h1>
                <p>If you are a local producer and are interested in collobrating with Buy Local, please get in contact with us. For local producers we offer a space where you can sell your products online and be recognised as a local producer, you get control over what products you want to sell online and how much to sell them for</p>                
                <p>We provide you the opportunity not only to purchase locally produced food but to know who your getting it from so that you know it is high quality and food is the way you want it </p>
            </div>
        </div>

         <div class="flex-container-frontPage">
            <div class="flex-item-frontPage">
                <p>Buy Local is a project being developed by 4th Year Creative Multimedia student Eiren McLoughlin studying in Limerick Institute of Technology Clonmel </p> 
            </div>
        </div>
        <br>
        <div class="contact">
            <center><h2> Contact Buy Local ! </h2></center>
            <br>
            <form action="sendMessage.php" method="POST">
                <div class="form-group2">
                    <b>Full Name : </b>
                    <input type="text"class="field" name="name" id="name" maxlength="30" placeholder="Full Name" required>
                </div>
                <br>
                <div class="form-group2">
                    <b>Email Address : </b>
                    <input type="text" name="emailSender" class="field" id="emailSender" maxlength="30" placeholder="Email Address" required>
                </div>
                <br>
                <div class="form-group2">
                    <b>Message : </b>
                    <textarea type="text" name="messageSender" class="field" id="messageSender" maxlength="500" rows="6" cols="50" required> </textarea>
                </div>
                <br>
                <br>
                <center><button name="submit" class='button'> Submit </button></center>
            </form>
        </div>
        <?php include "footer.php" ?>
    </body>
</html>