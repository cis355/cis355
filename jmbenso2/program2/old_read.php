<?php 
	/* read.php
	 ***********************************************************
	 *PURPOSE: Demonstrates the read method.
	 **********************************************************/

	require ('tdg.php');
	
	// Read requested $id
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	// If no $id posted, redirect to index
	if ( null==$id ) {
		header("Location: index.php");
		
	// Otherwise, read the passed id
	} else {
		$gateway = new CustomerGateway();
		$gateway->read($id,$data);
	}
?>
<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Read a Customer</h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">Name</label>
						     	<?php echo $data['name'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Email Address</label>
						     	<?php echo $data['email'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Mobile Number</label>
						     	<?php echo $data['mobile'];?>
					  </div>
					    <div class="form-actions">
						  <a class="btn" href="index.php">Back</a>
					   </div>

					</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>