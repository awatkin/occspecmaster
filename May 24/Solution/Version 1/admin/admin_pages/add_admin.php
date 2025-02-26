<?php
// refactored code to put all the work into one page for adding an admin

session_start();  // connect to session if one has started

include '../admin_functs.php';  // include the admin functions
include '../../functs.php';  // include the main functions

if (!isset($_SESSION['level'])) {

        header("refresh:4; url=../admin_login.php");  // if they are only an editor, then send them elsewhere
        echo "<link rel='stylesheet' href='../admin_styles.css'>";  //
        echo "Not logged in, please log in";

}
elseif ($_SESSION['level']!='SUPER') {

    header("refresh:4; url=admin_login.php");
    echo "<link rel='stylesheet' href='../admin_styles.css'>";
    echo "INSUFFICIENT CLEARANCE, LOGIN or ASK FOR to be registered";

}
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

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
    } elseif (!pwrd_checker($_POST['password'], $_POST['cpassword'])) {  //calls function to check password complexity
        header("refresh:4; url=one_time_admin_reg.php");
        echo "<link rel='stylesheet' href='../admin_styles.css'>";
        echo "Password related issue, try again";
    } else {
// this code runs if the previous checks are ok
        reg_admin($_POST['username'], $_POST['password'],$_POST['email'],$_POST['fname'], $_POST['sname'],$_POST['priv']);

    }
}
else {

    echo "<!DOCTYPE html>";

    echo "<html lang='en'>";

    echo "<head>";
    echo "<title> RZL Add Admin Page</title>";
    echo "<link rel='stylesheet' href='../admin_styles.css'>";
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