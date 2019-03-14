<?php #Script - jsapp_attendance.php
// This is the Header page for the site.
require ('includes/config.inc.php');
$page_title = 'JSApp Attendance';
include ('includes/header.html');

require (MYSQL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
  
  // Validate the JSA_num:
	//if (!empty($_POST['JSA_num'])) {
		//$jsa = mysqli_real_escape_string($dbc, $_POST['JSA_num']);
		//} else {
			//$jsa = FALSE;
			//echo '<p class="error">You forgot to enter your the JSA number!</p>';
		//}
  
  // Validate the JSA_num:
	if ( isset($_POST['JSA_num']) && filter_var($_POST['JSA_num'], FILTER_VALIDATE_INT, array('min_range' => 1))  ) {
		$jsa = $_POST['JSA_num'];
	} else { // No JSA number selected.
		$jsa = FALSE;
		echo  '<p class="error">Please select a JSA number!</p>';
	}
  

  // Validate the First Name:
	if (!empty($_POST['first_name'])) {
		$fn = mysqli_real_escape_string($dbc, $_POST['first_name']);
		} else {
			$fn = FALSE;
			echo '<p class="error">You forgot to enter your First Name!</p>';
		}
    
    // Validate the Last Name:
	if (!empty($_POST['last_name'])) {
		$ln = mysqli_real_escape_string($dbc, $_POST['last_name']);
		} else {
			$ln = FALSE;
			echo '<p class="error">You forgot to enter your Last Name!</p>';
		}
    
   	
	
		if ($jsa && $fn && $ln) { // If everything's OK.
		
			// Query the database:
			$q = "INSERT INTO attendance (jsa_num, first_name, last_name, jsapp_date)
					VALUES ('$jsa','$fn','$ln', NOW() )";
			$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
			
			if (mysqli_affected_rows($dbc) == 1) { 
			
			  echo '<p>Your attendance entry has been recorded!</p>';
				
				// Redirect the user:
				$url = BASE_URL . 'jsapp_attendance.php';
				// Define the URL.
				ob_end_clean(); // Delete the buffer.
				header("Location: $url");
				exit(); // Quit the script.
				
			} else { // failed.
				echo '<p class="error">Your attendance entry failed to be recorded!</p>';
			}
			
			} else { // If everything wasn't OK.
				echo '<p class="error">Please try again.</p>';
			}
			
			mysqli_close($dbc);
			
		} // End of SUBMIT conditional.
		
		?>

<h1>Attendance</h1>
<p>Please fill out the Attendance information!</p>
<form enctype="multipart/form-data" action="jsapp_attendance.php" method="post">
  <fieldset>
    <p>
      <b>JSA Number:</b>
      <select name="JSA_num"><option>Select One</option>
	<?php // Retrieve all the JSA numbers and add to the pull-down menu.
	$q = "SELECT header_id, JSA_num FROM header ORDER BY JSA_num DESC";		
	$r = mysqli_query ($dbc, $q);
	if (mysqli_num_rows($r) > 0) {
		while ($row = mysqli_fetch_array ($r, MYSQLI_NUM)) {
			echo "<option value=\"$row[0]\"";
			// Check for stickyness:
			if (isset($_POST['JSA_num']) && ($_POST['JSA_num'] == $row[0]) ) echo ' selected="selected"';
			echo ">$row[1]</option>\n";
		}
	} else {
		echo '<option>Please add a JSA number first.</option>';
	}
	mysqli_close($dbc); // Close the database connection.
	?>
	</select></p>
    <p>
      <b>First Name:</b>
      <input type="text" name="first_name" size="40" maxlength="40"/>
    </p>
    <p>
      <b>Last Name:</b>
      <input type="text" name="last_name" size="40" maxlength="40"/>
    </p>  
  
    <div align="center">
      <input type="submit" name="submit" value="Submit" />
    </div>
  </fieldset>
</form>

<?php include ('includes/footer.html'); ?>