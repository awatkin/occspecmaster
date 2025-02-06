<?php

// This is a file to include to access common functions to be used around the solution

//This is a subroutine to check the validity of a password and its confirmation password
function pwrd_checker($pass, $cpass) {  //takes in 2 parameters

    if($pass!=$cpass){  // do the passwords not match
    return false; // return false
    }
    elseif(strlen($pass)<8){  // is the password long enough?
        return false;
    }
    else{
        return true;
    }
}

function admin_sesh_started(){
    if(isset($_SESSION["admin_login"])){  // checks to see if the user is logged in or not already
        return true;  // if they are, returns true
    }
}

function auditor($who, $taskcode, $task){

    try {
        include 'dbconnect/db_connect_insert.php';
        $sql = "INSERT INTO audit (username, taskcode, task, date) VALUES (?, ?, ?, ?)";  //prepare the sql to be sent
        $stmt = $conn->prepare($sql); //prepare to sql

        $stmt->bindParam(1,$who);  //bind parameters for security
        $stmt->bindParam(2,$taskcode);
        $stmt->bindParam(3,$task);
        $date = time();
        $stmt->bindParam(4,$date);

        $stmt->execute();  //run the query to insert
    }  catch (PDOException $e) { //catch error
        //header("refresh:4; url=one_time_admin_reg.php");
        //echo "<link rel='stylesheet' href='admin_styles.css'>";
        echo "Auditor Error: " . $e->getMessage();
    }
}


?>