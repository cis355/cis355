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
					  <div class="control-group ' .  echo !empty($jobNameError)?'error':'';' . ">
					    <label class="control-label">Job Name</label>
					    <div class="controls">
					      	<input name="jobName" type="text"  placeholder="Name" value="' .  echo !empty($jobName)?$jobName:'';' . ">
					      	' .  if (!empty($jobNameError)): ' . 
					      		<span class="help-inline">' .  echo $jobNameError;' . </span>
					      	' .  endif; ' . 
					    </div>
					  </div>
					  <div class="control-group ' .  echo !empty($jobSalaryError)?'error':'';' . ">
					    <label class="control-label">Job Salary</label>
					    <div class="controls">
					      	<input name="jobSalary" type="text" placeholder="job Salary" value="' .  echo !empty($jobSalary)?$jobSalary:'';' . ">
					      	' .  if (!empty($jobSalaryError)): ' . 
					      		<span class="help-inline">' .  echo $jobSalaryError;' . </span>
					      	' .  endif;' . 
					    </div>
					  </div>
					  <div class="control-group ' .  echo !empty($companyNameError)?'error':'';' . ">
					    <label class="control-label">company Name</label>
					    <div class="controls">
					      	<input name="companyName" type="text"  placeholder="company Name" value="' .  echo !empty($companyName)?$companyName:'';' . ">
					      	' .  if (!empty($companyNameError)): ' . 
					      		<span class="help-inline">' .  echo $companyNameError;' . </span>
					      	' .  endif;' . 
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