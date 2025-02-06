<?php

session_start();

if ($_SESSION['level']=='EDITOR') {
    header("refresh:4; url=admin_login.php");
    echo "<link rel='stylesheet' href='../admin_styles.css'>";
    echo "Not high enough admin rights";
}
else {
    include '../../dbconnect/db_connect_insert.php';//Used to insert the data into the database, if valid
    include '../../functs.php';
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
