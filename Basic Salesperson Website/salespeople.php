<?php
    /**
     * This page represents the salespeople page.
     *
     * PHP version 7.1
     *
     * @author Manu Sugunakumar <manu.sugunakumar@dcmail.ca>
     * @version 1.0 (October 28, 2023)
     */


    // comments variables
    $file = "salespeople.php";
    $date = "October 28, 2023";
    $title = "Sales People Page";
    $desc = "This is the page where you add a salesperson.";
    include "./includes/header.php";

    // Checking if an admin is logged in otherwise it would not allow the user to access this page
    if(!isset($_SESSION['user']) || (isset($_SESSION['user']) && $_SESSION['user']['type'] != ADMIN))
    {
        redirect("./sign-in.php");
    }

    // Variables
    $email = "";
    $first_name = "";
    $last_name = "";
    $first_password = "";
    $second_password = "";
    $phone_num = "";
    $message = "";
    
    $page = 1;
    
    if (isset($_GET['page']))
    {
        $page = $_GET['page'];
    }
    
    $this_records = salespeople_select_all("users", LIMIT, ($page - 1) * LIMIT);

    if ($_SERVER['REQUEST_METHOD'] == "POST")
    {
        if(!isset($_POST['update']))
        {
            $email = trim($_POST['inputEmail']);
            $first_name = trim($_POST['inputFirstName']);
            $last_name = trim($_POST['inputLastName']);
            $first_password = trim($_POST['inputFirstPassword']);
            $second_password = trim($_POST['inputSecondPassword']);
            $phone_num = trim($_POST['inputPhoneNum']);
    
            // Validate email
            if(!isset($email) || $email == "")
            {
                $message .= "You must enter a email!<br/>";
            }
            elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $message .= "<em>" . $email . "</em> is not a valid email address!<br/>";
                $email = "";
            }
    
            // Validate first name
            if(!isset($first_name) || $first_name == "")
            {
                $message .= "You must enter a first name!<br/>";
            }
    
            // Validate last name
            if(!isset($last_name) || $last_name == "")
            {
                $message .= "You must enter a last name!<br/>";
            }
    
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
    
            // Validate phone number
            if(!isset($phone_num) || $phone_num == "")
            {
                $message .= "You must enter a phone number!<br/>";
            }
    
            // File validation
            if (isset($_FILES['file'])) 
            {
                if ($_FILES['file']['error'] != 0) {
                    $message .= "There was a problem uploading your file (Error code: {$_FILES['file']['error']}).<br/>";
                } elseif ($_FILES['file']['size'] > 3000000) {
                    $message .= "File uploaded is too big. File must be less than 3MB.<br/>";
                } elseif (!in_array($_FILES['file']['type'], ["image/png", "image/gif"])) {
                    $message .= "Image must be in PNG or GIF format.<br/>";
                } else {
                    $today = date("Ymd");
                    $email_address = ""; 
                    $logo_path = "./logos/logo_". $email .".png";
                    $logo_file_name = "logo_".$email;
                }
            }
    
            // checks if there are any error messages otherwise insert the user
            if($message == "")
            {
                if(insert_salesperson($email, $first_password, $first_name, $last_name, $phone_num, AGENT, $logo_file_name) && move_uploaded_file($_FILES['file']['tmp_name'], $logo_path))
                {
                    $message = "You registered a salesperson!";
                    $email = "";
                    $first_name = "";
                    $last_name = "";
                    $first_password = "";
                    $second_password = "";
                    $phone_num = "";
                }else
                {
                    $message = "There was an error with inserting this salesperson!";
                }
            }
        }
        else
        {
            foreach ($this_records as $record){
                $salespersonId = $record['id'];
                if($_POST['update'] == $salespersonId)
                {
                    if (isset($_POST['status_' . $salespersonId])) {
                        if(is_active($_POST['status_' . $salespersonId], $salespersonId)){
                            $message = $record['first_name']." was made ".$_POST['status_' . $salespersonId];
                        }
                    }
                }
            }
        }
    }
    // posts the message
    echo "<h2>".$message."</h2>\n";
?>

<?php

    // Creating the form structure for sales people page
    $form_sales_people = 
    array(
        array(
            "type" => "text",
            "name" => "inputFirstName",
            "value" => $first_name,
            "label" => "First Name"
        ),
        array(
            "type" => "text",
            "name" => "inputLastName",
            "value" => $last_name,
            "label" => "Last Name"
        ),
        array(
            "type" => "email",
            "name" => "inputEmail",
            "value" => $email,
            "label" => "Email Address"
        ),
        array(
            "type" => "password",
            "name" => "inputFirstPassword",
            "value" => $first_password,
            "label" => "Password"
        ),
        array(
            "type" => "password",
            "name" => "inputSecondPassword",
            "value" => $second_password,
            "label" => "Confirm Password"
        ),
        array(
            "type" => "text",
            "name" => "inputPhoneNum",
            "value" => $phone_num,
            "label" => "Phone Number"
        ),
        array(
            "type" => "file",
            "name" => "file",
            "label" => "Upload File"
        ),
        array(
            "type" => "submit",
            "name" => "submit",
            "value" => "",
            "label" => "Submit Sales person"
        ),
        array(
            "type" => "reset",
            "name" => "clear",
            "value" => "",
            "label" => "Clear"
        )
    );
    
    // the start of the form
    echo '<div>';
    echo '<table>';
    echo '<form class="form-signin" action="'. $_SERVER['PHP_SELF'] .'" method="POST" enctype="multipart/form-data">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col"></th>';
    echo '<th scope="col"></th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    echo '<tr>';
    echo '<td>';
    echo '<h1 class="h3 mb-3 font-weight-normal">Sales Agent Registration</h1>';
    displayForm($form_sales_people);
    echo '</td>';
    echo '<td>';
    displayTable(
        array(
            "id" => "ID",
            "email" => "Email",
            "first_name" => "First Name",
            "phone_ext" => "Phone Extension",
            "logo_path" => "Logo",
            "is_active" => "Is Active?"
        ),
        $this_records,
        salespeople_count("users"),
        $page
    );
    // The end of the form
    echo '</td>';
    echo '</tr>';
    echo '</tbody>';
    echo '</form>';
    echo '</table>';
    echo '</div>';
?>

<?php
    include "./includes/footer.php";
?>  