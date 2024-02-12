<?php
    /**
     * This page represents the reset page.
     *
     * PHP version 7.1
     *
     * @author Manu Sugunakumar <manu.sugunakumar@dcmail.ca>
     * @version 1.0 (December 3, 2023)
     */

    $file = "reset.php";
    $date = "November 17, 2023";
    $title = "Reset";
    $desc = "This is the reset page.";

    include "./includes/header.php";

    // Variables
    $email = "";
    $message = "";

    if ($_SERVER['REQUEST_METHOD'] == "POST")
    {
        // getting the email from the form
        $email = trim($_POST['inputEmail']);

        // Validating email given
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $message .= "<em>" . $email . "</em> is not a valid email address!<br/>";
            $email = "";
        }

        // Send email(make a log) if there are no errors
        if($message == "")
        {
            if(user_select($email))
            {
                write_to_log_reset("Dear $email,\n\nWe recieved a request to reset the password on your account. To reset the password please follow the following link provided below.\n\n https://opentech.durhamcollege.org/inft2100/sugunakumarm/lab4/change_password.php");
                $email = "";
            }
            else
            {
                write_to_log_reset("$email does not exist within the database.");
                $email = "";
            }
        }

        // posts the message
        echo "<h2>".$message."</h2>\n";
    }

?>
<h1 class="h3 mb-3 font-weight-normal">Reset</h1>
<?php
    // Creating form structure for change password
    $form_change_password = 
    array(
        array(
            "type" => "email",
            "name" => "inputEmail",
            "value" => $email,
            "label" => "Email"
        ),
        array(
            "type" => "submit",
            "name" => "submit",
            "value" => "",
            "label" => "Reset Email"
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