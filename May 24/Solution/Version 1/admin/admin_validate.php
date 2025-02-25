<?php
session_start();  //connect to session data for logged in

try {  //try this code, catch errors

    require_once '../dbconnect/db_connect_select.php';
    $usnm = $_POST['username']; //copy username from post data
    $sql = "SELECT password, privl FROM admin_users WHERE username = ?"; //set up the sql statement
    $stmt = $conn->prepare($sql); //prepares
    $stmt->bindParam(1,$_POST['username']);  //binds the parameters to execute
    $stmt->execute(); //run the sql code
    $result = $stmt->fetch(PDO::FETCH_ASSOC);  //brings back results

    if($result){  // if there is a result returned

        if (password_verify($_POST["password"], $result["password"])) { // verifies the password is matched
            $_SESSION["admin_ssnlogin"] = true;  // sets up the session variables
            $_SESSION["username"] = $_POST['username'];
            $_SESSION["level"] = $result["privl"];
            header("location:admin_index.php");  //redirect on success
            exit();

        } else{
            session_destroy(); //if failed, kills session and error message
            header("refresh:4; url=admin_login.php");
            echo "<link rel='stylesheet' href='admin_styles.css'>";
            echo "invalid password";
        }

    } else {
        header("refresh:4; url=admin_login.php");
        echo "<link rel='stylesheet' href='admin_styles.css'>";
        echo "User not found";

    }

} catch (Exception $e) {
    echo $e;
}