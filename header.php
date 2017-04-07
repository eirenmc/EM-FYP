<?php
    //Start or restore session variables
    session_start();
    //Including the database connection file
    include_once "dbCon.php";
   
   //Check that the session uname is not empty, the uname session is used to display the username in the top right corner
    if(!empty($_SESSION['uname'])){
        //Makes the username variable equal the value stored in the session
        $username = $_SESSION['uname'];
        //Gets the user infomation from the Database
        $getUserId = $conn->prepare("SELECT uId FROM customers WHERE uName ='$username'");
        //Executes the database select
        $getUserId->execute();
        //Fetches database query results and stores them in a variable
        $userStored = $getUserId->fetch(PDO::FETCH_ASSOC);
                        
        //Checks if the userId session is checked in order to access and insert and delete things such as favourites 
        //based on the correct user id rather than username
        if(isset($_SESSION["userId"])){
            $_SESSION["userId"] = $userStored['uId'];
        }else{
            $_SESSION["userId"] = $userStored['uId'];
        }   
    }   
?>

<nav id="Nav1">
    <a href="index.php"><img src="images/logo.png" alt="BuyLocal logo"/></a>
    
    <ul class="flex-container wrap left">
        <a href="about.php"><li class="flex-menu-item-top">About</li></a>
        <a href="producer.php"><li class="flex-menu-item-top">Producers</li></a>
        <?php
            //If a user is logged in based on the userame session it will show the favourites menu item
             if(!empty($_SESSION['uname'])){
                echo "<a href='favourites.php'><li class='flex-menu-item-top'>Favourites</li></a>";                
            }
        ?>
    </ul>

    <ul class="flex-container wrap right">
        <b><li class="flex-menu-item-top dropdown" onclick="document.getElementById('id01').style.display='block'">
        <?php 
            //If the user is logged in, the menu will greet the user otherwise it will default to Login to Account
             if(!empty($_SESSION['uname'])){
                $username = $_SESSION['uname']; 
                print_r("Hi ".$username);
            }else{
                echo "Login to Account";
            }
        ?></li></b>

        <?php
            //Shows the logout button if the user is logged in
            if(!empty($_SESSION['uname'])){               
                echo "<form action='index.php' method='GET'>";
                echo "<input type='hidden' name='logout' value='".$_SESSION['userId']."'>";
                echo "<input class='flex-menu-item-top' id='logout' type='submit' name='LogoutSubmit' value='Logout'>";
                echo "</form>";
            }
        ?>
        <li class="flex-menu-item-top"><img src="images/login.png" alt="Login/Sign up nav" onclick="document.getElementById('id01').style.display='block'"/></li>
        <a href="basket.php"><li class="flex-menu-item-top"><img src="images/basket.png" alt="basket nav"/></li></a>
        <a href="basket.php">
            <li class="flex-menu-item-top">
                <div id="circle">
                    <span id="basketNo">
                        <?php
                            global $productCartList;
                            $BasketNo;

                            //Accessing the session if its not empty
                            if(!empty($_SESSION['productCartList'])){
                                //Stoes the session values in a variable
                                $productCartArr = $_SESSION["productCartList"];
                                //Counts up the amounts in the array and stores the fnal value
                                //in basketNo
                                $BasketNo = count($productCartArr);
                                
                            }else{
                                //Results a basket value of 0
                                $BasketNo = 0;
                            }
                            //Shows the number of items in the basket
                            echo $BasketNo;
                        ?>
                    </span>
                </div>
            </li>
        </a>
    </ul>
    <!-- <div class="mobile"> <img src="hamburgerMenu.png" alt="Mobile menu"/> </div> -->
</nav>

<br>
<br>
<br>
<!-- Nav 2 -->
<nav id="nav2">
    <div class = "flex-container wrap">
        <form action='products.php' method='GET'>
            <input type='hidden' name='prodType' value="FV">
            <input type='submit' class="flex-menu-item" name='submit1' value='Fruit & Veg'>
        </form>
        <form action='products.php' method='GET'>
            <input type='hidden' name='prodType' value="MPF">
            <input type='submit' class="flex-menu-item" name='submit2' value='Meat'>
        </form>
        <form action='products.php' method='GET'>
            <input type='hidden' name='prodType' value="BK">
            <input type='submit' class="flex-menu-item" name='submit3' value='Bakery'>
        </form>
        <form action='products.php' method='GET'>
            <input type='hidden' name='prodType' value="D">
            <input type='submit' class="flex-menu-item" name='submit4' value='Drinks'>
        </form>
        <form action='products.php' method='GET'>
            <input type='hidden' name='prodType' value="DE">
            <input type='submit' class="flex-menu-item" name='submit6' value='Dairy & Eggs'>
        </form> 
        <form action='products.php' method='GET'>
            <input type='hidden' name='prodType' value="BD">
            <input type='submit' class="flex-menu-item" name='submit5' value='Bundles'>
        </form>
        
    </div>

    <div class="container-1">
        <form action="searchProducts.php" method="POST">
            <input type="search" id="search" name="searchTerm" placeholder="Search..." />
            <button type="submit" value="submit" class="icon"><i class="fa fa-search"></i> Search </button>
        </form>
    </div>
</nav>

<!-- Modal for user login/registration -->
<div id="id01" class="modal">
    <div class="content">
        <div class="x">
            <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
        </div>
        <form class="modal-content" action="loginUser.php" method="POST">
            <div class="container">
                <br>
                <center>
                    <h2>Login to your Buy Local Account</h2>
                    <img src="images/logo.png" alt="logo" id="loginImg" width="150px"/>
                    <br>
                    <br>
                    <div class="form-group">
                        <label>Username :</label>
                        <input type="text" placeholder="Enter Username" name="uname" class="field" required>
                    </div>
                    <br>
                    <br>
                    <div class="form-group">
                        <label>Password :</label>
                        <input type="password" placeholder="Enter Password" name="password" class="field" required>
                    </div>
                    <br>
                    <br>
                    <button class="button" type="submit">Login</button>
                </center>
            </div>
        </form>
        
        <div class="container">
            <br><center><h3>Or</h3>
        <a href="register.php"><button class="button">Register an Account</button></a></center><br>
        </div>
    </div>
</div>