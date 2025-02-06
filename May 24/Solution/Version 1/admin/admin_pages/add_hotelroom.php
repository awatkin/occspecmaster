<?php

session_start();

if ($_SESSION['level']=='EDITOR') {
    header("refresh:4; url=../admin_index.php");
    echo "<link rel='stylesheet' href='../admin_styles.css'>";
    echo "Not high enough admin rights";
}
else {

    echo "<!DOCTYPE html>";

    echo "<html lang='en'>";

    echo "<head>";
    echo "<link rel='stylesheet' href='../admin_styles.css'>";
    echo "<title> RZL Add Hotel Room</title>";
    echo "</head>";

    echo "<body>";

    echo "<div id='container'>";

    echo "<div id='title'>";

    echo "<h3 id='banner'>RZL Add Hotel Room</h3>";

    echo "</div>";

    include '../admin_nav.php';

    echo "<div id='content'>";

    echo "<h4> Add New Hotel Room </h4>";

    echo "<br>";

    echo "<form method='post' action='hotelroom_reg.php'>";

    echo "<input type='text' name='type' placeholder='Hotel Room Type' required><br>";

    echo "<input type='text' name='occupancy' placeholder='occupancy' required><br>";

    echo "<input type='text' name='no_of_rooms' placeholder='Number of Rooms Available' required><br>";

    echo "<input type='text' name='price' placeholder='Price per night' required><br>";

    echo "<input type='submit' name='submit' value='Register'>";

    echo "<br><br>";

    echo "</div>";

    echo "</div>";

    echo "</body>";

    echo "</html>";
}