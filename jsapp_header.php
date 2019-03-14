<?php #Script - jsapp_header.php
// This is the Header page for the site.
require ('includes/config.inc.php');
$page_title = 'JSApp Header';
include ('includes/header.html');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require (MYSQL);
  
  // Validate the JSA_num:
	if (!empty($_POST['JSA_num'])) {
		$jsa = mysqli_real_escape_string($dbc, $_POST['JSA_num']);
		} else {
			$jsa = FALSE;
			echo '<p class="error">You forgot to enter your the JSA number!</p>';
		}

	// Validate the JSA_num:
	//if ( isset($_POST['JSA_num']) && filter_var($_POST['JSA_num'], FILTER_VALIDATE_INT, array('min_range' => 1))  ) {
	//	$jsa = $_POST['JSA_num'];
	//} else { // No JSA number selected.
	//	$jsa = FALSE;
	//	echo  '<p class="error">Please select a JSA number!</p>';
	//}
  
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
    
    
	
	// Validate the well name:
	if (!empty($_POST['well_name'])) {
		$w = mysqli_real_escape_string($dbc, $_POST['well_name']);
		} else {
			$w = FALSE;
			echo '<p class="error">You forgot to enter a well name!</p>';
		}
		
		// Validate the field:
		if (!empty($_POST['field'])) {
			$f = mysqli_real_escape_string($dbc, $_POST['field']);
		} else {
			$f = FALSE;
			echo '<p class="error">You forgot to enter the field name!</p>';
		}
    
    // Validate the company:
		if (!empty($_POST['company'])) {
			$c = mysqli_real_escape_string($dbc, $_POST['company']);
		} else {
			$c = FALSE;
			echo '<p class="error">You forgot to enter the company name!</p>';
		}
    
    // Create $sg value:
    if (isset($_POST['safety_glasses'])) {
      $sg = 1;
    } else {
      $sg = 0;
    }
       
     // Create $h value:
    if (isset($_POST['hard_hat'])) {
      $h = 1;
    } else {
      $h = 0;
    }
    
      // Create $s value:
    if (isset($_POST['safety_shoes'])) {
      $s = 1;
    } else {
      $s = 0;
    }
    
    // Create $frc value:
    if (isset($_POST['fr_clothing'])) {
      $frc = 1;
    } else {
      $frc = 0;
    }
    
     // Create $g value:
    if (isset($_POST['gloves'])) {
      $g = 1;
    } else {
      $g = 0;
    }
    
     // Create $h2s value:
    if (isset($_POST['h2s_monitor'])) {
      $h2s = 1;
    } else {
      $h2s = 0;
    }
    
     // Create $fire value:
    if (isset($_POST['fire_exstinguisher'])) {
      $fire = 1;
    } else {
      $fire = 0;
    }
    
    // Create $hp value:
    if (isset($_POST['hearing_protection'])) {
      $hp = 1;
    } else {
      $hp = 0;
    }
    
		if ($fn && $ln && $w && $f && $c) { // If everything's OK.
		
			// Query the database:
			$q = "INSERT INTO header (JSA_num, first_name, last_name,  well_name, field, company, safety_glasses, hard_hat, safety_shoes, fr_clothing, gloves, h2s_monitor, fire_exstinguisher, hearing_protection, jsapp_date)
      VALUES ('$jsa','$fn','$ln', '$w', '$f', '$c', '$sg', '$h', '$s', '$frc', '$g', '$h2s', '$fire', '$hp', NOW() )";
			$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
			
			if (mysqli_affected_rows($dbc) == 1) { 
			
			  echo '<p>Your header entry has been recorded!</p>';
				
				// Redirect the user:
				$url = BASE_URL . 'jsapp_attendance.php';
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

<h1>Header</h1>
<p>Please fill out the Header information!</p>
<form action="jsapp_header.php" method="post">
  <fieldset>
    <p>
      <b>JSA Number:</b>
      <input type="text" name="JSA_num" size="40" maxlength="40"/>
    </p>
    <p>
      <b>First Name:</b>
      <input type="text" name="first_name" size="40" maxlength="40"/>
    </p>
    <p>
      <b>Last Name:</b>
      <input type="text" name="last_name" size="40" maxlength="40"/>
    </p>
    
    <p>
      <b>Well Name:</b>
      <input type="text" name="well_name" size="40" maxlength="40"/>
    </p>
    <p>
      <b>Field:</b>
      <input type="text" name="field" size="40" maxlength="40"/>
    </p>
    <p>
      <b>Company:</b>
      <input type="text" name="company" size="40" maxlength="60"/>
    </p>
    <div class="checkbox">
      <p>
        Safety glasses: <input type="checkbox" name="safety_glasses" value="yes" />
      </p>
      <p>
        Hard Hat:
        <input type="checkbox" name="hard_hat" value="yes" />
      </p>
      <p>
        Safety Shoes:
        <input type="checkbox" name="safety_shoes" value="yes" />
      </p>
      <p>
        FR Clothing:
        <input type="checkbox" name="fr_clothing" value="yes" />
      </p>
      <p>
        Gloves:
        <input type="checkbox" name="gloves" value="yes" />
      </p>
      <p>
        H2S Monitor:
        <input type="checkbox" name="h2s_monitor" value="yes" />
      </p>
      <p>
        Fire Exstinguisher:
        <input type="checkbox" name="fire_exstinguisher" value="yes" />
      </p>
    <p>
       Hearing Protection:
        <input type="checkbox" name="hearing_protection" value="yes" />
      </p>
    </div>
    <div align="center">
      <input type="submit" name="submit" value="Submit" />
    </div>
  </fieldset>
</form>

<?php include ('includes/footer.html'); ?>