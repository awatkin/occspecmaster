<?php


$servername = "localhost";  //sets servername

$dbusername = "rzlupdate";  // had to change this variable name as it fought against the admin reg and user reg

$password = "rzlupdate";  //password for database useraccount

$dbname = "zoouser";  //database name to connect to

try {  //attempt this block of code, catching an error
    $conn = new PDO("mysql:host=$servername;port=3306;dbname=$dbname", $dbusername, $password);  // creates a PDO connection to the database
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //sets error modes
} catch (PDOException $e) {  //catch statement if it fails
    echo "Connection failed: " . $e->getMessage();  // outputs the error
}

