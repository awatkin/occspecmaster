<?php

session_start();  // conect with session data for important stuff

require_once "common_functions.php";  // include common functions to be callable
require_once "dbconnect/db_connect_master.php";  // include the database connections

if (!isset($_SESSION['user_ssnlogin'])){  // you are not logged in check
    $_SESSION['ERROR'] = "You are not logged in!";  // send them to log in
    header("Location: user_login.php");  // header to move them on
    exit; // Stop further execution
} elseif($_SERVER["REQUEST_METHOD"] == "POST"){  // if the page calls itself from the booking form
     if(avail_tickets(dbconnect_select(),$_POST)){  // calls a functions from common functions to check if enough tickets are available
         $short_what =  "TICKBOOK";  // sets task for auditor
         $long_what = $_SESSION['username']." Booked tickets for ".$_POST['booking_date'];  // sets long taks for auditor
         if(t_booking_confirm(dbconnect_select(), dbconnect_insert(), $_SESSION, $_POST) && auditor(dbconnect_insert(), $_SESSION['username'], $short_what, $long_what)){  // tries to inser the booking
             $_SESSION['SUCCESS'] = "Your ticket(s) have been booked successfully!"; // sets a success message and sends user to index.
             header("Location: index.php");  // header to move them on
             exit; // Stop further execution
         }
     }
     else {
         $_SESSION['ERROR'] = "Insufficient tickets available, try another date";  // if not enough tickets available give this message
         header("Location: book_tickets.php");  // reload page to display error message
         exit; // Stop further execution
     }

}


echo "<!DOCTYPE html>";

echo "<html lang='en'>";

echo "<head>";
echo "<link rel='stylesheet' href='styles.css'>";
echo "<title> RZA Ticket Booking</title>";
echo "</head>";

echo "<body>";

echo "<div id='container'>";

echo "<div id='title'>";

echo "<h3 id='banner'>Ridget Zoo Adventures</h3>";

echo "</div>";

include 'user_nav.php';

echo "<div id='content'>";

echo "<h4> Ticket Booking System</h4>";

echo "<br>";
echo usr_error($_SESSION);  // calls function to display error message or success message
echo "<br>";


echo "<br>";
echo "<br>";

echo "<form method='post' action='book_tickets.php'>";

echo "<table id='tick_book'>";
echo "<tr>";
    echo "<td> Select a date: </td>";

    echo "<td> <input type='date' name='booking_date' value='2025-03-15' min='2025-03-04' max='2025-11-30' /></td>";
echo "</tr>";

echo "<tr>";
    echo "<td> How many Tickets: </td>";
    echo "<td><input type='text' name='num' placeholder='number of tickets' required><br></td>";
echo "</tr>";

echo "<tr>";
    echo "<td> Select Ticket type: </td>";
    echo "<td><select name='ticket_type'>";

    $ticket_types = get_ticket_types(dbconnect_select());  // calls function to get the ticket types and their id numbers

    foreach ($ticket_types as $type) {  // uses a loop to display them
        echo "<option value=".$type['t_id'].">".$type['type']."</option>";  // sets the ticket id as the "value" to be able to use it later, but displays the ticket type text
    }

    echo "</select></td><br>";
echo "</tr>";

echo "<tr>";
    echo "<td></td><td><input type='submit' name='submit' value='Book'></td>";
echo "</tr>";

echo "</table>";
echo "</form>";

echo "<br><br>";

echo "</div>";

echo "</div>";

echo "</body>";

echo "</html>";



