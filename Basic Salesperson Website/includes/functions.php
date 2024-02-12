<?php
/**
 * Manu Sugunakumar
 * September 20 2023
 * INFT2100
 * Functions page
 */
/*
    Function to redirect to another url
*/
function redirect($url){
    header("Location:".$url);
    ob_flush();
}

/*
    Functions to set messages
*/
function setMessage($msg){
    $_SESSION['message'] = $msg;
}

function getMessage(){
    return $_SESSION['message'];
}

function isMessage(){
    return isset($_SESSION['message'])?true:false; // Conditional operator
}

function removeMessage(){
    unset($_SESSION['message']);
}

function flashMessage(){
    $message = "";
    if(isMessage())
    {
        $message = getMessage();
        removeMessage();
    }
    return $message;
}
/**
 * Function to write logs
 */
function write_to_log($activity, $status, $email_address)
{
    // variables to get the date
    $today = date("Ymd");
    $now = date("Y-m-d G:i:s");
    // opens log file
    $handle = fopen("./logs/".$today."_log.txt", 'a');
    // writes to that log
    fwrite($handle, $activity."".$status." at ".$now." User ". $email_address. " ".$activity.".\n");
    // closes the file
    fclose($handle);
}

/**
 * Lets you read an argument or arrays in human readable form on a page.
 */
function dump($arg){
    echo "<pre>";
    print_r($arg);
    echo "</pre>";
}

/**
 * Displays a form when given an array structure for the form
 */
function displayForm(array $form_structure_array)
{
    // loop to go through the array and create the textboxes and buttons
    foreach($form_structure_array as $oneFormElement)
    {
        // checking if the array index is for a textbox, button or selection box
        if($oneFormElement['type'] == "text" || $oneFormElement['type'] == "email" || $oneFormElement['type'] == "password" || $oneFormElement['type'] == "phone")
        {
            // Creates textbox label and input box
            echo '<label for="'.$oneFormElement['name'].'" class="sr-only">'.$oneFormElement['label'].'</label>';
            echo '<input type="'.$oneFormElement['type'].'" id="'.$oneFormElement['name'].'" name="'.$oneFormElement['name'].'" class="form-control" placeholder="'.$oneFormElement['label'].'" value="'.$oneFormElement['value'].'">';
        }
        // checking if the array index is for dropboxes
        elseif($oneFormElement['type'] == "select" && $oneFormElement['value'] != "")
        {
            // Creates dropdown box with the options
            echo '<select name = "'.$oneFormElement['name'].'" id="'.$oneFormElement['name'].'" class="form-control mb-0">';
            // Get the agents from the database
            $users = $oneFormElement['value'];
            // Set the default value for the dropdown box
            echo '<option value="-1"> Select one from the following </option>';
            foreach ($users as $user)
            {
                echo '<option value="'.$user['id'].'">'.$user['first_name'].' '.$user['last_name']. ': '.$user['email_address'].'</option>';
            }
            // Closing tag for select tag
            echo '</select>';
        }
        // checking if the array index is for text area
        elseif($oneFormElement['type'] == "textarea")
        {
            // Title for text area
            echo '<label for="'.$oneFormElement['name'].'" class="sr-only">'.$oneFormElement['label'].'</label>';
            // Text area
            echo '<textarea class="form-control"  name="'.$oneFormElement['name'].'" id="'.$oneFormElement['name'].'"></textarea>';
        }
        elseif($oneFormElement['type'] == "datetime-local")
        {
            // Creates textbox label and input box
            echo '<label for="'.$oneFormElement['name'].'" class="sr-only">'.$oneFormElement['label'].'</label>';
            echo '<input type="'.$oneFormElement['type'].'" id="'.$oneFormElement['name'].'" name="'.$oneFormElement['name'].'" class="form-control" value="'.$oneFormElement['value'].'">';
        }elseif ($oneFormElement['type'] == "file") {
            // creates a file upload button
            echo '<label for="'.$oneFormElement['name'].'" class="sr-only">'.$oneFormElement['label'].'</label>';
            echo '<input type="'.$oneFormElement['type'].'" id="'.$oneFormElement['name'].'" name="'.$oneFormElement['name'].'" class="form-control" accept=".png, .gif">';
        }
        // checking if the array index is for buttons
        elseif($oneFormElement['type'] == "submit" || $oneFormElement['type'] == "reset")
        {
            // Creates buttons
            echo '<button class="btn btn-lg btn-primary btn-block" type="'.$oneFormElement['type'].'">'.$oneFormElement['label'].'</button>';
        }
    }
}

function displayTable($fields, $records, $count, $page)
{
    // start of the table
    echo '<div>';
    echo '<table class="table table-striped">';
    echo '<thead>';
    echo '<tr>';
    // makes the hearders
    foreach ($fields as $key => $value) {
        echo '<th scope="col">' . $value . '</th>';
    }
    // echo '<th scope="col">Logo</th>'; // New column for logo
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    // populates the data into the table
    foreach ($records as $record) {
        echo '<tr>';
        foreach ($record as $key => $value) {
            // Check if the current field is the image field
            if ($key != 'logo' && $key != 'is_active') {
                echo '<td>';
                echo $value;
                echo '</td>';
            }
        }
        
        // Add a new column for the logo
        echo '<td>';
        if(isset($record['logo']))
        {
            $logoPath = "./logos/" . $record['logo'] . ".png";
            // Display the image or a placeholder if it doesn't exist
            if (file_exists($logoPath)) {
                echo '<img src="' . $logoPath . '" alt="Salesperson Logo" style="max-width: 100px; max-height: 100px;">';
            } else {
                echo 'No logo available';
            }
        }
        else
        {
           echo 'No logo available';
        }
        echo '</td>';

        // Add a new column for is active
        if(isset($fields['is_active']))
        {
            echo '<td>';
            $salespersonId = $record['id'];

            echo '<input type="radio" name="status_' . $salespersonId . '" value="active" ' . ($record['is_active'] == 'active' ? 'checked' : '') . '> Active';
            echo '<br/>';
            echo '<input type="radio" name="status_' . $salespersonId . '" value="inactive" ' . ($record['is_active'] == 'inactive' ? 'checked' : '') . '>Inactive';
            echo '<button class="btn btn-sm btn-primary btn-block" type="submit" name="update" value="' . $salespersonId . '">Update</button>';
            echo '</td>';
            // echo '<td>';
            // echo "<input type="."radio"." name="."Active"." value="."active".">";
            // echo " Active\n";
            // echo '<input type="radio" name="Inactive" value="active">';
            // echo " Inactive\n";
            // echo '<button class="btn btn-sm btn-primary btn-block" type="submit">Update</button>';
            // echo '</td>';
        }

        echo '</tr>';
    }
    // end of the table
    echo '</tbody>';
    echo '</table>';

    echo '<nav aria-label="Page navigation example">';
    echo '<ul class="pagination">';
    echo '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . (($page > 1) ? --$page : $page) . '">Previous</a></li>';
    echo '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . (($page < $count / RECORDS) ? ++$page : $page) . '">Next</a></li>';
    echo '</ul>';
    echo '</nav>';
    echo '</div>';
}

function write_to_log_reset($message)
{
    // variables to get the date
    $today = date("Ymd");
    $now = date("Y-m-d G:i:s");
    // opens log file
    $handle = fopen("./logs/".$today."_log.txt", 'a');
    // writes to that log
    fwrite($handle, $message."\n");
    // closes the file
    fclose($handle);
}
?>