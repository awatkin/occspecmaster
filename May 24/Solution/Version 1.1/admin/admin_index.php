<?php

session_start();

require_once 'admin_functions.php';

require_once '../dbconnect/db_connect_master.php';

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

echo admin_error($_SESSION);

echo "<form method='post' action='admin_validate.php'>";

echo "<input type='text' name='username' placeholder='Username' required><br>";

echo "<input type='password' name='password' placeholder='Password' required><br>";

echo "<input type='submit' name='submit' value='Login'>";

echo "<br><br>";

echo "</div>";

echo "</div>";

echo "</body>";

echo "</html>";