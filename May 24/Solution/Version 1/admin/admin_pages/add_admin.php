<?php

include '../admin_functs.php';
session_start();

if ($_SESSION['level']!='SUPER') {
    header("refresh:4; url=admin_login.php");
    echo "<link rel='stylesheet' href='../admin_styles.css'>";
    echo "ADMIN ALREADY EXISTS, LOGIN or ASK FOR to be registered";
}
else {

    echo "<!DOCTYPE html>";

    echo "<html lang='en'>";

    echo "<head>";
    echo "<link rel='stylesheet' href='../admin_styles.css'>";
    echo "<title> RZL Add Admin Page</title>";
    echo "</head>";

    echo "<body>";

    echo "<div id='container'>";

    echo "<div id='title'>";

    echo "<h3 id='banner'>RZL Add Admin</h3>";

    echo "</div>";

    include '../admin_nav.php';

    echo "<div id='content'>";

    echo "<h4> Add New Admin </h4>";

    echo "<br>";


    echo "<form method='post' action='../adminreg.php'>";

    echo "<input type='text' name='username' placeholder='Username' required><br>";

    echo "<input type='password' name='password' placeholder='Password' required><br>";

    echo "<input type='password' name='cpassword' placeholder='Confirm Password' required><br>";

    echo "<input type='text' name='fname' placeholder='First Name' required><br>";

    echo "<input type='text' name='sname' placeholder='Surname' required><br>";

    echo "<input type='text' name='email' placeholder='Email' required><br>";

    echo "<label for='user-role'>Select User Role:</label>";
    echo "<select id='priv' name='priv'>";
    echo "<option value='CREATOR'>Creator</option>";
    echo "<option value='EDITOR'>Editor</option>";
    echo "</select><br>";

    echo "<input type='submit' name='submit' value='Register'>";

    echo "<br><br>";

    echo "</div>";

    echo "</div>";

    echo "</body>";

    echo "</html>";
}