<?php
/* delete.php
	 ***********************************************************
	 *PURPOSE: Demonstrates the delete method.
	 **********************************************************/
	 
	require('tdg.php');
	
	// Read id to delete
	$id = 0;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	// Create gateway object
	$gateway = new CustomerGateway();
	
	// When we hit confirm button, the id from $_GET is posted
	if ( !empty($_POST)) {
		// read id
		$id = $_POST['id'];
		
		// delete data
		$gateway->delete($id);
		header("Location: index.php");
		
	} 
?>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Delete a Customer</h3>
		    		</div>
		    		
	    			<form class="form-horizontal" action="delete.php" method="post">
	    			  <input type="hidden" name="id" value="<?php echo $id;?>"/>
					  <p class="alert alert-error">Are you sure to delete ?</p>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-danger">Yes</button>
						  <a class="btn" href="index.php">No</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
</body>