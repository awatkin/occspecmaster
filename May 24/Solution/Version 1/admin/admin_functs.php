<?php

include '../functs.php';
function reg_admin($username, $password, $email, $fname, $sname, $priv) {
    include '../dbconnect/db_connect_insert.php';//Used to insert the data into the database, if valid

    $sql = "INSERT INTO admin_users (username, password, email, f_name, s_name, signup_date, privl) VALUES (?, ?, ?, ?, ?, ?, ?)";  //prepare the sql to be sent
    $stmt = $conn->prepare($sql); //prepare to sql

    $stmt->bindParam(1, $username);  //bind parameters for security
    $hpswd = password_hash($password, PASSWORD_DEFAULT);  //has the password
    $stmt->bindParam(2, $hpswd);
    $stmt->bindParam(3, $email);
    $stmt->bindParam(4, $fname);
    $stmt->bindParam(5, $sname);
    $signup_date = time();
    $stmt->bindParam(6, $signup_date);
    $stmt->bindParam(7, $priv);

    $stmt->execute();  //run the query to insert
    $admin_reg_type = strtolower($priv) . "reg";
    $admin_reg_task = "Registration of a " . strtolower($priv) . " admin user";
    auditor($username, $admin_reg_type, $admin_reg_task);

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
        //header("refresh:4; url=one_time_admin_reg.php");
        echo "<link rel='stylesheet' href='admin_styles.css'>";
        echo "Error: " . $e->getMessage();
        echo "Password related issue, try again";
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
