<?php 
/* ***************************************************************************************************************
 filename     : u_service.php   
 author       : Chad Betz   
 course       : cis355     
 semester     : Summer 2016   
 description  : This file updates the service that has the same id as selected
				
PURPOSE 	  : CRUD App : Update
INPUT		  : NONE
PRE     	  : The service must be valid and created
OUTPUT		  : A updated version of the service
POST		  : Redirected back to the main page where the service will be updated
*****************************************************************************************************************/ 	
	require 'elitedatabase.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: elite.php");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$nameError = null;
		$descriptionError = null;
		$priceError = null;
		$dateError = null;
		
		// keep track post values
		$s_name = $_POST['s_name'];
		$description = $_POST['description'];
		$price = $_POST['price'];
		$date = $_POST['date'];
		
		// validate input
		$valid = true;
		if (empty($s_name)) {
			$s_nameError = 'Please enter Service Name';
			$valid = false;
		}
		
		if (empty($description)) {
			$descriptionError = 'Please enter a Description';
			$valid = false;
		} 
		
		if (empty($price)) {
			$priceError = 'Please enter a Price';
			$valid = false;
		}
		
		if (empty($date)) {
			$dateError = 'Please enter a Date';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE services set s_name = ?, description = ?, price = ?, date = ? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($s_name,$description,$price,$date,$id));
			Database::disconnect();
			header("Location: elite.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM services where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$s_name = $data['s_name'];
		$description = $data['description'];
		$price = $data['price'];
		$date = $data['date'];
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
		    			<h3>Update a Service</h3>
		    		</div>
					<form class="form-horizontal" action="u_service.php?id=<?php echo $id?>" method="post">
						<div class="control-group <?php echo !empty($s_nameError)?'error':'';?>">
							<label class="control-label">Service Name</label>
							<div class="controls">
								<input name="s_name" type="text"  placeholder="Service Name" value="<?php echo !empty($s_name)?$s_name:'';?>">
								<?php if (!empty($s_nameError)): ?>
									<span class="help-inline"><?php echo $s_nameError;?></span>
								<?php endif; ?>
							</div>
						</div>
						
						<div class="control-group <?php echo !empty($descriptionError)?'error':'';?>">
							<label class="control-label">Description</label>
							<div class="controls">
								<input name="description" type="text" placeholder="Service Description" value="<?php echo !empty($description)?$description:'';?>">
								<?php if (!empty($descriptionError)): ?>
									<span class="help-inline"><?php echo $descriptionError;?></span>
								<?php endif;?>
							</div>
						</div>
						
						<div class="control-group <?php echo !empty($priceError)?'error':'';?>">
							<label class="control-label">Price</label>
							<div class="controls">
								<input name="price" type="text"  placeholder="Service Price" value="<?php echo !empty($price)?$price:'';?>">
								<?php if (!empty($priceError)): ?>
									<span class="help-inline"><?php echo $priceError;?></span>
								<?php endif;?>
							</div>
						</div>
						
						<div class="control-group <?php echo !empty($dateError)?'error':'';?>">
							<label class="control-label">Date</label>
							<div class="controls">
								<input name="date" type="text"  placeholder="Service Date" value="<?php echo !empty($date)?$date:'';?>">
								<?php if (!empty($dateError)): ?>
									<span class="help-inline"><?php echo $dateError;?></span>
								<?php endif;?>
							</div>
						</div>
						
						<div class="form-actions">
							<button type="submit" class="btn btn-success">Update</button>
							<a class="btn" href="elite.php">Back</a>
							</div>
					</form>
				</div>
				
    </div> <!-- /container -->

  </body>
</html>