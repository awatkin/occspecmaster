<?php

function super_checker(){
    include '../dbconnect/db_connect_select.php';//gets the select user details to check if admin exists or not
    $sql = "SELECT * FROM admin_users"; //set up the sql statement
    $stmt = $conn->prepare($sql); //prepares
    $stmt->execute(); //run the sql code
    $result = $stmt->fetch(PDO::FETCH_ASSOC);  //brings back results
    if($result){
        return true;
    } else {
        return false;
    }
}

function valid_email(){
    $phrase = "@rzl.com";
    if(strpos($_POST['email'], $phrase) == false){
        return false;
    } else {
        return true;
    }
}