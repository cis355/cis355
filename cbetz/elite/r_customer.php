<?php
/* ***************************************************************************************************************
 filename     : r_customer.php   
 author       : Chad Betz   
 course       : cis355     
 semester     : Summer 2016   
 description  : This file reads a customer depending on which id is slected.
				
PURPOSE 	  : CRUD App : Read
INPUT		  : id info
PRE     	  : The customer must have information in it
OUTPUT		  : A reading of the customer
POST		  : A page that shows each of the items in the customer is shown
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
		$sql = "SELECT * FROM customers where id = ?";
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
		    			<h3>Read a Customer</h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">Name</label>
						     	<?php echo $data['name'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Email</label>
						     	<?php echo $data['email'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Phone #</label>
						     	<?php echo $data['mobile'];?>
					  </div>
					    <div class="form-actions">
						  <a class="btn" href="elite.php">Back</a>
					   </div>

					</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>