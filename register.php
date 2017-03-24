<?php
    //Starts/Resumes sessions
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

        <div class="forms"><center>
            <h2> Register an Account </h2>
            <br>
            <form action="registerUser.php" method="POST">
                <div class="form-group">
                    <b>First Name: </b>
                    <input type="text" name="fname" id="fname" class="field" maxlength="90" placeholder="First Name" required>
                </div>
                <br>
                <div class="form-group">
                    <b>Last Name: </b>
                    <input type="text" name="lname" id="lname" class="field" maxlength="90" placeholder="Last Name" required>
                </div>
                <br>
                <div class="form-group">
                        <b>Username: </b>	
                        <input type="text" name="uname" id="username" class="field" maxlength="90" placeholder="Username" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <b>Password: </b>
                        <input type="password" name="password" id="password" class="field" maxlength="90" placeholder="Password" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <b>Email Address: </b>
                        <input type="email" name="email" id="email" class="field" maxlength="90" placeholder="Email" required>
                    </div>
                    <br>
                <input type="submit" name="submit" class="button" value="Submit"></center>
            </form>
        </div>

            <?php include "footer.php" ?>
    </body>