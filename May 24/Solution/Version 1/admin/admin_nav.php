<?php

echo "<div id='admin_navbar'>";

echo "<ul id='menu'>";

echo "<a href='../admin_index.php'><li> Home </li></a>";

if (empty($_SESSION["admin_ssnlogin"])) {
    echo "<a href='../admin_login.php'><li> Login </li></a>";

} elseif ($_SESSION["admin_ssnlogin"]) {


//    if super
    if ($_SESSION["level"]=="SUPER") {
        echo "::";

        echo "<a href='admin_pages/add_admin.php' <li> Add admin </li></a>";
        echo "::";
    }

    if ($_SESSION["level"]=="SUPER" or $_SESSION["level"]=="CREATOR"){

        echo "<a href='admin_pages/add_ticket.php' <li> Add Ticket </li></a>";
        echo "::";
        echo "<a href='admin_pages/add_hotelroom.php' <li> Add Hotel Room </li></a>";
        echo "::";
        echo "<a href='admin_pages/add_usertype.php' <li> Add User Type </li></a>";
        echo "::";
    }
// if super or creator or editor
    if ($_SESSION["level"]=="SUPER" or $_SESSION["level"]=="CREATOR" or $_SESSION["level"]=="EDITOR") {
        echo "<a href='admin_pages/update_ticket.php' <li> Update Ticket </li></a>";
        echo "::";
        echo "<a href='admin_pages/update_hotelroom.php' <li> Update Hotel Room </li></a>";
        echo "::";
        echo "<a href='admin_pages/update_usertype.php' <li> Update Hotel Room </li></a>";
        echo "::";
    }
// everyone
    echo "<a href='../logout.php'<li> Logout </li></a>";
    echo "::";

}

echo "</ul>";

echo "</div>";