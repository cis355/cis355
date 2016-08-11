<?php
/* ***************************************************************************************************************
 filename     : u_contract.php   
 author       : Chad Betz   
 course       : cis355     
 semester     : Summer 2016   
 description  : This file updates the contract that has the same id as selected
				
PURPOSE 	  : CRUD App : Update
INPUT		  : NONE
PRE     	  : The contract must be valid and created
OUTPUT		  : A updated version of the contract
POST		  : Redirected back to the main page where the contract will be updated
*****************************************************************************************************************/  
	
	require 'elitedatabase.php';
	$id = null;
	if ( !empty($_GET['contracts.id'])) {
		$id = $_REQUEST['contracts.id'];
	}
	
	if ( null==$id ) {
		header("Location: elite.php");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$cidError = null;
		$sidError = null;
		
		
		// keep track post values
		$customerID = $_POST['customerID'];
		$serviceID = $_POST['serviceID'];
		
		
		// validate input
		$valid = true;
		if (empty($customerID)) {
			$cidError = 'Please enter a Customer ID';
			$valid = false;
		}
		
		if (empty($serviceID)) {
			$sidError = 'Please enter a Service ID';
			$valid = false;
		} 
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE contracts set customerID = ?, serviceID = ? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($customerID,$serviceID));
			Database::disconnect();
			header("Location: elite.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM contracts where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$s_name = $data['customerID'];
		$description = $data['serviceID'];
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
		    			<h3>Update a Contract</h3>
		    		</div>
					<form class="form-horizontal" action="u_contract.php?id=<?php echo $id?>" method="post">
						<div class="control-group <?php echo !empty($cidError)?'error':'';?>">
							<label class="control-label">CustomerID</label>
							<div class="controls">
								<input name="customerID" type="text"  placeholder="CustomerID" value="<?php echo !empty($customerID)?$customerID:'';?>">
								<?php if (!empty($cidError)): ?>
									<span class="help-inline"><?php echo $cidError;?></span>
								<?php endif; ?>
							</div>
						</div>
						
						<div class="control-group <?php echo !empty($sidError)?'error':'';?>">
							<label class="control-label">Description</label>
							<div class="controls">
								<input name="serviceID" type="text" placeholder="ServiceID" value="<?php echo !empty($serviceID)?$serviceID:'';?>">
								<?php if (!empty($sidError)): ?>
									<span class="help-inline"><?php echo $sidError;?></span>
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