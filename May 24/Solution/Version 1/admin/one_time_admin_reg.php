<?php

//Code to product a one time reg page for admin users

//session_start(); // trys to connect with user session

//checks to see if user exists, then proceeds


try {  //try this code, catch errors

include 'admin_functs.php';

    if (super_checker()) {  // calls function in admin_functs to check if ssuper user exists.

        header("refresh:4; url=admin_login.php");
        echo "<link rel='stylesheet' href='admin_styles.css'>";
        echo "ADMIN ALREADY EXISTS, LOGIN or ASK FOR to be registered";

    } else {

        echo "<!DOCTYPE html>";

        echo "<html lang='en'>";

        echo "<head>";

        echo "<link rel='stylesheet' href='admin_styles.css'>";

        echo "<title> RZL One Time Admin Registration</title>";

        echo "</head>";

        echo "<body>";

        echo "<div id='container'>";

        echo "<div id='title'>";

        echo "<h3 id='banner'>RZL Admin one time registration</h3>";

        echo "</div>";

        echo "<div id='navbar'>";

        echo "<ul id='menu'>";


        echo "<div id='content'>";

        echo "<h4> This is a one time registration for RZL system</h4>";

        echo "<br>";

        echo "<form method='post' action='adminreg.php'>";

        echo "<input type='text' name='username' placeholder='Username' required><br>";

        echo "<input type='password' name='password' placeholder='Password' required><br>";

        echo "<input type='password' name='cpassword' placeholder='Confirm Password' required><br>";

        echo "<input type='text' name='fname' placeholder='First Name' required><br>";

        echo "<input type='text' name='sname' placeholder='Surname' required><br>";

        echo "<input type='text' name='email' placeholder='Email' required><br>";

        echo "<input type='hidden' name='priv' value='SUPER'><br>";

        echo "<input type='submit' name='submit' value='Register'>";

        echo "<br><br>";

        echo "</div>";

        echo "</div>";

        echo "</body>";

        echo "</html>";

    }
} catch(PDOException $e) {


    //header("refresh:4; url=admin_login.php");
    echo "<link rel='stylesheet' href='admin_styles.css'>";
    echo "ERROR: " . $e->getMessage();
}

?>