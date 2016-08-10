<?php 
	require 'crud/database.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: Events.php");
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM Event where id = ?";
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
		    			<h3>Event Details</h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">Event Date</label>
						     	<?php echo $data['eventDate'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Event Title</label>
						     	<?php echo $data['eventTitle'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Event Description</label>
						     	<?php echo $data['eventDescription'];?>
					  </div>
					    <div class="form-actions">
						  <a class="btn" href="Events.php">Back</a>
					   </div>

					</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>