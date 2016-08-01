<?php
/* *******************************************************************
* filename : index.php
* author : Jon Benson
* username : jmbenso2
* course : cis355
* section : 31-MW
* semester : Summer 2016
*
* PURPOSE : 	This program presents a simple CRUD application
*  for accessing and manipulating the records in an Interviews
*  database table. 
* INPUT : 		N/A
* PRE : 			N/A 
* OUTPUT :		Dynamically generated HTML.
* POST : 			Interactive CRUD application presented.
*
* UML Diagram : http://csis.svsu.edu/~jmbenso2/cis355/jmbenso2/program2/diagram.png
*
* *******************************************************************
*/

require("database.php");

/* class InterviewGateway()
 ***********************************************************
 *PURPOSE: Provides interface to the interviews table.
 **********************************************************/
class InterviewGateway {
	
	/********  Methods for interacting with database or validating data ******** /
	
	/* create ($jobID, $resumeID, $time)
	 ***********************************************************
	 *PURPOSE: Adds a record to the database table.
	 *INPUT: $jobID and $resumeID (containing int), $time (containing datetime)
	 *PRE: input args not null, time a valid datetime
	 *OUTPUT: N/A
	 *POST: New record in database table.
	 *NOTE:
	 **********************************************************/
	public function create($jobID, $resumeID, $time) {
		$mysqli = Database::connect();
		// SQL to execute:
		$sql = "INSERT INTO interviews (jobID,resumeID,time) values(?, ?, ?)";
		$q = $mysqli->prepare($sql);
		$q->bind_param('iis',$jobID,$resumeID,$time);
		$q->execute();
		Database::disconnect();
	} // End of create
	
	/* read ($id, &$data)
	 ***********************************************************
	 *PURPOSE: Reads a record in the database table.
	 *INPUT: $id (containing integer)
	 *PRE: $id corresponds to an existing record where $id = interviews.id
	 *OUTPUT: &$data
	 *POST: &$data is array of record's values
	 *NOTE:
	 **********************************************************/
	public function read ($id, &$data) {
		$mysqli = Database::connect();
		$sql = "SELECT id, jobID, resumeID, time FROM interviews where id = ?";
		$q = $mysqli->prepare($sql);
		$q->bind_param('i',$id);
		$q->execute();
		$q->store_result();
		$q->bind_result($id,$jobID,$resumeID,$time);
		while ($q->fetch()) {
			// Read results into data
			$data['id'] = $id;
			$data['jobID'] = $jobID;
			$data['resumeID'] = $resumeID;
			$data['time'] = $time;
		}
		Database::disconnect();
	}
	
	/* update ($id,$jobID,$resumeID,$time)
	 ***********************************************************
	 *PURPOSE: Updates a record in the database table.
	 *INPUT: $id $jobID $resumeID (ints), $time (datetime) 
	 *PRE: $id corresponds to an existing record where $id = interviews.id,
	 *		$jobID and $resumeID not null, time a valid datetime
	 *OUTPUT: N/A
	 *POST: Record updated in database
	 *NOTE:
	 **********************************************************/
	public function update ($id,$jobID,$resumeID,$time) {
		$mysqli = Database::connect();
		$sql = "UPDATE interviews set jobID = ?, resumeID = ?, time = ? WHERE id = ?";
		$q = $mysqli->prepare($sql);
		$q->bind_param('iisi',$jobID,$resumeID,$time,$id);
		$q->execute();
		Database::disconnect();
	}
	
	/* delete ($id)
	 ***********************************************************
	 *PURPOSE: Deletes a record from the database table.
	 *INPUT: $id (containing integer)
	 *PRE: $id corresponds to an existing record where $id = interviews.id
	 *OUTPUT: N/A
	 *POST: Record of id $id no longer exists in database table.
	 *NOTE:
	 **********************************************************/
	public function delete ($id) {
		$mysqli = Database::connect();
		$sql = "DELETE FROM interviews WHERE id = ?";
		$q = $mysqli->prepare($sql);
		$q->bind_param('i',$id);
		$q->execute();
		Database::disconnect();
	}
	
	/* getAll ()
	***********************************************************
	 *PURPOSE: Returns an object containing all records in database table.
	 *INPUT: N/A
	 *PRE: N/A
	 *OUTPUT: returns mysqli results object
	 *POST: All table contents returned
	 *NOTE:
	 **********************************************************/
	public function getAll() {
		$mysqli = Database::connect();
		// SQL to execute:
		$sql = 'SELECT * FROM interviews ORDER BY id DESC';
		$result = $mysqli->query($sql);
		Database::disconnect();
		return $result;
	} // end of getAll()
	
	/* isNewDataValid ($jobID, $resumeID, $time, &$jobIDError, &$resumeIDError, &$timeError, &$valid)
	 ***********************************************************
	 *PURPOSE: Tests if all input data are valid.
	 *INPUT: $jobID, $resumeID, $time
	 *PRE: N/A
	 *OUTPUT: &$jobIDError, &$resumeIDError, &$timeError, &$valid
	 *POST: &$jobIDError, &$resumeIDError, and &$timeError contain any error messages
	 *		&$valid contains true if all inputs valid, false otherwise
	 *NOTE:
	 **********************************************************/
	public function isNewDataValid($jobID, $resumeID, $time, &$jobIDError, &$resumeIDError, &$timeError, &$valid) {
		// keep track of validation error messages and overall validity
		$jobIDError = null;
		$resumeIDError = null;
		$timeError = null;
		$valid = true;
		
		if (empty($jobID)) { // If no jobID was read/posted
			$jobIDError = 'Please enter Job ID'; // Set jobID error message
			$valid = false; // If this is set to false anywhere, prevents us from inserting data later on
		} else if (!(is_numeric($jobID))) { // if jobID is not integer
			$jobIDError = 'Job ID must be an integer.';
			$valid = false;
		}
		
		if (empty($resumeID)) {
			$resumeIDError = 'Please enter Resume ID'; // If no resumeID was read/posted
			$valid = false;
		} else if (!(is_numeric($resumeID))) { // if resumeID is not integer
			$resumeIDError = 'Resume ID must be an integer.';
			$valid = false;
		}
		
		if (empty($time)) {
			$timeError = 'Please enter Time in "Y-m-d H:i:s" format';
			$valid = false;
		} else if (!(date_create_from_format('Y-m-d H:i:s',$time))) { // If time can't be converted to timestamp
			$timeError = 'Please enter Time in "Y-m-d H:i:s" format';
			$valid = false;
		}
	} // end of isNewDataValid
	
	
	/*****************  Methods for managing user interaction ***************** /
	
	/* runIndex ()
	 ***********************************************************
	 *PURPOSE: Determines what to display onscreen and calls functions to produce HTML.
	 *INPUT: N/A
	 *PRE: N/A
	 *OUTPUT: N/A
	 *POST: If command is posted, displays appropriate screen; if no command posted,
	 *       table of records is shown.
	 *NOTE:
	 **********************************************************/	
	public function runIndex() {
		// Decide what to do based on command posted in cmd

		// Create
		if ($_POST['cmd'] == 'create') {
			self::runCreate();
		}
		
		// Read
		else if ($_POST['cmd'] == 'read') {
			self::runRead();
			
		}
		
		// Update
		else if ($_POST['cmd'] == 'update') {
			self::runUpdate();
		}
		
		// Delete
		else if ($_POST['cmd'] == 'delete') {
			self::runDelete();
		}
		
		// If no command posted:
		else {
			self::displayTable();
		}
	} // End of runIndex
	
	/* runCreate ()
	 ***********************************************************
	 *PURPOSE: Handles a request for the create screen.
	 *INPUT: N/A
	 *PRE: N/A
	 *OUTPUT: N/A
	 *POST: If valid data posted, a new record is added and the index is reset.
	 *			If no data or invalid data posted, create screen is displayed with any error messages.
	 *NOTE:
	 **********************************************************/	
	public function runCreate() {
		// If any data is posted to add
		if (!(empty($_POST['jobID'])) || !(empty($_POST['resumeID'])) || !(empty($_POST['timeID']))) {
			// Read posted values
			$jobID = $_POST['jobID'];
			$resumeID = $_POST['resumeID'];
			$time = $_POST['time'];
			
			// Validate input
			self::isNewDataValid($jobID,$resumeID,$time,$jobIDError, $resumeIDError, $timeError, $valid);
			
			// If valid, add
			if ($valid) {
				self::create($jobID, $resumeID, $time);
				header("Location: index.php");
			}
			
			// If invalid, show screen again
			else {
				self::displayCreate();
				if ($jobIDError != null) {
					echo $jobIDError . '<br />';
				}
				if ($resumeIDError != null) {
					echo $resumeIDError . '<br />';
				}
				if ($timeError != null) {
					echo $timeError . '<br />';
				}
			}
		}
		// If no data is posted to add:
		else { 
			self::displayCreate();
		}
	}
	
	/* runRead()
	 ***********************************************************
	 *PURPOSE: Handles a request for the read screen.
	 *INPUT: N/A
	 *PRE: N/A
	 *OUTPUT: N/A
	 *POST: If valid id posted, current data is displayed
	 *NOTE:
	 **********************************************************/
	public function runRead() {
		$id = $_POST['id'];
		// If no $id posted, redirect to index
		if ( null==$id ) {
			header("Location: index.php");
			echo 'hello';
		// Otherwise, read the passed id
		// and display 
		} else {
			$gateway = new InterviewGateway();
			$gateway->read($id,$data);
			self::displayRead($data['id'],$data['jobID'],$data['resumeID'],$data['time']);
		}
	}
	
	/* runUpdate()
	 ***********************************************************
	 *PURPOSE: Handles a request for the update screen.
	 *INPUT: N/A
	 *PRE: N/A
	 *OUTPUT: N/A
	 *POST: If valid id posted, current data is displayed;
	 *      if additional data is posted, database is updated.
	 *NOTE:
	 **********************************************************/	
	public function runUpdate() {
		// If any additional data is posted
		$id = $_POST['id'];
		if ($id == null) header("Location: index.php");
		if (!(empty($_POST['jobID'])) || !(empty($_POST['resumeID'])) || !(empty($_POST['timeID']))) {
			// Read posted values
			$jobID = $_POST['jobID'];
			$resumeID = $_POST['resumeID'];
			$time = $_POST['time'];
			
			// Validate input
			self::isNewDataValid($jobID,$resumeID,$time,$jobIDError, $resumeIDError, $timeError, $valid);
			
			// If valid, add
			if ($valid) {
				self::update($id,$jobID, $resumeID, $time);
				header("Location: index.php");
			}
			
			// If invalid, show screen again
			else {
				self::read($id,$data);
				self::displayUpdate($id,$data);
				if ($jobIDError != null) {
					echo $jobIDError . '<br />';
				}
				if ($resumeIDError != null) {
					echo $resumeIDError . '<br />';
				}
				if ($timeError != null) {
					echo $timeError . '<br />';
				}
			}
		}		
		// If no additional data is posted, display the screen
		else {
			self::read($id,$data);
			self::displayUpdate($id,$data);
		}
	}
	
	/* runDelete()
	 ***********************************************************
	 *PURPOSE: Handles a delete request.
	 *INPUT: N/A
	 *PRE: N/A
	 *OUTPUT: N/A
	 *POST: If valid id posted, that record is deleted.
	 *NOTE:
	 **********************************************************/	
	public function runDelete() {
		$id = $_POST['id'];
		// If ID is posted:
		if ($id != null) {
			self::delete($id); // delete it
		}
		header("Location: index.php");
	}
	
	
	/***************** Methods for producing HTML **********************/
	
	/* displayTable ()
	 ***********************************************************
	 *PURPOSE: Prints an HTML table containing all records in database table.
	 *         Also prints a create button. Also displays this source code.
	 *				 Also contains a link to a UML class diagram.				 
	 *INPUT: N/A
	 *PRE: N/A
	 *OUTPUT: N/A
	 *POST: HTML table & aforementioned other stuff printed.
	 *NOTE:
	 **********************************************************/	
	public function displayTable () {
		echo '<h1>Interviews CRUD</h1><br />';
		echo '<table border="1"><tr><th>Interview ID</th><th>Job ID</th><th>Resume ID</th><th>Scheduled Date/Time</th><th>Actions</th></tr>'; // echo out table header

		foreach (self::getAll() as $row) { // Get table contents
			//   as $row -- as you iterate through, the current row will be named $row
			//   Now we iterate through the rows selected
			echo '<tr>';
			echo '<td>'. $row['id'] . '</td>';
			echo '<td>'. $row['jobID'] . '</td>';
			echo '<td>'. $row['resumeID'] . '</td>';
			echo '<td>'. $row['time'] . '</td>';
			echo '<td width="250">';
			// Read button
			echo '<form action="index.php" method="post">';
			echo '<input type="hidden" name="cmd" value="read" />';
			echo '<input type="hidden" name="id" value="'.$row['id'].'" />';
			echo '<input type="submit" value="Read" />';
			echo '</form>';
			// Update button
			echo '<form action="index.php" method="post">';
			echo '<input type="hidden" name="cmd" value="update" />';
		  echo '<input type="hidden" name="id" value="'.$row['id'].'" />';
			echo '<input type="submit" value="Update" />';
			echo '</form>';
			// Delete button
			echo '<form action="index.php" method="post">';
			echo '<input type="hidden" name="cmd" value="delete" />';
		  echo '<input type="hidden" name="id" value="'.$row['id'].'" />';
			echo '<input type="submit" value="Delete" />';
			echo '</form>';
			echo '</td>';
			echo '</tr>';
		} // End of table drawing loop

		// Draw create button
		echo '</table><br />';
		echo '<form action="index.php" method="post">';
		echo '<input type="hidden" name="cmd" value="create" />';
		echo '<input type="submit" value="Create" />';
		echo '</form>';
		
		// Link to UML diagram
		echo '<a href="http://csis.svsu.edu/~jmbenso2/cis355/jmbenso2/program2/diagram.png">UML Class Diagram</a><br /><br />';
		
		// Show source here
		show_source(__FILE__);
			
	} // End of displayTable
	
	/* displayCreate ()
	 ***********************************************************
	 *PURPOSE: Prints HTML for a Create screen.
	 *INPUT: N/A
	 *PRE: N/A
	 *OUTPUT: N/A
	 *POST: HTML echoed out.
	 *NOTE:
	 **********************************************************/	
	public function displayCreate() {
		// produce HTML for form 
		echo '<h2>Create New Record</h2><br />';
		echo '<form action="index.php" method="post">';
		echo '<input type="hidden" name="cmd" value="create" />';
		echo 'Job ID: <input type="text" name="jobID" /><br />';
		echo 'Resume ID: <input type="text" name="resumeID" / ><br />';
		echo 'Date/Time: <input type="datetime" name="time" value="2000-12-30 12:00:00" /><br />';
		echo '<input type="submit" value="Submit" />';
		echo '</form>';
		echo '<a type="btn" href="index.php">Back</a>'; // Back link
	}
	
	/* displayRead ($id, $jobID, $resumeID, $time)
	 ***********************************************************
	 *PURPOSE: Prints HTML for a Read screen.
	 *INPUT: $id, $jobID, $resumeID, $time
	 *PRE: N/A
	 *OUTPUT: N/A
	 *POST: HTML echoed out.
	 *NOTE:
	 **********************************************************/	
	public function displayRead($id, $jobID, $resumeID, $time) {
		echo '<h2>Read Record</h2><br />';
		echo 'Interview ID: ' . $id . '<br />';
		echo 'Job ID: ' . $jobID . '<br />';
		echo 'Resume ID: ' . $resumeID . '<br />';
		echo 'Date/Time: ' . $time . '<br />';
		echo '<a type="btn" href="index.php">Back</a>'; // Back link
	}
	
	/* displayUpdate ($id, $data)
	 ***********************************************************
	 *PURPOSE: Prints HTML for an Update screen.
	 *INPUT: $data (associative array)
	 *PRE: N/A
	 *OUTPUT: N/A
	 *POST: HTML echoed out.
	 *NOTE:
	 **********************************************************/	
	public function displayUpdate($id, $data) {
		// produce HTML for form 
		echo '<h2>Update Record</h2><br />';
		echo 'Interview ID: ' . $id . '<br />';
		echo '<form action="index.php" method="post">';
		echo '<input type="hidden" name="cmd" value="update" />';
		echo '<input type="hidden" name="id" value="'.$id.'" />';
		// job ID
		echo 'Job ID: <input type="text" name="jobID"';
		if ($data['jobID'] != null) echo ' value="'. $data['jobID'] .'"';
		echo '/><br />';
		// resume ID
		echo 'Resume ID: <input type="text" name="resumeID"';
		if ($data['resumeID'] != null) echo ' value="'. $data['resumeID'] .'"';
		echo '/ ><br />';
		// date/time
		echo 'Date/Time: <input type="datetime" name="time"'; 
		if ($data['time'] != null) echo ' value="'. $data['time'] .'"';
		echo '/><br />';
		// Submit
		echo '<input type="submit" value="Submit" />';
		echo '</form>';
		echo '<a type="btn" href="index.php">Back</a>'; // Back link
	}
		
} // End of Class InterviewGateway
	
// Start the application
$gateway = new InterviewGateway();
$gateway->runIndex();

?>