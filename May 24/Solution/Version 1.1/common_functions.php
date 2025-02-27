<?php

function auditor($conn, $who, $short_what, $long_what){

    try {
        // Prepare and execute the SQL query
        $sql = "INSERT INTO audit (username, taskcode, task, date) VALUES (?, ?, ?, ?)";  //prepare the sql to be sent
        $stmt = $conn->prepare($sql); //prepare to sql

        $stmt->bindParam(1, $who);  //bind parameters for security
        $stmt->bindParam(2, $short_what);
        $stmt->bindParam(3, $long_what);
        $task_date = time();
        $stmt->bindParam(4, $task_date);
        $stmt->execute();  //run the query to insert
        $conn = null;  // closes the connection so cant be abused.
        return true; // Registration successful
    }  catch (PDOException $e) {
        // Handle database errors
        error_log("Audit Database error: " . $e->getMessage()); // Log the error
        throw new Exception(" Audit Database error". $e); //Throw exception for calling script to handle.
    } catch (Exception $e) {
        // Handle validation or other errors
        error_log("Auditing error: " . $e->getMessage()); //Log the error
        throw new Exception("Auditing error: " . $e->getMessage()); //Throw exception for calling script to handle.
    }

}

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