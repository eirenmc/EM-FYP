<?php
    global $userLoggedIn;

    //Starts/Resumes sessions
    session_start();
    
    include_once "dbCon.php";
   // var_dump($conn);
    
    //Variables with the values entered in the input fields of Login
    $uname = $_POST["uname"];
    $password = $_POST["password"];

    //Creating a usersname session
    if(isset($_SESSION["uname"])){
        $_SESSION["uname"] = $uname;
    }else{
        $_SESSION["uname"] = $uname;
    }

    //Checks thats the input fields are not empty
    if((!empty($_POST['uname'])) && (!empty($_POST['password']))){
        
        //Cleans the values entered in the inputs
        $uname = clean_input($_POST['uname']);
        $password = clean_input($_POST['password']);
        
       
       /* echo "Im checking that your not empty";
        var_dump($conn);*/
       //function call to check login details to see do they match up with the users table in the database
        check_login($uname, $password);
        // var_dump($conn);       
    }else{
        $uname = NULL;
        $password = NULL;
       // echo "Im making you null";
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
        global $conn;
       /* echo "checking login before accessing DB";
        var_dump($conn);*/
        try{
           /* echo "trying";
            var_dump($conn);*/
            //Using a prepared statement to select the email and passwords in the databases so they can be cross-referenced
            $checkUnameData = $conn->prepare("SELECT * FROM customers");
            $checkPasswordData = $conn->prepare("SELECT uPassword FROM customers");
           
           // echo "Trying to prepare DB";
            //Executes  
            $checkUnameData->execute();
            $checkPasswordData->execute();

            //Makes the password a sha1 type password
            $password = sha1($password);
            
            //Loops through the database and gets the email and password and checks it against the database
            while(($userDB = $checkUnameData->fetch(PDO::FETCH_ASSOC)) && ($passwordDB = $checkPasswordData->fetch(PDO::FETCH_ASSOC))){
               /* echo "Whiling ";
                var_dump($uname);
                var_dump($password);*/
                
                //If the username and password match up with the database, the page redirects to the products page
                if(($uname == $userDB['uName']) && ($password == $passwordDB['uPassword'])){
                   // echo "Confirming login";
                  // header("Location: index.php");
                  echo '<a href="'. $_SERVER['HTTP_REFERER'] . '">Go back</a>';
 
                }
            }
        }catch(PDOException $e){
            echo 'ERROR: '.$e -> getMessage();
        } 
    }
?>