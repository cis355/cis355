<?php 
	
	session_start();
	
	require 'database.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: camps.php");
	}
	
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
			$campNameError = 'Please enter User Name';
			$valid = false;
		}
		
		if (empty(startDate)) {
			$startDateError = 'Please enter start Date';
			$valid = false;
		}
		
		if (empty($endDate)) {
			$endDateError = 'Please enter endDate';
			$valid = false;
		}
		
	
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE camps  set campName = ?, startDate = ?, endDate =? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($campName,$startDate,$endDate,$id));
			Database::disconnect();
			header("Location: camps.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM camps where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$campName = $data['campName'];
		$startDate = $data['startDate'];
		$endDate = $data['endDate'];
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
		    			<h3>Update a Customer</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="update2.php?id=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($campNameError)?'error':'';?>">
					    <label class="control-label">Camp Name</label>
					    <div class="controls">
					      	<input name="campName" type="text"  placeholder="user Name" value="<?php echo !empty($campName)?$campName:'';?>">
					      	<?php if (!empty($campNameError)): ?>
					      		<span class="help-inline"><?php echo $campNameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($startDateError)?'error':'';?>">
					    <label class="control-label">Start Date</label>
					    <div class="controls">
					      	<input name="startDate" type="date" placeholder="startDate" value="<?php echo !empty($startDate)?$startDate:'';?>">
					      	<?php if (!empty($campNameError)): ?>
					      		<span class="help-inline"><?php echo $startDateError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($ratingError)?'error':'';?>">
					    <label class="control-label">endDate</label>
					    <div class="controls">
					      	<input name="endDate" type="date"  placeholder="endDate" value="<?php echo !empty($endDate)?$endDate:'';?>">
					      	<?php if (!empty($endDateError)): ?>
					      		<span class="help-inline"><?php echo $endDateError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="camps.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->

  </body>
</html>