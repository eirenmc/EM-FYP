<?php
    session_start();    
    include_once "dbCon.php";
   
    if(!empty($_SESSION['uname'])){
        $username = $_SESSION['uname'];
        $getUserId = $conn->prepare("SELECT uId FROM customers WHERE uName ='$username'");
        $getUserId->execute();
        $userStored = $getUserId->fetch(PDO::FETCH_ASSOC);
                        
        //print_r($userStored['uId']);
        
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
             if(!empty($_SESSION['uname'])){
                echo "<a href='favourites.php'><li class='flex-menu-item-top'>Favourites</li></a>";                
            }
        ?>
    </ul>

    <ul class="flex-container wrap right">
        <b><li class="flex-menu-item-top dropdown" onclick="document.getElementById('id01').style.display='block'">
        <?php 
            //Switches the variable and assign it the value of the session
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
                        <label>Email :</label>
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
<!--
    <div class="container" style="background-color:#f1f1f1">
      <span class="psw">Forgot <a href="#">password?</a></span>
    </div>-->
  
</div>