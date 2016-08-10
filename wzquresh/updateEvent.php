<?php 
	
	require 'crud/database.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: Events.php");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$eventDateError = null;
		$eventTitleError = null;
		
		// keep track post values
		$eventDate = $_POST['eventDate'];
		$eventTitle = $_POST['eventTitle'];
		$eventDescription = $_POST['eventDescription'];
		
		// validate input
		$valid = true;
		if (empty($eventDate)) {
			$eventDateError = 'Please enter Date';
			$valid = false;
		}
		
		if (empty($eventTitle)) {
			$eventTitleError = 'Please enter Event Title';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE Event  set eventDate = ?, eventTitle = ?, eventDescription =? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($eventDate,$eventTitle,$eventDescription,$id));
			Database::disconnect();
			header("Location: Events.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM Event where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$eventDate = $data['eventDate'];
		$eventTitle = $data['eventTitle'];
		$eventDescription = $data['eventDescription'];
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
		    			<h3>Update Event</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="updateEvent.php?id=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($eventDateError)?'error':'';?>">
					    <label class="control-label">Event Date</label>
					    <div class="controls">
					      	<input name="eventDate" type="date"  placeholder="Date" value="<?php echo !empty($eventDate)?$eventDate:'';?>">
					      	<?php if (!empty($eventDateError)): ?>
					      		<span class="help-inline"><?php echo $eventDateError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
            
					  <div class="control-group <?php echo !empty($eventTitleError)?'error':'';?>">
					    <label class="control-label">Event Title</label>
					    <div class="controls">
					      	<input name="eventTitle" type="text" placeholder="Event Title" value="<?php echo !empty($eventTitle)?$eventTitle:'';?>">
					      	<?php if (!empty($eventTitleError)): ?>
					      		<span class="help-inline"><?php echo $eventTitleError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
            
					  <div class="control-group">
					    <label class="control-label">Event Description</label>
					    <div class="controls">
					      	<input name="eventDescription" type="text"  placeholder="Description" value="<?php echo !empty($eventDescription)?$eventDescription:'';?>">
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="Events.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->

  </body>
</html>