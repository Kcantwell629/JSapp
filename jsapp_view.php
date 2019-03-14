<?php # Script - view.php
// This page displays the customers.

// Set the page title and include the HTML header:
$page_title = 'View JSA';
include ('includes/header.html');

// Include the configuration file:
require ('includes/config.inc.php'); 

require (MYSQL);

// Default query for this page:
$q = "SELECT header.JSA_num, CONCAT_WS('', first_name, last_name) AS name, header_id, well_name, field, company, steps, hazards, controls
FROM header, body WHERE header.JSA_num = body.JSA_num ORDER BY JSA_num DESC";

// Are we looking at a particular JSA?
if (isset($_GET['hid']) && filter_var($_GET['hid'], FILTER_VALIDATE_INT, array('min_range' => 1)) ) {
	// Overwrite the query:
	$q = "SELECT header.JSA_num, CONCAT_WS('', first_name, last_name) AS name, header_id, well_name, field, company, steps, hazards, controls
	FROM header, body WHERE header.JSA_num = body.JSA_num AND header.header_id={$_GET['hid']} ORDER BY JSA_num DESC";

}

// Are we looking at a particular company?
if (isset($_GET['wid']) && filter_var($_GET['wid'], FILTER_VALIDATE_INT, array('min_range' => 1)) ) {
	// Overwrite the query:
	$q = "SELECT header.JSA_num, CONCAT_WS('', first_name, last_name) AS name, header_id, well_name, field, company, steps, hazards, controls
	FROM header, body WHERE header.JSA_num = body.JSA_num AND header.header_id={$_GET['wid']} ORDER BY JSA_num DESC";

}

// Create the table head:

echo '<table border="0" width="100%" cellspacing="10" cellpadding="5" align="right">
		<tr>
			<td align="left" width="10%"><b>JSA</b></td>
			<td align="left" width="10%"><b>Well Name</b></td>
			<td align="left" width="10%"><b>Field</b></td>
			<td align="left" width="10%"><b>Company</b></td>
			<td align="left" width="10%"><b>Name</b></td>
			<td align="left" width="10%"><b>Steps</b></td>
			<td align="left" width="20%"><b>Hazards</b></td>
			<td align="left" width="90%"><b>Controls</b></td>
		</tr>';

// Display all the prints, linked to URLs:
$r = mysqli_query ($dbc, $q);
While ($row = mysqli_fetch_array ($r, MYSQLI_ASSOC)) {
	
	// Display each record:
	echo "\t<tr>
		<td align=\"left\"><a href=\"jsapp_view.php?hid={$row['header_id']}\">{$row['header_id']}</a></td>
		<td align=\"left\"><a href=\"jsapp_view.php?wid={$row['header_id']}\">{$row['well_name']}</a></td>
		<td align=\"left\">{$row['field']}</td>
		<td align=\"left\">{$row['company']}</td>
		<td align=\"left\">{$row['name']}</td>
		<td align=\"left\">{$row['steps']}</td>
		<td align=\"left\">{$row['hazards']}</td>
		<td align=\"left\">{$row['controls']}</td>		
	</tr>\n";

} // End of While loop.

echo '</table>';
mysqli_close($dbc);
include ('includes/footer.html');
?>




















