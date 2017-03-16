<!--<nav id="Nav1">
    <img src="images/logo.png" alt="BuyLocal logo"/>
    <ul class="flex-container wrap">
        <li class="flex-menu-item">About</li>
        <li class="flex-menu-item">Producers</li>
        <li class="flex-menu-item">Favourites</li>
        <b><li class="flex-menu-item right">Mary's Account &#9660; </li></b>
        <li class="flex-menu-item right"><img src="images/login.png" alt="Login/Sign up nav"/></li>
        <li class="flex-menu-item right"><img src="images/basket.png" alt="basket nav"/></li>
    </ul>-->
    <!-- <div class="mobile"> <img src="hamburgerMenu.png" alt="Mobile menu"/> </div> -->
<!--</nav>-->
<nav id="Nav1">
    <a href="index.php"><img src="images/logo.png" alt="BuyLocal logo"/></a>
    <ul class="flex-container wrap left">
       <b> <li class="flex-menu-item">About</li>
        <li class="flex-menu-item">Producers</li>
        <li class="flex-menu-item">Favourites</li></b>
    </ul>
    <ul class="flex-container wrap right">
        <b><li class="flex-menu-item">Your Account &#9660; </li></b>
        <li class="flex-menu-item"><img src="images/login.png" alt="Login/Sign up nav" onclick="document.getElementById('id01').style.display='block'"/></li>
        <li class="flex-menu-item"><img src="images/basket.png" alt="basket nav"/></li>
    </ul>
    <!-- <div class="mobile"> <img src="hamburgerMenu.png" alt="Mobile menu"/> </div> -->
</nav>
<br>
<br>
<br>
<nav id="nav2">
    <ul class="flex-container wrap">
       <!-- <a href="fruitAndVeg.php">--><li class="flex-menu-item">Fruit & Veg</li><!--</a>-->
        <li class="flex-menu-item">Meat</li>
        <li class="flex-menu-item">Dairy & Eggs</li>
        <li class="flex-menu-item">Bakery</li>
        <li class="flex-menu-item">Drinks</li>
        <li class="flex-menu-item">Bundles</li> 
        <div class="container-1">
            <input type="search" id="search" placeholder="Search..." />
            <span class="icon"><i class="fa fa-search"></i></span>
        </div>
    </ul>
</nav>

<div id="id01" class="modal">
    <div class="content">
        <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
        <form class="modal-content" action="loginUser.php" method="POST">
            <div class="container">
                <br>
                <center><h2>Login to your Buy Local Account</h2>
                <img src="images/logo.png" alt="logo" width="150px"/><br><br>
                <label>Username :</label>
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