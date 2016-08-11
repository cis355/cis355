<?php
/* ***************************************************************************************************************
 filename     : r_contract.php   
 author       : Chad Betz   
 course       : cis355     
 semester     : Summer 2016   
 description  : This file reads a contract depending on which id is slected.
				
PURPOSE 	  : CRUD App : Read
INPUT		  : id info
PRE     	  : The contract must have information in it
OUTPUT		  : A reading of the contract
POST		  : A page that shows each of the items in the contract is shown
*****************************************************************************************************************/ 	 
	require 'elitedatabase.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: elite.php");
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM contracts where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
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
		    			<h3>Read a Contract</h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">Customer</label>
						     	<?php echo $data['customerID'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Service ID</label>
						     	<?php echo $data['serviceID'];?>
					  </div>
					    <div class="form-actions">
						  <a class="btn" href="elite.php">Back</a>
					   </div>

					</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>