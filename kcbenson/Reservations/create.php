<?php 
	# Consider three scenarios:
	# 1.User clicked create button on list screen (index.php)
	#		If that happens, then create.php displays entry screen
	# 2. User clicked create button (submit button) on entry screen, but a field was empty
	#		If that happens, an error message shows next to the field
	# 3. User clicked create button (submit button) on entry screen, and all data was valid
	# 		If that happens, the PHP code inserts the record into the database and redirects to the list screen.
	
	# include connection data and functions
	require 'database.php';
	
	session_start();
	$_SESSION['cust_id'] = 3;
	//if (empty($_SESSION['cust_id'])) 
	//header('Location: se_login.php'); //redirect
	
	
	# if there was data passed, then insert the record, otherwise just display the HTML 
	if ( !empty($_POST)) {
		// keep track validation errors
		$dateError = null;
		$sTimelError = null;
		$eTimeError = null;
		$timeError = null;
		
		// keep track post values
		$cust_id = $_SESSION['cust_id'];
		$date = $_POST['date'];
		$sTime = $_POST['start_time'];
		$eTime = $_POST['end_time'];
		$comments = $_POST['comments'];
		
		// validate input
		$valid = true;
		if (empty($date)) {
			$dateError = 'Please enter the date you need this room for.';
			$valid = false;
		}
		
		if (empty($sTime)) {
			$sTimeError = 'Please enter a starting time.';
			$valid = false;
		}
		
		if (empty($eTime)) {
			$eTimeError = 'Please enter an ending time.';
			$valid = false;
		}
		else if (strtotime($eTime) - strtotime($sTime) > 2400) {
			$eTimeError = 'Please enter a time slot no greater than 40 minutes.';
			$valid = false;
		}
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO se_reservations (cust_id, date, start_time, end_time, comments) values(?, ?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($cust_id, $date, $sTime, $eTime, $comments));
			Database::disconnect();
			header("Location: se_reservations.php");
		}
	} #end if ( !empty($_POST))
	session_destroy();
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<!-- The head section does the following: 
		1. Sets the character set
		2. includes Bootstrap
		-->
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Create a Reservation</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="create.php" method="post">
					
					  <div class="control-group <?php echo !empty($dateError)?'error':'';?>">
					    <label class="control-label">Date</label>
					    <div class="controls">
					      	<input name="date" type="date"  placeholder="Date" value="<?php echo !empty($date)?$date:'';?>">
					      	<?php if (!empty($dateError)): ?>
					      		<span class="help-inline"><?php echo $dateError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($sTimeError)?'error':'';?>">
					    <label class="control-label">Start Time</label>
					    <div class="controls">
					      	<input name="start_time" type="time" placeholder="Start Time" value="<?php echo !empty($sTime)?$sTime:'';?>">
					      	<?php if (!empty($sTimeError)): ?>
					      		<span class="help-inline"><?php echo $sTimeError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($eTimeError)?'error':'';?>">
					    <label class="control-label">End Time</label>
					    <div class="controls">
					      	<input name="end_time" type="time"  placeholder="End Time" value="<?php echo !empty($eTime)?$eTime:'';?>">
					      	<?php if (!empty($eTimeError)): ?>
					      		<span class="help-inline"><?php echo $eTimeError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  
					  <div class="control-group">
					    <label class="control-label">Comments</label>
					    <div class="controls">
					      	<input name="comments" type="text"  placeholder="Comments" value="<?php echo !empty($comments)?$comments:'';?>">
					    </div>
					  </div>
					  
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="se_reservations.php">Back</a>
						</div>
					

						
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>
<?php
	echo '<br /><br />';
	show_source(__FILE__);
?>