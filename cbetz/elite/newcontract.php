<?php 
	#session_start();
	#$_SESSION['login_user']= $username;
	# Consider these scenarios.
	# 1. User clicked the create button on the list screen(index.php)
	#  If that happens then create.php displays a entry screen
	
	# 2. User clicked create button(sumbimt button) on entry screen, but a field was empty
	#	If that happens then an error messege appears next to the empy field(s)
	
	# 3. User clicks the create button and all data is valid
	#	IF that happens then the PHP code inserts the record and redirects to the list screen
	
	
	# include connection data and functions
	require 'elitedatabase.php';
	# If there was data passed then insert the record,
	# otherwise do nothing
	if ( !empty($_POST)) {
		// keep track validation errors
		$custError = null;
		$servError = null;

		
		// keep track post values
		$customerID = $_POST['customerID'];
		$serviceID = $_POST['serviceID'];
		
		// validate input
		$valid = true;
		if (empty($customerID)) {
			$custError = 'Please enter ID';
			$valid = false;
		}
		
		if (empty($serviceID)) {
			$servError = 'Please enter a ID';
			$valid = false;
		} 
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO contracts (customerID,serviceID) values(?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($customerID,$serviceID));
			Database::disconnect();
			header("Location: elite.php");
		}
	} # end if (!empty($_POST))
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
		    			<h3>Create a new Contract</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="newcontract.php" method="post">
					
					  <div class="control-group <?php echo !empty($custError)?'error':'';?>">
					    <label class="control-label">Customer ID</label>
					    <div class="controls">
					      	<input name="customerID" type="number"  placeholder="Customer ID" value="<?php echo !empty($customerID)?$customerID:'';?>">
					      	<?php if (!empty($custError)): ?>
					      		<span class="help-inline"><?php echo $custError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($servError)?'error':'';?>">
					    <label class="control-label">Service ID</label>
					    <div class="controls">
					      	<input name="serviceID" type="number" placeholder="Service ID" value="<?php echo !empty($serviceID)?$serviceID:'';?>">
					      	<?php if (!empty($servError)): ?>
					      		<span class="help-inline"><?php echo $servError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="elite.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>