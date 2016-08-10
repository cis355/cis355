<?php
/* *******************************************************************
* filename :	interview_json.php
* author   :	Jon Benson
* username :	jmbenso2
* course   :	cis355
* section  :	31-MW
* semester :	Summer 2016
*
* PURPOSE :	 This program echoes out a JSON object of the contents
* 					 of the interviews table.
* INPUT   :	 N/A
* PRE     :	 N/A 
* OUTPUT  :	 Dynamically generated JSON object.
* POST    :	 Interviews JSON object presented.
*
* UML Diagram : http://csis.svsu.edu/~jmbenso2/cis355/jmbenso2/program3/diagram.png
*
* *******************************************************************
*/

require('database.php');

class InterviewJsonGenerator {
	/* getData ()
	***********************************************************
	 *PURPOSE: Returns an object containing all records in database table.
	 *INPUT: N/A
	 *PRE: N/A
	 *OUTPUT: returns mysqli results object
	 *POST: All table contents returned
	 *NOTE:
	 **********************************************************/
	public function getData() {
		$mysqli = Database::connect();
		// SQL to execute:
		$sql = 'SELECT * FROM interviews ORDER BY id DESC';
		$result = $mysqli->query($sql);
		Database::disconnect();
		return $result;
	} 
	
	/* getJsonString ()
	***********************************************************
	 *PURPOSE: Returns JSON object of interview table as string.
	 *INPUT: N/A
	 *PRE: N/A
	 *OUTPUT: returns string
	 *POST: JSON returned as string
	 *NOTE:
	 **********************************************************/
	public function getJsonString () {
		// Start building string
		$str = '';
		$str .= '{';
		$str .= '"interviews":';
		$str .= '['; // begin array
		foreach (self::getData() as $row) { // For each row in the table:
			$str .= '{'; // Open record
			$str .= '"id":"' . $row['id'] . '",';
			$str .= '"jobID":"' . $row['jobID'] . '",';
			$str .= '"resumeID":"' . $row['resumeID'] . '",';
			$str .= '"time":"' . $row['time'] .'"';
			$str .= '},'; // Close record
		}
		$str = substr($str,0,-1); // remove last comma
		$str .= ']'; // end array
		$str .= '}';
		
		return $str;

	} // End of getJsonString

	/* outputJson ()
	***********************************************************
	 *PURPOSE: Echoes out JSON object of interviews table.
	 *INPUT: N/A
	 *PRE: N/A
	 *OUTPUT: N/A
	 *POST: JSON object echoed out.
	 *NOTE:
	 **********************************************************/
	public function outputJson () {
		echo self::getJsonString();
	}
} // END OF class InterviewJsonGenerator

/*
* HI THERE
* Demonstrate class and also echo out link to UML diagram and source code
*/

$generator = new InterviewJsonGenerator();
$generator->outputJson();

// Link to UML diagram
echo '<br /><br /><br /><a href="http://csis.svsu.edu/~jmbenso2/cis355/jmbenso2/program3/diagram.png">UML Class Diagram</a><br /><br />';
		
// Show source here
show_source(__FILE__);
	

?>