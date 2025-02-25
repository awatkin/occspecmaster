<?php

session_start();  // connects to the session to pull through the session variables

if (!isset($_SESSION['level'])) {
    header("refresh:4; url=../admin_login.php");  // if they are only an editor, then send them elsewhere
    echo "<link rel='stylesheet' href='../admin_styles.css'>";  //
    echo "Not logged in, please log in";
}

elseif ($_SESSION['level']=='EDITOR') {  // if you are only an editor, you cant be here.
    header("refresh:4; url=../admin_index.php");
    echo "<link rel='stylesheet' href='../admin_styles.css'>";
    echo "Not high enough admin rights";
}

elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_SESSION['level']=='SUPER' || $_SESSION['level']=='CREATOR')) {  // if to ensure POST AND appropriate admin level
    include '../../dbconnect/db_connect_insert.php';//Used to insert the data into the database, if valid
    include '../../functs.php';
    try {  //try this code

        $sql = "INSERT INTO user_type (type, discount) VALUES (?, ?)";  //prepare the sql to be sent
        $stmt = $conn->prepare($sql); //prepare to sql

        $stmt->bindParam(1,$_POST['type']);  //bind parameters for security
        $stmt->bindParam(2,$_POST['discount']);

        $stmt->execute();  //run the query to insert

        $admin_reg_task = "Registration of a " . $_POST['type'] . " user type by ". $_SESSION['username'];
        auditor($_SESSION["username"], "newuser", $admin_reg_task);

        header("refresh:5; url=../admin_index.php"); //confirm and redirect
        echo "<link rel='stylesheet' href='../admin_styles.css'>";
        echo "Successfully registered " . $_POST['type'] . " user type";
    } catch (PDOException $e) { //catch error
        header("refresh:4; url=../admin_login.php");
        echo "<link rel='stylesheet' href='../admin_styles.css'>";
        echo "Error: " . $e->getMessage();
        echo "Failed to add new user type";
    }
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

    echo "<form method='post' action='add_usertype.php'>";

    echo "<input type='text' name='type' placeholder='Ticket Type' required><br>";

    echo "<input type='text' name='discount' placeholder='Discount as a decimal' required><br>";

    echo "<input type='submit' name='submit' value='Register'>";

    echo "<br><br>";

    echo "</div>";

    echo "</div>";

    echo "</body>";

    echo "</html>";
}