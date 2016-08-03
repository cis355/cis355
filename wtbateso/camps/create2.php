<?php 

	session_start();

	
	# Consider three scenarios.
	# 1. User clicked create button on list screen (index.php)
	#		If that happens then create.php displays entry screen
	# 2. User clicked create button (submit button) on entry but one or more fields were empty
	#		If that happens then error message(s) appears next to empty field(s)
	# 3. User clicked create button (submit button) and all data valid
	#		If that happens then PHP code inserts the record and redirect to list screen (index.php)
	
	# includes connection to database and functions
	require 'database.php';
	
	# if there is data passed, then insert record, otherwise do nothing 
	if ( !empty($_POST)) {
		// keep track validation errors
		$campNameError = null;
		$startDateError = null;
		$endDateError = null;
		
		// keep track post values
		$campName = $_POST['campName'];
		$startDate = $_POST['startDate'];
		$endDate = $_POST['endDate'];

		
		// validate input
		$valid = true;
		if (empty($campName)) {
			$campNameError = 'Please enter your camp Name';
			$valid = false;
		}
		if (empty($startDate)) {
			$startDateError = 'Please enter Date';
			$valid = false;
		}
		
		if (empty($endDate)) {
			$endDateError = 'Please enter ending Date';
			$valid = false;
		} 
		
		
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO camps (campName,startDate,endDate,) values(?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($campName,$startDate,$endDate));
			Database::disconnect();
			header("Location: camps.php");
		}
	} # end if ( !empty($_POST))
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
		    			<h3>Create a Camp</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="create2.php" method="post">
					<div class="control-group <?php echo !empty($campNameError)?'error':'';?>">
					    <label class="control-label">Camp Name</label>
					    <div class="controls">
					      	<input name="campName" type="text"  placeholder="camp Name" value="<?php echo !empty($campName)?$campName:'';?>">
					      	<?php if (!empty($campNameError)): ?>
					      		<span class="help-inline"><?php echo $campNameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($startDateError)?'error':'';?>">
					    <label class="control-label">Start Date</label>
					    <div class="controls">
					      	<input name="startDate" type="date"  placeholder="startDate" value="<?php echo !empty($startDate)?$startDate:'';?>">
					      	<?php if (!empty($startDateError)): ?>
					      		<span class="help-inline"><?php echo $startDateError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($endDateError)?'error':'';?>">
					    <label class="control-label">End Date</label>
					    <div class="controls">
					      	<input name="endDate" type="date" placeholder="endDate" value="<?php echo !empty($endDate)?$endDate:'';?>">
					      	<?php if (!empty($endDateError)): ?>
					      		<span class="help-inline"><?php echo $endDateError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="camps.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>