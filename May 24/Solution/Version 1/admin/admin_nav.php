<?php

echo "<div id='admin_navbar'>";

echo "<ul id='menu'>";

echo "<a href='index.php'><li> Home </li></a>";

if (empty($_SESSION["admin_ssnlogin"])) {
    echo "<a href='login.php'><li> Login </li></a>";

} elseif ($_SESSION["adminlogin"]) {

    include '../dbconnect/db_connect_select.php';


//    if super

    echo "<a href='addadmin.php' <li> Add admin </li></a>";

//    if creator or super

    echo "<a href='addticket.php' <li> Add Ticket </li></a>";
    echo "<a href='addhotelroom.php' <li> Add Hotel Room </li></a>";
    echo "<a href='addusertype.php' <li> Add Hotel Room </li></a>";

// if super or creator or editor

    echo "<a href='updateticket.php' <li> Update Ticket </li></a>";
    echo "<a href='updatehotelroom.php' <li> Update Hotel Room </li></a>";
    echo "<a href='updateusertype.php' <li> Update Hotel Room </li></a>";

// everyone
    echo "<a href='logout.php'<li> Logout </li></a>";

}

echo "</ul>";

echo "</div>";