<?php

echo "<div id='user_navbar'>";

echo "<ul id='menu'>";
echo " :: ";
echo "<a href='../index.php'><li> Home </li></a>";
echo " :: ";
if (empty($_SESSION["ssnlogin"])) {
    echo " :: ";
    echo "<a href='../user_login.php'><li> Login </li></a>";
    echo " :: ";
    echo "<a href='../user_reg.php'><li> Login </li></a>";
    echo " :: ";

} elseif ($_SESSION["ssnlogin"]) {

    echo "<a href='ticket_booking.php' <li> Add Ticket </li></a>";
    echo " :: ";
    echo "<a href='hotelroom_booking.php' <li> Add Hotel Room </li></a>";
    echo " :: ";
    echo "<a href='../logout.php'<li> Logout </li></a>";
    echo "::";
}

echo "</ul>";

echo "</div>";