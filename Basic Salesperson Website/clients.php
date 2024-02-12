<?php
    /**
     * This page represents the clients page.
     *
     * PHP version 7.1
     *
     * @author Manu Sugunakumar <manu.sugunakumar@dcmail.ca>
     * @version 1.0 (October 28, 2023)
     */


    // comments variables
    $file = "clients.php";
    $date = "October 28, 2023";
    $title = "Client Page";
    $desc = "This is the page where you add a client.";
    include "./includes/header.php";

    // Checking if an admin or a sales agent is logged in otherwise it would not allow the user to access this page
    if(!isset($_SESSION['user']) || (isset($_SESSION['user']) && ($_SESSION['user']['type'] != AGENT && $_SESSION['user']['type'] != ADMIN)))
    {
        redirect("./sign-in.php");
    }

    // Variables
    $email = "";
    $first_name = "";
    $last_name = "";
    $extension = "";
    $phone_num = "";
    $userid = "";
    $message = "";

    $_SESSION['page'] = "clients";

    if ($_SERVER['REQUEST_METHOD'] == "POST")
    {
        // Variables
        $email = trim($_POST['inputEmail']);
        $first_name = trim($_POST['inputFirstName']);
        $last_name = trim($_POST['inputLastName']);
        $extension = trim($_POST['inputExtension']);
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

        // Validate extension
        if(!isset($extension) || $extension == "")
        {
            $message .= "You must enter an extension!<br/>";
        }

        // Validate Phone Number
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
        // decsion for user id
        if($_SESSION['user']['type'] == AGENT)
        {
            $userid = $_SESSION['user']['id'];
        }
        elseif($_SESSION['user']['type'] == ADMIN)
        {
            $userid = $_POST['inputSalesPerson'];
            if($userid == -1)
            {
                $message .= "You must Select an Agent id!<br/>";
            }
        }

        if($message == "")
        {
            if(insert_client($email, $first_name, $last_name, $extension, $phone_num, $userid, $logo_file_name) && move_uploaded_file($_FILES['file']['tmp_name'], $logo_path))
            {
                $message = "You registered a client!";
                $email = "";
                $first_name = "";
                $last_name = "";
                $extension = "";
                $phone_num = "";
                $userid = "";
            }
            else
            {
                $message = "There was an error with inserting this client!";
            }
        }

    }

    $page = 1;

    if (isset($_GET['page']))
    {
        $page = $_GET['page'];
    }

    displayTable(
        array(
            "id" => "ID",
            "email" => "Email",
            "first_name" => "First Name",
            "phone_number" => "Phone Number",
            "phone_ext" => "Phone Extension",
            "logo_path" => "Logo"
        ),
        client_select_all("clients", LIMIT, ($page - 1) * LIMIT),
        client_count("clients"),
        $page
    );
    // posts the message
    echo "<h2>".$message."</h2>\n";
?>

<!-- Form Title -->
<h1 class="h3 mb-3 font-weight-normal">Client Registration</h1>
<?php
    // checks if a admin is logged in to set the user id to show all the agents
    if(isset($_SESSION['user']['type']) && $_SESSION['user']['type'] == ADMIN)
    {
        $userid = user_type_select(AGENT);
    }
    else
    {
        $userid = "";
    }

    // Creating the form structure for clients
    $form_client = array(
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
            "type" => "text",
            "name" => "inputExtension",
            "value" => $extension,
            "label" => "Extension"
        ),
        array(
            "type" => "text",
            "name" => "inputPhoneNum",
            "value" => $phone_num,
            "label" => "Phone Number"
        ),
        array(
            "type" => "select",
            "name" => "inputSalesPerson",
            "value" => $userid,
            "label" => "Sales Person"
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
            "label" => "Submit Client"
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

    // displays the form
    displayForm($form_client);
    
    // The end of the form
    echo '</form>';
?>

<?php
    include "./includes/footer.php";
?>  