<?php 
   session_start();
   include_once "dbCon.php";
?>

<!DOCTYPE html>
    <head>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="styles.css"/>

         <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyChOK4lKW97Kwc9e9Dy7EdwZudOHWnbtN8&callback=initMap"
  type="text/javascript"></script>

        <meta charset="UTF-8">
        <meta name="description" content="Online eccomerce site of local producers">
        <meta name="keywords" content="Local Producers,eccommerce,local,buy,online,shopping">
        <meta name="author" content="Eiren McLoughlin">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body onload="initialize()">
        <?php include "header.php" ?>
        <br>
        <br>

        <div class="flex-container-producer">
            <div class="flex-item-producer">
                <?php

                    if(isset($_SESSION["userId"])){
                        $uId = $_SESSION["userId"];
                    }

                    try{ 
                        $insertProducers = $conn->prepare("SELECT * FROM producers");

                        //Execute
                        $insertProducers->execute();

                        //fetches all the products from the database
                        $producer = $insertProducers->fetchAll(PDO::FETCH_ASSOC);
                        
                        //Loops through all the products and displays the image, name, price and ass to cart button
                        for($i=0; $i < count($producer); $i++){
                            $row = $producer[$i];
                            echo "<div class='producerBox'>";
                            echo "<img src='./images/".$row['producerImage'].".jpg' alt='producer'/></br>";
                            echo "<center><b>".$row['producerName']."</b><br>";
                            echo "</center>";  
                            echo "<form action='producerDetail.php' method='GET'>
                            <input type='hidden'  name='producerViewId' value='".$row['producerId']."'>
                            <input class='btn2 ".$row['producerId']."' type='submit' value='View Producer'></form></div>";
                            
                            $currentPId = $row['pId'];
                        }
                    }catch(PDOException $e){
                        echo 'ERROR: '.$e -> getMessage();
                    }
                ?>
                
            </div>
        </div>
        <br>
       <!-- <iframe src="https://www.google.com/maps/d/embed?mid=1Cxlpp8xZ6U-ZvufNIRdYODxYyH8" width="640" height="480"></iframe>
        -->

        <div id="map"></div>
        <script type="text/javascript">
            
            var locations = [
                ['Baxter', 52.34712, -7.41566, 'Dairy Fairy is the place for all your dairy needs, we make yogurt, produce milk and more. Contact Us: 6789012'],
                ['Nesa Bakery', 52.37622, -7.92086, 'address 2'],
                ['Dairy Fairy', 52.67786, -7.81462, 'address 5']
            ];

            function initialize() {
                var myOptions = {
                    center: new google.maps.LatLng(33.890542, 151.274856),
                    zoom: 8,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
            
                var map = new google.maps.Map(document.getElementById("default"), myOptions);
                setMarkers(map,locations)
            }

            function setMarkers(map,locations){
                var marker, i
                for (i = 0; i < locations.length; i++)
                {  
                    var producer = locations[i][0]
                    var lat = locations[i][1]
                    var long = locations[i][2]
                    var add =  locations[i][3]

                    latlngset = new google.maps.LatLng(lat, long);

                    var marker = new google.maps.Marker({
                        map: map, 
                        title: producer, 
                        position: latlngset});
                    
                    map.setCenter(marker.getPosition())
                    
                    var content = "<h1> " + producer +  '</h1>' + "Address: " + add     
                    var infowindow = new google.maps.InfoWindow()

                    google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){ 
                            return function() {
                            infowindow.setContent(content);
                            infowindow.open(map,marker);
                            };
                        })(marker,content,infowindow)); 
                }
            }

        </script>
        </body>