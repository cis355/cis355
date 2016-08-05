<?php

/* *******************************************************************
* filename : index.php
* author : Jon Benson
* username : jmbenso2
* course : cs355
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
* *******************************************************************
*/

	/* index.php
	 ***********************************************************
	 *PURPOSE: Demonstrates the displayTable method.
	 **********************************************************/

	require('interviews_tdg.php');
	
	$gateway = new InterviewGateway();
	$gateway->runIndex();
	
	
	// echo '';
?>
<!-- 
<form action="index.php" method="post">
  Job ID: <input type="text" name="jobID" /><br />
  Resume ID: <input type="text" name="resumeID" / ><br />
  Date/Time: <input type="datetime" name="time" /><br />
	<input type="submit" value="Submit" />
</form>

			echo '<form action="index.php" method="post">';
			echo '<input type="hidden" name="cmd" value="update" />';
			echo '<input type="submit" value="Update" />';
			echo '</form>';
	-->