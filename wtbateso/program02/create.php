<?php 

	session_start();
	if (empty($_SESSION['name'])) header("Location: login.php");

	
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
		$jobNameError = null;
		$jobSalaryError = null;
		$companyNameError = null;
		
		// keep track post values
		$jobName = $_POST['jobName'];
		$jobSalary = $_POST['jobSalary'];
		$companyName = $_POST['companyName'];
		
		// validate input
		$valid = true;
		if (empty($jobName)) {
			$nameError = 'Please enter Job Name';
			$valid = false;
		}
		
		if (empty($jobSalary)) {
			$jobSalaryError = 'Please enter Job Salary';
			$valid = false;
		}
		
		if (empty($companyName)) {
			$companyNameError = 'Please enter Company Name';
			$valid = false;
		}
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO customers2 (jobName,jobSalary,companyName) values(?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($jobName,$jobSalary,$companyName));
			Database::disconnect();
			header("Location: program02.php");
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
		    			<h3>Create a Customer</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="create.php" method="post">
					  <div class="control-group <?php echo !empty($jobNameError)?'error':'';?>">
					    <label class="control-label">Job Name</label>
					    <div class="controls">
					      	<input name="jobName" type="text"  placeholder="Name" value="<?php echo !empty($jobName)?$jobName:'';?>">
					      	<?php if (!empty($jobNameError)): ?>
					      		<span class="help-inline"><?php echo $jobNameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($jobSalaryError)?'error':'';?>">
					    <label class="control-label">Job Salary</label>
					    <div class="controls">
					      	<input name="jobSalary" type="text" placeholder="job Salary" value="<?php echo !empty($jobSalary)?$jobSalary:'';?>">
					      	<?php if (!empty($jobSalaryError)): ?>
					      		<span class="help-inline"><?php echo $jobSalaryError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($companyNameError)?'error':'';?>">
					    <label class="control-label">company Name</label>
					    <div class="controls">
					      	<input name="companyName" type="text"  placeholder="company Name" value="<?php echo !empty($companyName)?$companyName:'';?>">
					      	<?php if (!empty($companyNameError)): ?>
					      		<span class="help-inline"><?php echo $companyNameError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="program02.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>