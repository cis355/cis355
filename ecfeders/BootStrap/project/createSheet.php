<?php
/* *******************************************************************  
* filename     : createSheet.php  
* author       : Erik Federspiel & Start Bootstrap & Star Tutorial
*  				 https://startbootstrap.com/template-overviews/simple-sidebar/
				 https://www.startutorial.com/
* username     : ecfeders  
* course       : cs355  
* section      : 11-MW  
* semester : Summer 2016  
*  
* description  : php file creates a form that a user can create a 
				 a sheet for their food safety and enter it into
				 their catlog of food safety sheets
 *  
 * processing   : The program steps are as follows.   
 *          1. display form
 *          2. wait for button click
 *          3. after button click go to correct form 
 *          4. based on button click do operations  
 
 * output       : table with correct information
 *  
 * precondition : css documents and php files in same directory/databaseProject.php
 * postcondition: adds a sheet to that businesses catalog
 * *******************************************************************   */ 
 ?>

<?php
   //Make sure logged in
	session_start();
	if(empty($_SESSION['name'])){
		header("Location: loginProject.php"); // redirect 
    }
?>

<?php 
	# Consider Three Scenrarios
	# 1. The user clicked the create button on list screen (index.php)
	# 		if That happens then create.php displays entry screen
	# 2. User clicked the create/submit button on the entry screen, but a field was empty
	# 		If that happens an error message will appear next to empty filds
	# 3. User clicks submit and all the data is valid
	# 		The php code inserts the record and redirects to the list screen (index.html)
	# include connection data and functions
	require 'databaseProject.php';
	# if there was data passed, then insert the record, otherwise wait
	# otherwise just display the html
	if ( !empty($_POST)) {
		// keep track validation errors
		$busIDError = null;
		$workerIDError = null;
		$grill1Error = null;
		$grill2Error = null;
		$fryer1Error = null;
		$fryer2Error = null;
		$creamerError = null;
		$dateError = null;
		
		// keep track post values
		$buss_id = $_POST['buss_id'];
		$worker_id = $_POST['worker_id'];
		$grill1 = $_POST['grill1'];
		$grill2 = $_POST['grill2'];
		$fryer1 = $_POST['fryer1'];
		$fryer2 = $_POST['fryer2'];
		$creamer = $_POST['creamer'];
		$dateMod = $_POST['dateMod'];
		
		// validate input
		$valid = true;
		
		// Check for empty inputs
		// Set Valid false if they are
		if (empty($buss_id)) {
			$busIDError = 'Please enter Business ID';
			$valid = false;
		}
		
		if (empty($worker_id)) {
			$workerIDError = 'Please enter Worker ID';
			$valid = false;
		}
		
		if (empty($grill1)) {
			$grill1Error = 'Please enter a Temperature';
			$valid = false;
		}
		
		if (empty($grill2)) {
			$grill2Error = 'Please enter a Temperature';
			$valid = false;
		}
		
		if (empty($fryer1)) {
			$fryer1Error = 'Please enter a Temperature';
			$valid = false;
		}
		
		if (empty($fryer2)) {
			$fryer2Error = 'Please enter a Temperature';
			$valid = false;
		}
		
		if (empty($creamer)) {
			$creamerError = 'Please enter a Temperature';
			$valid = false;
		}
		
		if (empty($dateMod)) {
			$dateError = 'Please enter a Date';
			$valid = false;
		}
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO sheet (buss_id,worker_id,grill1,grill2,fryer1,fryer2,creamer,dateMod) values(?, ?, ?, ?,?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($buss_id,$worker_id,$grill1,$grill2,$fryer1,$fryer2,$creamer,$dateMod));
			Database::disconnect();
			header("Location: project.php");
		}
	} # end if ( !empty($_POST))
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<link href="css/create.css" rel="stylesheet">
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Food Saftey Sheet</h3>
		    		</div>
    		        
					<!-- Form That Checks Errors and Uses Text INputs
						to the variable values in the php above
					-->
	    			<form class="form-horizontal" action="createSheet.php" method="post">
					  <div class="control-group <?php echo !empty($busIDError)?'error':'';?>">
					    <label class="control-label">Business ID</label>
					    <div class="controls">
					      	<input name="buss_id" type="text"  placeholder="Business ID" value="<?php echo !empty($buss_id)?$buss_id:'';?>">
					      	<?php if (!empty($busIDError)): ?>
					      		<span class="help-inline"><?php echo $busIDError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($workerIDError)?'error':'';?>">
					    <label class="control-label">Worker ID</label>
					    <div class="controls">
					      	<input name="worker_id" type="text" placeholder="Worker ID" value="<?php echo !empty($worker_id)?$worker_id:'';?>">
					      	<?php if (!empty($workerIDError)): ?>
					      		<span class="help-inline"><?php echo $workerIDError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($grill1Error)?'error':'';?>">
					    <label class="control-label">Grill 1</label>
					    <div class="controls">
					      	<input name="grill1" type="text"  placeholder="Grill1" value="<?php echo !empty($grill1)?$grill1:'';?>">
					      	<?php if (!empty($grill1Error)): ?>
					      		<span class="help-inline"><?php echo $grill1Error;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($grill2Error)?'error':'';?>">
					    <label class="control-label">Grill 2</label>
					    <div class="controls">
					      	<input name="grill2" type="text"  placeholder="Grill 2" value="<?php echo !empty($grill2)?$grill2:'';?>">
					      	<?php if (!empty($grill2Error)): ?>
					      		<span class="help-inline"><?php echo $grill2Error;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($fryer1Error)?'error':'';?>">
					    <label class="control-label">Fryer 1</label>
					    <div class="controls">
					      	<input name="fryer1" type="text"  placeholder="Fryer1" value="<?php echo !empty($fryer1)?$fryer1:'';?>">
					      	<?php if (!empty($fryer1Error)): ?>
					      		<span class="help-inline"><?php echo $fryer1Error;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($fryer2Error)?'error':'';?>">
					    <label class="control-label">Fryer 2</label>
					    <div class="controls">
					      	<input name="fryer2" type="text" placeholder="Fryer 2" value="<?php echo !empty($fryer2)?$fryer2:'';?>">
					      	<?php if (!empty($fryer2Error)): ?>
					      		<span class="help-inline"><?php echo $fryer2Error;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($creamerError)?'error':'';?>">
					    <label class="control-label">Creamer</label>
					    <div class="controls">
					      	<input name="creamer" type="text"  placeholder="Creamer" value="<?php echo !empty($creamer)?$creamer:'';?>">
					      	<?php if (!empty($creamerError)): ?>
					      		<span class="help-inline"><?php echo $creamerError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($dateError)?'error':'';?>">
					    <label class="control-label">Date</label>
					    <div class="controls">
					      	<input name="dateMod" type="date"  placeholder="Date" value="<?php echo !empty($dateMod)?$dateMod:'';?>">
					      	<?php if (!empty($dateError)): ?>
					      		<span class="help-inline"><?php echo $dateError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="project.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>