<?php 

	# Consider three scenarios.
	# 1. User clicked create button on list screen (index.php)
	#         If that happens then create.php displays entry screen
	# 2. User clicked create button (submit button) on entry screen but one or more fields were empty
	#         If that happens then error message(s) appears next to empty field(s)
	# 3. User clicked create button (submit button) and all data valid
	#         If that happens then PHP code inserts the record and redirect to list screen (index.php)
	
	# include connection data and functions
	require 'crud/database.php';
	
	# if there was data passed, then insert record, 
	# otherwise do nothing (that is, just display html for create)
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
			$eventDateError = 'Please enter Event Date';
			$valid = false;
		}
		
		if (empty($eventTitle)) {
			$eventTitleError = 'Please enter Event Title';
			$valid = false;
		}
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO Event (eventDate,eventTitle,eventDescription) values(?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($eventDate,$eventTitle,$eventDescription));
			Database::disconnect();
			header("Location: Events.php");
		}
	} # end if ( !empty($_POST))
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
		    			<h3>Add Event</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="createEvent.php" method="post">
					
					  <div class="control-group <?php echo !empty($eventDateError)?'error':'';?>">
					    <label class="control-label">Event Date</label>
					    <div class="controls">
					      	<input name="eventDate" type="date"  placeholder="Date/Time" value="<?php echo !empty($eventDate)?$eventDate:'';?>">
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
					      <input name="eventDescription" type="text"  placeholder="Enter Description" value="<?php echo !empty($eventDescription)?$eventDescription:'';?>">
					    </div>
					  </div>
            
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="Events.php">Back</a>
						</div>
						
					</form>
					
				</div>
				
    </div> <!-- /container -->
  </body>
</html>