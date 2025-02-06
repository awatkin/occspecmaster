<?php
// file to validate information for new admin user before inserting into database

include '../functs.php';  // brings in the funct file for common functions
include 'admin_functs.php';
  // used to check correct format of email address

if($_POST['priv']=="SUPER" and super_checker()) {
    header("refresh:4; url=admin_login.php");
    echo "<link rel='stylesheet' href='admin_styles.css'>";
    echo "Super admin already exists, go login";
} elseif(valid_email()!=true) {  // checks for key phrase in email field
    header("refresh:4; url=one_time_admin_reg.php");
    echo "<link rel='stylesheet' href='admin_styles.css'>";
    echo "Invalid email, try again";
} elseif(pwrd_checker($_POST['password'], $_POST['cpassword']) == false) {  //calls function to check password complexity
    header("refresh:4; url=one_time_admin_reg.php");
    echo "<link rel='stylesheet' href='admin_styles.css'>";
    echo "Password related issue, try again";
}
else {
// this code runs if the previous checks are ok

    include '../dbconnect/db_connect_insert.php';//Used to insert the data into the database, if valid

    try {  //try this code

        $sql = "INSERT INTO admin_users (username, password, email, f_name, s_name, signup_date, privl) VALUES (?, ?, ?, ?, ?, ?, ?)";  //prepare the sql to be sent
        $stmt = $conn->prepare($sql); //prepare to sql

        $stmt->bindParam(1,$_POST['username']);  //bind parameters for security
        $hpswd = password_hash($_POST['password'], PASSWORD_DEFAULT);  //has the password
        $stmt->bindParam(2,$hpswd);
        $stmt->bindParam(3,$_POST['email']);
        $stmt->bindParam(4,$_POST['fname']);
        $stmt->bindParam(5,$_POST['sname']);
        $signup_date = time();
        $stmt->bindParam(6,$signup_date);
        $stmt->bindParam(7,$_POST['priv']);

        $stmt->execute();  //run the query to insert
        $admin_reg_type = strtolower($_POST['priv']) + "reg";
        auditor($_POST['username'], $admin_reg_type, "Registration of a super user");

        header("refresh:5; url=admin_login.php"); //confirm and redirect
        echo "<link rel='stylesheet' href='admin_styles.css'>";
        echo "Successfully registered";
    } catch (PDOException $e) { //catch error
        header("refresh:4; url=one_time_admin_reg.php");
        echo "<link rel='stylesheet' href='admin_styles.css'>";
        echo "Error: " . $e->getMessage();
        echo "Password related issue, try again";
    }

}