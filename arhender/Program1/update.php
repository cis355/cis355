<?php 
/* *******************************************************************
 filename     : read.php  
 author       : Adam Henderson  
 username     : arhender 
 course       : cs355  
 section      : 11-MW  
 semester     : Summer 2016  
 description  :  This file contains the form to validate and update a customer record
				 based on id number, allowing the change of name, email or phone number
				
Process:
1. get the id from $_GET
2. instantiate the object
3. use the setid method using the obtained id
4. use the read method of the object
5. place the values onto the form to show what they currently are
6. user changes and then hits submit
7. place the new values into a new instantiated object.
8. validate against the values that were changed
9. use the update method to change the record
*********************************************************************  */	
	require 'customer.php';
	
	$id = null;
	
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: index.php");
	}
	

	
	# if there was data passed, then insert record, 
	# otherwise do nothing (that is, just display html for create)
	if ( !empty($_POST)) {
		// keep track validation errors
		$nameError = null;
		$emailError = null;
		$mobileError = null;
		
		// keep track post values
		
		$Cust = new customer($_POST['name'],$_POST['email'],$_POST['mobile']);
		$Cust->setid($id);
		
		
		// validate input
		$valid = true;
		if (empty($Cust->getname())) {
			$nameError = 'Please enter Name';
			$valid = false;
		}
		
		if (empty($Cust->getemail())) {
			$emailError = 'Please enter Email Address';
			$valid = false;
		} else if ( !filter_var($Cust->getemail(),FILTER_VALIDATE_EMAIL) ) {
			$emailError = 'Please enter a valid Email Address';
			$valid = false;
		}
		
		if (empty($Cust->getphone())) {
			$mobileError = 'Please enter Mobile Number';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			$Cust->update();
			header("Location: index.php");
		
		}
	}
	else {
		$Cust = new customer();
		$Cust->setid($id);
		$Cust->read();
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Update a Customer</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					    <label class="control-label">Name</label>
					    <div class="controls">
					      	<input name="name" type="text"  placeholder="Name" value="<?php echo !empty($Cust->getname())?$Cust->getname():'';?>">
					      	<?php if (!empty($nameError)): ?>
					      		<span class="help-inline"><?php echo $nameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
					    <label class="control-label">Email Address</label>
					    <div class="controls">
					      	<input name="email" type="text" placeholder="Email Address" value="<?php echo !empty($Cust->getemail())?$Cust->getemail():'';?>">
					      	<?php if (!empty($emailError)): ?>
					      		<span class="help-inline"><?php echo $emailError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($mobileError)?'error':'';?>">
					    <label class="control-label">Mobile Number</label>
					    <div class="controls">
					      	<input name="mobile" type="text"  placeholder="Mobile Number" value="<?php echo !empty($Cust->getphone())?$Cust->getphone():'';?>">
					      	<?php if (!empty($mobileError)): ?>
					      		<span class="help-inline"><?php echo $mobileError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="index.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->

  </body>
</html>