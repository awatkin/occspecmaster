<?php

session_start();  // connects to the session to pull through the session variables

if ($_SESSION['level']=='EDITOR') {  // if you are only an editor, you cant be here.
    header("refresh:4; url=../admin_index.php");
    echo "<link rel='stylesheet' href='../admin_styles.css'>";
    echo "Not high enough admin rights";
}
else {

    echo "<!DOCTYPE html>";

    echo "<html lang='en'>";

    echo "<head>";
    echo "<link rel='stylesheet' href='../admin_styles.css'>";
    echo "<title> RZL Add User Type</title>";
    echo "</head>";

    echo "<body>";

    echo "<div id='container'>";

    echo "<div id='title'>";

    echo "<h3 id='banner'>RZL Add User Type</h3>";

    echo "</div>";

    include '../admin_nav.php';

    echo "<div id='content'>";

    echo "<h4> Add New User Type </h4>";

    echo "<br>";

    echo "<form method='post' action='user_reg.php'>";

    echo "<input type='text' name='type' placeholder='Ticket Type' required><br>";

    echo "<input type='text' name='discount' placeholder='Discount as a decimal' required><br>";

    echo "<input type='submit' name='submit' value='Register'>";

    echo "<br><br>";

    echo "</div>";

    echo "</div>";

    echo "</body>";

    echo "</html>";
}