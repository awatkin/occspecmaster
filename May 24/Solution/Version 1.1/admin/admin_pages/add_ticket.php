<?php

require_once '../../dbconnect/db_connect_master.php';//Used to insert the data into the database, if valid
require_once '../../common_functions.php';

session_start();  // connects to the session to pull through the session variables

if (!isset($_SESSION['admin_ssnlogin']) || $_SESSION['priv']='EDITOR'){  // checks for logged in OR if they are only an editor
    $_SESSION['ERROR'] = "Admin not logged in / not enough privileges.";  //sets error message
    header("Location: ../admin_login.php");  // redirects them to another place
    exit; // Stop further execution
}

elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_SESSION['priv']=='SUPER' || $_SESSION['priv']=='CREATOR')) {  // if to ensure POST AND appropriate admin level
    try {  //try this code

        if(add_ticket(dbconnect_insert(), $_POST))
//        $conn = dbconnect_insert();
//        $sql = "INSERT INTO tickets (type, price, no_of_tickets) VALUES (?, ?, ?)";  //prepare the sql to be sent
//        $stmt = $conn->prepare($sql); //prepare to sql
//
//        $stmt->bindParam(1,$_POST['type']);  //bind parameters for security
//        $stmt->bindParam(2,$_POST['price']);
//        $stmt->bindParam(3,$_POST['no_of_tickets']);
//
//        $stmt->execute();  //run the query to insert
        $conn = dbconnect_insert();
        $admin_reg_task = "Registration of a " . $_POST['type'] . " ticket type by ". $_SESSION['username'];
        auditor($_SESSION["username"], "newticket", $admin_reg_task);

        header("refresh:5; url=../admin_index.php"); //confirm and redirect
        echo "<link rel='stylesheet' href='../admin_styles.css'>";
        echo "Successfully registered " . $_POST['type'] . " ticket type";
    } catch (PDOException $e) { //catch error
        header("refresh:4; url=../admin_login.php");
        echo "<link rel='stylesheet' href='../admin_styles.css'>";
        echo "Error: " . $e->getMessage();
        echo "Failed to add new ticket type";
    }
}

else {

    echo "<!DOCTYPE html>";

    echo "<html lang='en'>";

    echo "<head>";
    echo "<link rel='stylesheet' href='../admin_styles.css'>";
    echo "<title> RZL Add Ticket</title>";
    echo "</head>";

    echo "<body>";

    echo "<div id='container'>";

    echo "<div id='title'>";

    echo "<h3 id='banner'>RZL Add Ticket</h3>";

    echo "</div>";

    include '../admin_nav.php';  // includes the needed nav bar

    echo "<div id='content'>";

    echo "<h4> Add New Ticket </h4>";

    echo "<br>";

    echo "<form method='post' action='add_ticket.php'>";  //post method is important to send the info to the ticket reg page

    echo "<input type='text' name='type' placeholder='Ticket Type' required><br>";

    echo "<input type='text' name='price' placeholder='Price per ticket' required><br>";

    echo "<input type='text' name='no_of_tickets' placeholder='Number of tickets available' required><br>";

    echo "<input type='submit' name='submit' value='Register'>";

    echo "<br><br>";

    echo "</div>";

    echo "</div>";

    echo "</body>";

    echo "</html>";
}