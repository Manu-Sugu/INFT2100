<?php
/**
 * This page represents the login page.
 *
 * PHP version 7.1
 *
 * @author Manu Sugunakumar <manu.sugunakumar@dcmail.ca>
 * @version 1.0 (September 20, 2023)
 */


// comments variables
$file = "index.php";
$date = "September 20, 2023";
$title = "INFT2100 Login Page";
$desc = "This is the user login page.";
include "./includes/header.php";

// Variables
$conn = db_connect();
$email = "";
$password = "";
$message = "";


// Checking if a user is logged in to redirect to the dashboard
if(isset($_SESSION['user']))
{
    redirect("./dashboard.php");
}

// flashing said message
$message = flashMessage();

// form
if ($_SERVER['REQUEST_METHOD'] == "POST")
{
    // email Validation
    if(isset($_POST['inputEmail']))
    {
        $email = trim($_POST['inputEmail']);
    }
    else
    {
        $message .= "You must enter a email!<br/>";
    }
    
    // Checking if the email is formatted correctly
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $message .= "<em>" . $email . "</em> is not a valid email address!<br/>";
        $email = "";
    }
    
    // password validation
    if(isset($_POST['inputPassword']))
    {
        $password = trim($_POST['inputPassword']);
    }
    else
    {
        $message .= "You must enter a password!<br/>";
    }

    // checking if error messages exist to continue with the user authentication
    if($message == "")
    {
        if(user_authenticate($email, $password))
        {
            // Selecting a user
            $user = user_select($email);
            if($user['is_active'] == "active")
            {
                // set the current session of the user to the current user
                $_SESSION['user'] = $user;
                // update the log with the successful login 
                write_to_log("Sign in ", "Success", $email);
                redirect("./dashboard.php");
            }
            else
            {
                // update the log with a failed login
                write_to_log("Sign in ", "Failed", $email);
                $message = "Email or passoword is incorrect!";
            }
        }
        else
        {
            // update the log with a failed login
            write_to_log("Sign in ", "Failed", $email);
            $message = "Email or passoword is incorrect!";
        }
    }
}
?>   

<h2><?php echo $message; ?></h2>
<form class="form-signin" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email address" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
</form>

<?php
include "./includes/footer.php";
?>    