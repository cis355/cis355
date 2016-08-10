<?php 
	require 'databaseProject.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: project.php");
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT businesses.name As busName, workers.name As workerName, sheet.grill1 As grill1, 
		sheet.grill2 As grill2, sheet.fryer1 As fryer1 , sheet.fryer2 As fryer2, 
		sheet.creamer As creamer, sheet.dateMod As dateMod FROM sheet 
		INNER JOIN workers ON workers.id = sheet.worker_id
			INNER JOIN businesses ON businesses.id = sheet.buss_id where sheet.id = ?";
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
		    			<h3>Food Safety Sheet</h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">Business Name: </label>
						     	<?php echo $data['busName'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Worker Name: </label>
						     	<?php echo $data['workerName'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Grill 1: </label>
						     	<?php echo $data['grill1'] . ' &#8457';?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Grill 2: </label>
						     	<?php echo $data['grill2'] . ' &#8457';?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Fryer 1: </label>
						     	<?php echo $data['fryer1'] . ' &#8457';?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Fryer 2: </label>
						     	<?php echo $data['fryer2'] . ' &#8457';?>
					  </div>
					   <div class="control-group">
					    <label class="control-label">Creamer: </label>
						     	<?php echo $data['creamer'] . ' &#8457';?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Date and Time: </label>
						     	<?php echo $data['dateMod'];?>
					  </div>
					  
					    <div class="form-actions">
						  <a class="btn" href="project.php">Back</a>
					   </div>

					</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>