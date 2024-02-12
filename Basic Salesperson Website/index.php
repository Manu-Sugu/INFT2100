<?php
/**
 * This page represents the home page.
 *
 * PHP version 7.1
 *
 * @author Manu Sugunakumar <manu.sugunakumar@dcmail.ca>
 * @version 1.0 (September 20, 2023)
 */

$file = "index.php";
$date = "September 20, 2023";
$title = "INFT2100 Home Page";
$desc = "This is the home page.";
include "./includes/header.php";

?>

<h1 class="cover-heading">INFT2100 HomePage</h1>

<!-- This sets the message -->
<h2><?php echo $message; ?></h2>
<!-- Cover is a one-page template for building simple and beautiful home pages. Download, edit the text, and add your own fullscreen background photo to make it your own.-->
<p class="lead">This is the home page for these Labs.</p>
<p class="lead">
    <a href="#" class="btn btn-lg btn-secondary">Learn more</a>
</p>

<?php
include "./includes/footer.php";
?>    