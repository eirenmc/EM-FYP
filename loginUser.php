<?php
    //Starts/Resumes sessions
   // session_start();
?>

<?php    
    //Variables with the values entered in the input fields of Login
    $email = $_POST["uname"];
    $password = $_POST["password"];

    //Checks thats the input fields are not empty
    if((!empty($_POST['uname'])) && (!empty($_POST['password']))){
        
        //Cleans the values entered in the inputs
        $uname = clean_input($_POST['uname']);
        $password = clean_input($_POST['password']);

        //Creating a usersname session
      //  $_session["uname"] = $uname;

        //function call to check login details to see do they match up with the users table in the database
        check_login($uname, $password);        
    }else{
        $uname = NULL;
        $password = NULL;
    }

    //Function that cleans data and strips out tags and code so inputs can't be code
    function clean_input($data){
        $data = strip_tags($data);
        $data = trim($data);
        $data = htmlentities($data);
        $data = htmlspecialchars($data);
        $data = strIpslashes($data);

        return $data;
    }

    // Checks login details to make sure they match with an entry in the database
    function check_login($uname, $password){
        try{
            //Connecting to the database
            $conn = new PDO();
            $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //Using a prepared statement to select the email and passwords in the databases so they can be cross-referenced
            $checkUNameData = $conn->prepare("SELECT email FROM customers");
            $checkPasswordData = $conn->prepare("SELECT uPassword FROM customers");

            //Executes  
            $checkUNameData->execute();
            $checkPasswordData->execute();

            //Makes the password a sha1 type password
            $password = sha1($password);
            $userLoggedIn;

            //Loops through the database and gets the username and password and checks it against the database
            while(($userDB = $checkUNameData->fetch(PDO::FETCH_ASSOC)) && ($passwordDB = $checkPasswordData->fetch(PDO::FETCH_ASSOC))){               
                //If the email and password match up with the database, the page redirects to the products page
                if($uname == $userDB['uName']  && $password == $passwordDB['uPassword']){
                   $userLoggedIn = true;
                }else{
                    echo "Hello";
                }
            }

            if($userLoggedIn == true){
                header('Location: fruitAndVeg.php'); 
            }
        }catch(PDOException $e){
           // echo 'ERROR: '.$e -> getMessage();
        } 
    }
?>