<?php 
	
	require 'database.php';
	
	session_start();
	$_SESSION['cust_id'] = 3;
	//if (empty($_SESSION['cust_id'])) 
	//header('Location: update.php'); //redirect
	//session_destroy();
	
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: se_reservations.php");
	}
	
	if ( !empty($_POST)) {
	// keep track validation errors
	$dateError = null;
	$sTimelError = null;
	$eTimeError = null;
	$timeError = null;
	
	// keep track post values
	//$cust_id = $_SESSION['cust_id'];
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
	
	// update data
	if ($valid) {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "UPDATE se_reservations  SET date = ?, start_time = ?, end_time = ?, comments = ? WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($date, $sTime, $eTime, $comments, $id));
		Database::disconnect();
		header("Location: se_reservations.php");
	}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM se_reservations where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$date = $data['date'];
		$sTime = $data['start_time'];
		$eTime = $data['end_time'];
		$comments = $data['comments'];
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
		    			<h3>Update a Reservation</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
					
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
						  <button type="submit" class="btn btn-success">Update</button>
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