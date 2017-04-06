<?php 
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

        <script>
            function showDiet(str) {
                if(str == "") {
                    document.getElementById("txtHint").innerHTML = "";
                    return;
                } else { 
                    if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                    } else {
                        // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("txtHint").innerHTML = this.responseText;
                        }
                    };
                    xmlhttp.open("GET","testfilter.php?d="+str,true);
                    xmlhttp.send();
                }
            }

            function showRating(str) {
                if(str == "") {
                    document.getElementById("txtHint").innerHTML = "";
                    return;
                } else { 
                    if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                    } else {
                        // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("txtHint").innerHTML = this.responseText;
                        }
                    };
                    xmlhttp.open("GET","testfilter.php?r="+str,true);
                    xmlhttp.send();
                }
            }
        </script>
</head>
<body>
  <div class="flex-container-filter">
        <div class="flex-item">
            <div class="titleBar">
                <h2>Filter By :</h2>
            </div>
            <div class="dietFilter">
                <h3>Dietary Requirements</h3>
                <form>
                    <span class="filterCheckbox">
                        <input type="radio" value="N" name="diet" onchange="showDiet(this.value)">Nut Free
                    </span> 
                    <br>
                    <span class="filterCheckbox">
                        <input type="radio" value="O" name="diet" onchange="showDiet(this.value)">Organic
                    </span>
                    <br>         
                    <span class="filterCheckbox">
                        <input type="radio" value="G" name="diet" onchange="showDiet(this.value)">Gluten Free
                    </span>
                    <br>
                    <span class="filterCheckbox">
                        <input type="radio" value="L" name="diet" onchange="showDiet(this.value)">Lactose Intolerant
                    </span>
                </form>
            </div>
            <div class="ratingFilter">
                <h3>Rating</h3>
                <input type="radio" name="diet" value="1" onchange="showRating(this.value)">
                <span class='rating five'>
                <span class='scoredRating'>☆</span>
                </span>
                <br>
                <input type="radio" name="diet" value="2" onchange="showRating(this.value)">
                <span class='rating five'>
                    <span class='scoredRating'>☆</span><span class='scoredRating'>☆</span>
                </span>
                <br>
                <input type="radio" name="diet" value="3" onchange="showRating(this.value)">
                <span class='rating five'>
                    <span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span class='scoredRating'>☆</span>
                </span>
                <br>
                <input type="radio" name="diet" value="4" onchange="showRating(this.value)">
                <span class='rating five'>
                    <span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span class='scoredRating'>☆</span>
                </span>
                <br>
                <input type="radio" name="diet" value="5" onchange="showRating(this.value)">
                <span class='rating five'>
                <span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span class='scoredRating'>☆</span><span class='scoredRating'>☆</span>
                </span>
            </div>
        </div>
    </div>
<!--
<form>
<select name="users" onchange="showUser(this.value)">
  <option value="">Select a person:</option>
  <option value="1">Product 1</option>
  <option value="2">Product 2</option>
  <option value="3">Product 3</option>
  <option value="4">Product 4</option>
  </select>
</form>-->
                <?php
                  /*  global $conn;
                    try{
                        $insertProducts = $conn->prepare("SELECT * FROM products LIMIT 10");
                        $insertProducts->execute();
                        $products = $insertProducts->fetchAll(PDO::FETCH_ASSOC);
                        
                        for($i=0; $i<count($products); $i++){
                            echo "<div class='productBox'>";
                            $row = $products[$i];
                            echo "<b>".$row['pName']."</b><br>";
                            echo "<img src='./images/".$row['pImage'].".jpg' alt='product'/><br>";
                            echo "<b class='alignPrice'> Price: </b> €".$row['pPrice'];
                            echo "</div>";
                        }
                    }catch(PDOException $e){
                        echo 'ERROR: '.$e -> getMessage();
                    }
*/
                ?>
<br><!--
<div id="txtHint"><b>Person info will be listed here...</b></div>-->

<div id="txtHint">
<?php
    global $conn;
    try{
        $insertProducts = $conn->prepare("SELECT * FROM products LIMIT 10");
        $insertProducts->execute();
        $products = $insertProducts->fetchAll(PDO::FETCH_ASSOC);
        
        for($i=0; $i<count($products); $i++){
            echo "<div class='productBox'>";
            $row = $products[$i];
            echo "<b>".$row['pName']."</b><br>";
            echo "<img src='./images/".$row['pImage'].".jpg' alt='product'/><br>";
            echo "<b class='alignPrice'> Price: </b> €".$row['pPrice'];
            echo "</div>";
        }
    }catch(PDOException $e){
        echo 'ERROR: '.$e -> getMessage();
    }

?>
</div>

</body>
</html>