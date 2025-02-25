<?php

// This page allows an appropriate admin user to create a hotelroom type

session_start();  // connects to the session to pull in session variables


if (!isset($_SESSION['level'])) {
//if ($_SESSION['level']=='EDITOR') {  // checks the admin level of the admin
    header("refresh:4; url=../admin_login.php");  // if they are only an editor, then send them elsewhere
    echo "<link rel='stylesheet' href='../admin_styles.css'>";  //
    echo "Not logged in, please log in";
}
elseif (isset($_SESSION['level']) && $_SESSION['level']=='EDITOR') {
    header("refresh:4; url=../admin_index.php");  // if they are only an editor, then send them elsewhere
    echo "<link rel='stylesheet' href='../admin_styles.css'>";  //
    echo "Not high enough admin rights";
}
elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_SESSION['level']=='SUPER' || $_SESSION['level']=='CREATOR')) {  // if to ensure POST AND appropriate admin level
    include '../../dbconnect/db_connect_insert.php';//Used to insert the data into the database, if valid
    include '../../functs.php';  // includes the core functs page to enable audit logging
    try {  //try this code

        $sql = "INSERT INTO hotel_rooms (type, occupancy, no_of_rooms, price) VALUES (?, ?, ?, ?)";  //prepare the sql to be sent
        $stmt = $conn->prepare($sql); //prepare to sql

        $stmt->bindParam(1,$_POST['type']);  //bind parameters for security
        $stmt->bindParam(2,$_POST['occupancy']);
        $stmt->bindParam(3,$_POST['no_of_rooms']);
        $stmt->bindParam(4,$_POST['price']);

        $stmt->execute();  //run the query to insert

        $admin_reg_task = "Registration of a " . $_POST['type'] . " Hotel Room by ". $_SESSION['username'];
        auditor($_SESSION["username"], "newroom", $admin_reg_task);

        header("refresh:5; url=../admin_index.php"); //confirm and redirect
        echo "<link rel='stylesheet' href='../admin_styles.css'>";
        echo "Successfully registered " . $_POST['type'] . " hotel room type";
    } catch (PDOException $e) { //catch error
        header("refresh:4; url=../admin_login.php");
        echo "<link rel='stylesheet' href='../admin_styles.css'>";
        echo "Error: " . $e->getMessage();
        echo "Failed to add new hotel room";
    }
}

else {  // if its any other type of admin, then allows adding

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

    include '../admin_nav.php';  // includes the standard admin nav bar

    echo "<div id='content'>";

    echo "<h4> Add New Hotel Room </h4>";

    echo "<br>";

    echo "<form method='post' action='add_hotelroom.php'>";  // method post is important

    echo "<input type='text' name='type' placeholder='Hotel Room Type' required><br>";  // collects the type of room

    echo "<input type='text' name='occupancy' placeholder='occupancy' required><br>";  // this is how many people can stay in that room

    echo "<input type='text' name='no_of_rooms' placeholder='Number of Rooms Available' required><br>";  // this is the number of those types of room

    echo "<input type='text' name='price' placeholder='Price per night' required><br>"; // this is the price of the room type per night.

    echo "<input type='submit' name='submit' value='Register'>";

    echo "<br><br>";

    echo "</div>";

    echo "</div>";

    echo "</body>";

    echo "</html>";
}