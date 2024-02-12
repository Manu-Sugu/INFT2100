<?php
    /**
     * This page represents the change password page.
     *
     * PHP version 7.1
     *
     * @author Manu Sugunakumar <manu.sugunakumar@dcmail.ca>
     * @version 1.0 (November 17, 2023)
     */

    $file = "change_password.php";
    $date = "November 17, 2023";
    $title = "Change Password";
    $desc = "This is the change password page.";

    include "./includes/header.php";

    // checks if a user is logged in if there is no user logged in it will redirect them to the home page.
    if(!isset($_SESSION['user']))
    {
        redirect("./index.php");
    }

    // Variables
    $first_password = "";
    $second_password = "";
    $message = "";

    if ($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $first_password = trim($_POST['inputFirstPassword']);
        $second_password = trim($_POST['inputSecondPassword']);

        // Validate first password
        if(!isset($first_password) || $first_password == "")
        {
            $message .= "You must enter a password!<br/>";
        }
        elseif($first_password != $second_password)
        {
            $message .= "Your confirmation password does not match the password!<br/>";
            $first_password = "";
            $second_password = "";
        }

        // Update the password if there are no errors
        if($message == "")
        {
            if(change_password($_SESSION['user']['email_address'], $first_password))
            {
                setMessage("You have successfully changed your password!");
                redirect("./dashboard.php");
            }
            else
            {
                $message = "There was an error when changing your password!";
            }
        }

        // posts the message
        echo "<h2>".$message."</h2>\n";
    }

?>
<h1 class="h3 mb-3 font-weight-normal">Change Password</h1>
<?php
    // Creating form structure for change password
    $form_change_password = 
    array(
        array(
            "type" => "password",
            "name" => "inputFirstPassword",
            "value" => $first_password,
            "label" => "New Password"
        ),
        array(
            "type" => "password",
            "name" => "inputSecondPassword",
            "value" => $second_password,
            "label" => "Confirm Password"
        ),
        array(
            "type" => "submit",
            "name" => "submit",
            "value" => "",
            "label" => "Change Password"
        ),
        array(
            "type" => "reset",
            "name" => "clear",
            "value" => "",
            "label" => "Clear"
        )
    );
    // the start of the form
    echo '<form class="form-signin" action="'. $_SERVER['PHP_SELF'] .'" method="POST" enctype="multipart/form-data">';
    
    // Display the form
    displayForm($form_change_password);
    
    // The end of the form
    echo '</form>';
?>
<?php
    include "./includes/footer.php";
?> 