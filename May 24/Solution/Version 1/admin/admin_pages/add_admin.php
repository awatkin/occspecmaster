<?php
// refactored code to put all the work into one page for adding an admin

session_start();  // connect to session if one has started

require_once '../admin_functs.php';  // include the admin functions
require_once '../../functs.php';  // include the main functions

if (!isset($_SESSION['level'])) {  // if you re not logged in then sent sway

        header("refresh:4; url=../admin_login.php");
        echo "<link rel='stylesheet' href='../admin_styles.css'>";  //
        echo "Not logged in, please log in";

}
elseif ($_SESSION['level']!='SUPER') {  // if you are not a super user, then cant be here

    header("refresh:4; url=admin_login.php");
    echo "<link rel='stylesheet' href='../admin_styles.css'>";
    echo "INSUFFICIENT CLEARANCE, LOGIN or ASK to be registered";

}
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {  // if its a post method
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

        try {

            if(reg_admin($_POST)) { // Assuming $conn is your database connection
                header("Location: admin_index.php");
                exit; // Stop further execution
            } else {
                echo 'error';
            }
        }
        catch(Exception $e) {
            echo "database issue ". $e->getMessage();
        }

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
    echo "<select name='priv'>";
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