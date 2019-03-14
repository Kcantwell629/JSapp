<?php # Script - index.php
// This is the main page for the site.

// Include the configuration file:
require ('includes/config.inc.php'); 

// Set the page title and include the HTML header:
$page_title = 'Welcome to JSApp!';
include ('includes/header.html');

// Welcome the user (by name if they are logged in):
echo '<h1>Welcome';
if (isset($_SESSION['first_name'])) {
	echo ", {$_SESSION['first_name']}";
}
echo '!</h1>';
?>
<p>JSApp is an excellent way to record a job safety analysis for each job and wellsite. To get started select the JSApp_Header page.</p>
<p>Thank you for using JSApp for your JSA activities!</p>

<?php include ('includes/footer.html'); ?>