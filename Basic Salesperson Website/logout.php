<?php
    /**
     * This page represents the logout page.
     *
     * PHP version 7.1
     *
     * @author Manu Sugunakumar <manu.sugunakumar@dcmail.ca>
     * @version 1.0 (September 20, 2023)
     */


    // comments variables
    $file = "index.php";
    $date = "September 20, 2023";
    $title = "INFT2100 Logout Page";
    $desc = "This is the user logout page.";
    include "./includes/header.php";
    $user = $_SESSION['user'];
    $email_address = $user['emailaddress'];
    session_unset(); // unset the whole session array
    session_destroy(); // destroys by freeing memory
    session_start();

    $_SESSION['message'] = "You successfully logged out";
    write_to_log("Sign out ", "Success", $email_address);
    redirect("sign-in.php");
?>