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

        <style>
            table {
                width: 100%;
                border-collapse: collapse;
            }

            table, td, th {
                border: 1px solid black;
                padding: 5px;
            }

            th {text-align: left;}
        </style>
    </head>
    <body>

<?php
    $q = intval($_GET['q']);
    if(!empty($_GET['q'])){
        echo "Not emplty";            
        global $conn;
        echo "<br>".$q;
        try{
            
            $filter = $conn->prepare("SELECT * FROM products WHERE pId = '".$q."'");
            $filter->execute();
            $filterProduct = $filter->fetchAll(PDO::FETCH_BOTH);

            echo "<table> 
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Image</th>
                    </tr>";
            for($i=0; $i < count($filterProduct); $i++){
                echo "Looping";
                $row = $filterProduct[$i];   
           //while($row = $filterProduct->fetchAll(PDO::FETCH_BOTH)) {
                echo "<tr>";
                echo "<td>".$row['pName']."</td>";
                echo "<td>".$row['pPrice']."</td>";
                echo "<td>".$row['pImage']."</td>";
                echo "</tr>";
            }


           /* $products = $insertProducts->fetchAll(PDO::FETCH_ASSOC);
                        
                        //Loops through all the products and displays the image, name, price and ass to cart button
                        for($i=0; $i < count($products); $i++){
                            echo "<div class='productBox'>";
                            $row = $products[$i];
                            echo "<center><b>".$row['pName']."</b><br>";
                            echo "<img src='./images/".$row['pImage'].".jpg' alt='product'/></br>";
                            echo "</center>";*/


            echo "</table>";
            //mysqli_close($con);

        }catch(PDOException $e){
            echo 'ERROR: ' . $e->getMessage();
        }
    }

?>
</body>
</html>