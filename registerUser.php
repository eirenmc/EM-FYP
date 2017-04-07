<?php
    global $userLoggedIn;

    //Starts/Resumes sessions
    session_start();
    include_once "dbCon.php";

    //Variables with the values entered in the input fields of Registration
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $uname = $_POST["uname"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    //Creating a usersname session
    if(isset($_SESSION["uname"])){
        $_SESSION["uname"] = $uname;
    }else{
        $_SESSION["uname"] = $uname;
    }

     //Checks thats the input fields are not empty
    if((!empty($_POST['uname'])) && (!empty($_POST['password'])) && (!empty($_POST['email'])) && (!empty($_POST['fname']))  && (!empty($_POST['lname']))){
        //Cleans the values entered in the inputs
        $fname = clean_input($_POST['fname']);
        $lname = clean_input($_POST['lname']);
        $uname = clean_input($_POST['uname']);
        $password = clean_input($_POST['password']);
        $email = clean_input($_POST['email']);

        //function call to insert registration details to the database
        insert_reg($fname, $lname, $uname, $password, $email);
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

    // Inserting registration details in the database
    function insert_reg($fname, $lname, $uname, $password, $email){
        global $conn;
        try{
            //Using a prepared statement to insert the values from the input fields into the database
            $stmt = $conn -> prepare('INSERT INTO customers VALUES (:uId, :fName, :lName, :uName, sha1(:uPassword), :uEmail)');
            
            //Binds the database columns with the variables
            $stmt->bindParam(':uId', $id);
            $stmt->bindParam(':fName', $fname);
            $stmt->bindParam(':lName', $lname);
            $stmt->bindParam(':uName', $uname);
            $stmt->bindParam(':uPassword', $password);
            $stmt->bindParam(':uEmail',$email);

            //Making the variables passed in equal to the main variables
            $id = null;
            $fname = $fname;
            $lname = $lname;
            $uname =  $uname;
            $password = $password;
            $email = $email;
            
            //Execute
            $stmt->execute();

        }catch(PDOException $e){
            echo 'ERROR: '.$e -> getMessage();
        }
        //Redirects to the products page
        header("Location: products.php?prodType=FV&submit1=Fruit+%26+Veg");
    }
?>