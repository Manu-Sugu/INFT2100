<?php
    /**
     * This page represents the calls page.
     *
     * PHP version 7.1
     *
     * @author Manu Sugunakumar <manu.sugunakumar@dcmail.ca>
     * @version 1.0 (October 28, 2023)
     */


    // comments variables
    $file = "calls.php";
    $date = "October 28, 2023";
    $title = "Calls Page";
    $desc = "This is the page where you add a call record.";
    include "./includes/header.php";

    // Checking if an admin or a sales agent is logged in otherwise it would not allow the user to access this page
    if(!isset($_SESSION['user']) || (isset($_SESSION['user']) && ($_SESSION['user']['type'] != AGENT && $_SESSION['user']['type'] != ADMIN)))
    {
        redirect("./sign-in.php");
    }

    // Variables
    $client_id = "";
    $time_of_call = "";
    $notes = "";
    $message = "";
    $call_count = 0;

    if ($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $client_id = trim($_POST['inputClient']);
        $time_of_call = trim($_POST['inputDateTime']);
        $notes = trim($_POST['inputNotes']);

        // Validate client
        if($client_id == -1)
        {
            $message .= "You must Select an Client id!<br/>";
        }

        // Validate time and date
        if(!isset($time_of_call) || $time_of_call == "")
        {
            $message .= "You must select a time and date!<br/>";
        }
        // Note don't need validation for notes as user can enter no notes for the call as a record.

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
                $logo_path = "./logos/logo_". $call_count .".png";
                $logo_file_name = "logo_".$call_count;
                $call_count ++;
            }
        }

        // if no errors enter the call into records
        if($message == "")
        {
            // Make the date and time into user readable date and time
            $time_of_call = str_replace('T'," ", $time_of_call);
            $time_of_call .= ":00";

            // run the insert function
            if(insert_call($client_id, $time_of_call, $notes, $logo_file_name) && move_uploaded_file($_FILES['file']['tmp_name'], $logo_path))
            {
                $message = "You recorded a call!";
                $client_id = "";
                $time_of_call = "";
                $notes = "";
            }
            else
            {
                $message = "There was an error with inserting this call record.";
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
            "client_id" => "Client ID",
            "time_of_call" => "Time of Call",
            "notes" => "Notes",
            "logo_path" => "Logo"
        ),
        call_select_all("calls", LIMIT, ($page - 1) * LIMIT),
        call_count("calls"),
        $page
    );

    // posts the message
    echo "<h2>".$message."</h2>\n";
?>
<!-- Form Title -->
<h1 class="h3 mb-3 font-weight-normal">Record Call</h1>
<?php
    // setting the client id to show all the displayed clients
    $client_id = clients_select();

    // Creates the form structure for calls form
    $form_call = array(
        array(
            "type" => "select",
            "name" => "inputClient",
            "value" => $client_id,
            "label" => ""
        ),
        array(
            "type" => "datetime-local",
            "name" => "inputDateTime",
            "value" => $time_of_call,
            "label" => "Date and Time"
        ),
        array(
            "type" => "textarea",
            "name" => "inputNotes",
            "value" => $notes,
            "label" => "Notes"
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
            "label" => "Submit Call"
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
    
    // Displays the call form
    displayForm($form_call);

    // The end of the form
    echo '</form>';
?>

<?php
    include "./includes/footer.php";
?>  