<?php #Script - jsapp_body.php
// This is the Header page for the site.
require ('includes/config.inc.php');
$page_title = 'JSApp Body';
include ('includes/header.html');

require (MYSQL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {	
  
  
      // Validate JSA Number:
	 if (!empty($_POST['JSA_num'])) {
      $jsa = mysqli_real_escape_string($dbc, $_POST['JSA_num']);
     } else {
      echo '<p class="error">You forgot to enter your the JSA number!</p>';
     }   

	  // Validate the JSA_num:
	//if ( isset($_POST['JSA_num']) && filter_var($_POST['JSA_num'], FILTER_VALIDATE_INT, array('min_range' => 1))  ) {
	//	$jsa = $_POST['JSA_num'];
	//} else { // No JSA number selected.
	//	$jsa = FALSE;
	//	echo  '<p class="error">Please select a JSA number!</p>';
	//}
	
     
     // Validate the steps:
		if (!empty($_POST['steps'])) {
			$stp = mysqli_real_escape_string($dbc, $_POST['steps']);
		} else {
			$stp = FALSE;
			echo '<p class="error">You forgot to enter the steps!</p>';
		}
    
     // Validate the hazards:
		if (!empty($_POST['hazards'])) {
			$h = mysqli_real_escape_string($dbc, $_POST['hazards']);
		} else {
			$h = FALSE;
			echo '<p class="error">You forgot to enter the hazards!</p>';
		}
    
     // Validate the controls:
		if (!empty($_POST['controls'])) {
			$con = mysqli_real_escape_string($dbc, $_POST['controls']);
		} else {
			$con = FALSE;
			echo '<p class="error">You forgot to enter the controls!</p>';
		}
    
    
  
		if ($stp && $h && $con) { // If everything's OK.
		
			// Query the database:
		      $q = "INSERT INTO body (JSA_num, steps, hazards, controls, body_date)
          VALUES ('$jsa', '$stp', '$h', '$con', NOW())";
     			$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
			
			if (mysqli_affected_rows($dbc) == 1) { 
			
			  echo '<p>Your header entry has been recorded!</p>';
				
				// Redirect the user:
				$url = BASE_URL . 'jsapp_body.php';
				// Define the URL.
				ob_end_clean(); // Delete the buffer.
				header("Location: $url");
				exit(); // Quit the script.
				
			} else { // failed.
				echo '<p class="error">Your header entry failed to be recorded!</p>';
			}
			
			} else { // If everything wasn't OK.
				echo '<p class="error">Please try again.</p>';
			}
			
			mysqli_close($dbc);
			
		} // End of SUBMIT conditional.
		
		?>

<h1>Body</h1>
<p>Please fill out the Body information!</p>
<form enctype="multipart/form-data" action="jsapp_body.php" method="post">
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
      <b>Steps: </b>
      <textarea name="steps" rows="5" cols="30"></textarea>
    </p>
    <p>
      <b>Hazards: </b>
      <textarea name="hazards" rows="5" cols="30"></textarea>
    </p>
      <b>Controls: </b>
      <textarea name="controls" rows="6" cols="34"></textarea>
    </p>
    <br/>
    <br/>
    <div align="center">
      <input type="submit" name="submit" value="Submit" />
    </div>
  </fieldset>
</form>

<?php include ('includes/footer.html'); ?>