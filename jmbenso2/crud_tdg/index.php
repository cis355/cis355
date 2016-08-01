<?php
	/* index.php
	 ***********************************************************
	 *PURPOSE: Demonstrates the displayTable method.
	 **********************************************************/

	require('tdg.php');
	
	$gateway = new CustomerGateway();
	$gateway->displayTable();
?>
<a href="create.php" class="btn btn-success">Create New</a>