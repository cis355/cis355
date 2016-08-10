<?php 
	
	require 'databaseProject.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: project.php");
	}
	
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
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE sheet  set buss_id = ?, worker_id = ?, grill1 = ?, grill2 = ?,
			fryer1 = ?, fryer2 = ?, creamer = ?, dateMod = '?' WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($buss_id,$worker_id,$grill1,$grill2,$fryer1,$fryer2,$creamer,$dateMod,$id));
			Database::disconnect();
			header("Location: project.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT buss_id, worker_id, grill1, grill2, fryer1, fryer2,
				creamer, dateMod FROM sheet where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$buss_id = $data['buss_id'];
		$worker_id = $data['worker_id'];
		$grill1 = $data['grill1'];
		$grill2 = $data['grill2'];
		$fryer1 = $data['fryer1'];
		$fryer2 = $data['fryer2'];
		$creamer = $data['creamer'];
		$dateMod = $data['dateMod'];
		Database::disconnect();
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
		    			<h3>Food Safetey Sheet</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="updateProject.php" method="post">
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
					      	<input name="grill1" type="text"  placeholder="Position" value="<?php echo !empty($grill1)?$grill1:'';?>">
					      	<?php if (!empty($grill1Error)): ?>
					      		<span class="help-inline"><?php echo $grill1Error;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($grill2Error)?'error':'';?>">
					    <label class="control-label">Grill 2</label>
					    <div class="controls">
					      	<input name="grill2" type="text"  placeholder="Password" value="<?php echo !empty($grill2)?$grill2:'';?>">
					      	<?php if (!empty($grill2Error)): ?>
					      		<span class="help-inline"><?php echo $grill2Error;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($fryer1Error)?'error':'';?>">
					    <label class="control-label">Fryer 1</label>
					    <div class="controls">
					      	<input name="fryer1" type="text"  placeholder="Name" value="<?php echo !empty($fryer1)?$fryer1:'';?>">
					      	<?php if (!empty($fryer1Error)): ?>
					      		<span class="help-inline"><?php echo $fryer1Error;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($fryer2Error)?'error':'';?>">
					    <label class="control-label">Fryer 2</label>
					    <div class="controls">
					      	<input name="fryer2" type="text" placeholder="Bussiness ID" value="<?php echo !empty($fryer2)?$fryer2:'';?>">
					      	<?php if (!empty($fryer2Error)): ?>
					      		<span class="help-inline"><?php echo $fryer2Error;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($creamerError)?'error':'';?>">
					    <label class="control-label">Creamer</label>
					    <div class="controls">
					      	<input name="creamer" type="text"  placeholder="Position" value="<?php echo !empty($creamer)?$creamer:'';?>">
					      	<?php if (!empty($creamerError)): ?>
					      		<span class="help-inline"><?php echo $creamerError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($dateError)?'error':'';?>">
					    <label class="control-label">Date</label>
					    <div class="controls">
					      	<input name="dateMod" type="text"  placeholder="Password" value="<?php echo !empty($dateMod)?$dateMod:'';?>">
					      	<?php if (!empty($dateError)): ?>
					      		<span class="help-inline"><?php echo $dateError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="project.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>