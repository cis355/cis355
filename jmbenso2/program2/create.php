<?php
	/* create.php
	 ***********************************************************
	 *PURPOSE: Demonstrates the create method.
	 **********************************************************/

	require('tdg.php');
	
	if ( !empty($_POST)) { // If anything's been posted
		// Read posted input values
		$name = $_POST['name'];
		$email = $_POST['email'];
		$mobile = $_POST['mobile'];
		
		// Create our CustomerGateway object, validate input
		$gateway = new CustomerGateway();
		$gateway->isNewDataValid($name,$email,$mobile,$nameError,$emailError,$mobileError,$valid);
		
		if ($valid) {
			// Call the create method of our CustomerGateway, then redirect to index.
			$gateway->create($name,$email,$mobile);
			header("Location: index.php");
		}
	}
?>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Create a Customer</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="create.php" method="post">
					
						
					  <div class="control-group <?php echo !empty($nameError)?'error':'';?>"><!--If we have a value for error, print it here -->
					    <label class="control-label">Name</label>
					    <div class="controls">
					      	<input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>"> <!-- If we have a value for name, print it here -->
					      	<?php if (!empty($nameError)): ?>
					      		<span class="help-inline"><?php echo $nameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
					    <label class="control-label">Email Address</label>
					    <div class="controls">
					      	<input name="email" type="text" placeholder="Email Address" value="<?php echo !empty($email)?$email:'';?>">
					      	<?php if (!empty($emailError)): ?>
					      		<span class="help-inline"><?php echo $emailError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($mobileError)?'error':'';?>">
					    <label class="control-label">Mobile Number</label>
					    <div class="controls">
					      	<input name="mobile" type="text"  placeholder="Mobile Number" value="<?php echo !empty($mobile)?$mobile:'';?>">
					      	<?php if (!empty($mobileError)): ?>
					      		<span class="help-inline"><?php echo $mobileError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="index.php">Back</a>
						</div>
						
					</form>
				</div>
				
    </div> <!-- /container -->
</body>