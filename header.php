<?php
    session_start();
    
    if(!empty($_SESSION['uname'])){
        $username = $_SESSION['uname'];
        $getUserId = $conn->prepare("SELECT uId FROM customers WHERE uName ='$username'");
        $getUserId->execute();
        $userStored = $getUserId->fetch(PDO::FETCH_ASSOC);
                        
        print_r($userStored['uId']);
        
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
        <li class="flex-menu-item-top">Producers</li>
        <?php 
             if(!empty($_SESSION['uname'])){
                echo "<li class='flex-menu-item-top'>Favourites</li>";
            }
        ?>
    </ul>

    <ul class="flex-container wrap right">
        <b><li class="flex-menu-item-top">
        <?php 
             if(!empty($_SESSION['uname'])){
                $username = $_SESSION['uname']; 
                print_r($username);
            }else{
                echo "Your";
            }
        ?> Account &#9660; </li></b>
        <li class="flex-menu-item-top"><img src="images/login.png" alt="Login/Sign up nav" onclick="document.getElementById('id01').style.display='block'"/></li>
        <a href="basket.php"><li class="flex-menu-item-top"><img src="images/basket.png" alt="basket nav"/></li></a>
    </ul>

    <!-- <div class="mobile"> <img src="hamburgerMenu.png" alt="Mobile menu"/> </div> -->
</nav>

<br>
<br>
<br>

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
                <input type='hidden' name='prodType' value="BD">
                <input type='submit' class="flex-menu-item" name='submit5' value='Bundles'>
            </form>
            <form action='products.php' method='GET'>
                <input type='hidden' name='prodType' value="DE">
                <input type='submit' class="flex-menu-item" name='submit6' value='Dairy & Eggs'>
            </form> 
        </div>

        <div class="container-1">
            <form action="searchProducts.php" method="POST">
                <input type="search" id="search" name="searchTerm" placeholder="Search..." />
                <!--<span class="icon"><input type="submit" name="search" value="Search" id="searchBtn"/><i class="fa fa-search"></i></span>
            -->    <button type="submit" value="submit" class="icon"><i class="fa fa-search"></i> Search </button>
            </form>
        </div>
    </div>
</nav>

<div id="id01" class="modal">
    <div class="content">
        <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
        <form class="modal-content" action="loginUser.php" method="POST">
            <div class="container">
                <br>
                <center><h2>Login to your Buy Local Account</h2>
                <img src="images/logo.png" alt="logo" width="150px"/><br><br>
                <label>Email :</label>
                <input type="text" placeholder="Enter Username" name="uname" class="field" required>
                <br><br>
                <label>Password :</label>
                <input type="password" placeholder="Enter Password" name="password" class="field" required>
                <br><br>
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

<script>

</script>