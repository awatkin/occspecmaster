<?php


function reg_admin($post) {
    require_once '../dbconnect/db_connect_insert.php';//Used to insert the data into the database, if valid
    require_once '../functs.php';
    try {
        // Validate the post data
        if (!isset($post['username'], $post['password'], $post['fname'], $post['sname'], $post['email'], $post['priv'])) {
            throw new Exception("Missing required fields.");
        }

        // Prepare and execute the SQL query
        $sql = "INSERT INTO admin_users (username, password, email, f_name, s_name, signup_date, privl) VALUES (?, ?, ?, ?, ?, ?, ?)";  //prepare the sql to be sent
        $stmt = $conn->prepare($sql); //prepare to sql

        $stmt->bindParam(1, $post['username']);  //bind parameters for security
        // Hash the password
        $hpswd = password_hash($post['password'], PASSWORD_DEFAULT);  //has the password
        $stmt->bindParam(2, $hpswd);
        $stmt->bindParam(3, $post['email']);
        $stmt->bindParam(4, $post['fname']);
        $stmt->bindParam(5, $post['sname']);
        $signup_date = time();
        $stmt->bindParam(6, $signup_date);
        $stmt->bindParam(7, $post['priv']);

        $stmt->execute();  //run the query to insert
        $conn = null;  // closes the connection so cant be abused.
        return true; // Registration successful

    } catch (PDOException $e) {
        // Handle database errors
        error_log("Database error: " . $e->getMessage()); // Log the error
        throw new Exception("Database error occurred. Please try again later."); //Throw exception for calling script to handle.
    } catch (Exception $e) {
        // Handle validation or other errors
        error_log("Registration error: " . $e->getMessage()); //Log the error
        throw new Exception($e->getMessage()); //Throw exception for calling script to handle.
    }
}
function super_checker(){
    try {
        include '../dbconnect/db_connect_select.php';//gets the select user details to check if admin exists or not
        $sql = "SELECT * FROM admin_users"; //set up the sql statement
        $stmt = $conn->prepare($sql); //prepares
        $stmt->execute(); //run the sql code
        $result = $stmt->fetch(PDO::FETCH_ASSOC);  //brings back results
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    catch (PDOException $e) { //catch error
        echo "Error: " . $e->getMessage();

    }
}

function valid_email(){
    $phrase = "@rzl.com";
    if(strpos($_POST['email'], $phrase) == false){
        return false;
    } else {
        return true;
    }
}

function admin_sesh_started(){
    if(isset($_SESSION["admin_ssnlogin"])){  // checks to see if the user is logged in or not already
        return true;  // if they are, returns true
    }
    else {
        return false;
    }
}