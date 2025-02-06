<?php
session_start();

include 'functs.php';

auditor($_SESSION["username"], "logout", "Logged out of the system");
session_destroy();

header("refresh:2; url=index.php");
echo "<link rel='stylesheet' href='rzl_styles.css'>";

echo "You have been logged out successfully";

?>