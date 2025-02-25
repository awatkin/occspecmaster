<?php

// refactored code to put all the work into one page for adding an admin

include '../admin_functs.php';
session_start();

if (!isset($_SESSION['level'])) {
//if ($_SESSION['level']=='EDITOR') {  // checks the admin level of the admin
    header("refresh:4; url=../admin_login.php");  // if they are only an editor, then send them elsewhere
    echo "<link rel='stylesheet' href='../admin_styles.css'>";  //
    echo "Not logged in, please log in";
}
elseif ($_SESSION['level']!='SUPER') {
    header("refresh:4; url=admin_login.php");
    echo "<link rel='stylesheet' href='../admin_styles.css'>";
    echo "INSUFFICIENT CLEARANCE, LOGIN or ASK FOR to be registered";
}
elseif ($_SESSION['level']=='SUPER' && $_SERVER['REQUEST_METHOD'] === 'POST') {

    include '../../functs.php';  // brings in the funct file for common functions
    // used to check correct format of email address

    if ($_POST['priv'] == "SUPER" and super_checker()) {
        header("refresh:4; url=admin_login.php");
        echo "<link rel='stylesheet' href='../admin_styles.css'>";
        echo "Super admin already exists, go login";
    } elseif (!valid_email()) {  // checks for key phrase in email field
        header("refresh:4; url=one_time_admin_reg.php");
        echo "<link rel='stylesheet' href='../admin_styles.css'>";
        echo "Invalid email, try again";
    } elseif (pwrd_checker($_POST['password'], $_POST['cpassword']) == false) {  //calls function to check password complexity
        header("refresh:4; url=one_time_admin_reg.php");
        echo "<link rel='stylesheet' href='../admin_styles.css'>";
        echo "Password related issue, try again";
    } else {
// this code runs if the previous checks are ok

        include '../../dbconnect/db_connect_insert.php';//Used to insert the data into the database, if valid

        try {  //try this code

            $sql = "INSERT INTO admin_users (username, password, email, f_name, s_name, signup_date, privl) VALUES (?, ?, ?, ?, ?, ?, ?)";  //prepare the sql to be sent
            $stmt = $conn->prepare($sql); //prepare to sql

            $stmt->bindParam(1, $_POST['username']);  //bind parameters for security
            $hpswd = password_hash($_POST['password'], PASSWORD_DEFAULT);  //has the password
            $stmt->bindParam(2, $hpswd);
            $stmt->bindParam(3, $_POST['email']);
            $stmt->bindParam(4, $_POST['fname']);
            $stmt->bindParam(5, $_POST['sname']);
            $signup_date = time();
            $stmt->bindParam(6, $signup_date);
            $stmt->bindParam(7, $_POST['priv']);

            $stmt->execute();  //run the query to insert
            $admin_reg_type = strtolower($_POST['priv']) . "reg";
            $admin_reg_task = "Registration of a " . strtolower($_POST['priv']) . " admin user";
            auditor($_POST['username'], $admin_reg_type, $admin_reg_task);

            header("refresh:5; url=admin_login.php"); //confirm and redirect
            echo "<link rel='stylesheet' href='../admin_styles.css'>";
            echo "Successfully registered";
        } catch (PDOException $e) { //catch error
            header("refresh:4; url=one_time_admin_reg.php");
            echo "<link rel='stylesheet' href='../admin_styles.css'>";
            echo "Error: " . $e->getMessage();
            echo "Password related issue, try again";
        }
    }
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


    echo "<form method='post' action='add_admin.php'>";

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