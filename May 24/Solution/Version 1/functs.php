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


