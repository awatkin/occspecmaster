<?php

session_start();  // connects to any session that might have started

include 'admin_functs.php';  // includes the core admin reusable functions file

if (admin_sesh_started()) {  // checks to see if admin user is already logged in
    header("location:admin_index.php");  // sends them to the admin index page if they are already logged in
}

else {

echo "<!DOCTYPE html>";

echo "<html lang='en'>";

echo "<head>";

echo "<link rel='stylesheet' href='admin_styles.css'>";

echo "<title> RZL Admin Login</title>";

echo "</head>";

echo "<body>";

echo "<div id='list container'>";

echo "<div id='title'>";

echo "<h3 id='banner'>RZL Admin System</h3>";

echo "</div>";

echo "<div id='content'>";

echo "<h4> Admin Login</h4>";

echo "<br>";

echo "<form method='post' action='admin_validate.php'>";

echo "<input type='text' name='username' placeholder='Username' required><br>";

echo "<input type='password' name='password' placeholder='Password' required><br>";

echo "<input type='submit' name='submit' value='Login'>";

echo "<br><br>";

echo "</div>";

echo "</div>";

echo "</body>";

echo "</html>";

}

