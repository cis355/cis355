<?php
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