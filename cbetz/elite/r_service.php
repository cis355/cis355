<?php
/* ***************************************************************************************************************
 filename     : r_service.php   
 author       : Chad Betz   
 course       : cis355     
 semester     : Summer 2016   
 description  : This file reads a service depending on which id is slected.
				
PURPOSE 	  : CRUD App : Read
INPUT		  : id info
PRE     	  : The service must have information in it
OUTPUT		  : A reading of the service
POST		  : A page that shows each of the items in the serialize is shown
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
		$sql = "SELECT * FROM services where id = ?";
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
		    			<h3>Read a Service</h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">Service</label>
						     	<?php echo $data['s_name'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Description</label>
						     	<?php echo $data['description'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Price</label>
						     	<?php echo $data['price'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Date</label>
						     	<?php echo $data['date'];?>
					  </div>
					    <div class="form-actions">
						  <a class="btn" href="elite.php">Back</a>
					   </div>

					</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>