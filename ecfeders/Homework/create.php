<?php
     
 
    if ( !empty($_POST)) {
		// keep track validation errors
		$classError = null;
		$startTimeError = null;
		$endTimeError = null;
		$dayError = null;
		
		// keep track post values
		$class = $_POST['class'];
		$startTime = $_POST['startTime'];
		$endTime = $_POST['endTime'];
		$day = $_POST['day'];
		
		// validate input
		$valid = true;
		if (empty($class)) {
			$classError = 'Please enter a class';
			$valid = false;
		}
		
		if (empty($startTime)) {
			$startTimeError = 'Please enter a Time 16:00';
			$valid = false;
		}
		if (empty($endTime)) {
			$endTimeError = 'Please enter a Time 16:00';
			$valid = false;
		}
		
		if (empty($day)) {
			$dayError = 'Please Enter Day M/W or T/Th';
			$valid = false;
		}
         
        // insert data
        if ($valid) {
			$servername = "localhost";
			$username = "ecfeders";
			$password = "Nurseal5";
			$dbname = "ecfeders";
			
			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			} 
			
			$stmt = $conn->prepare("INSERT INTO registrations (class, startTime, endTime, day) VALUES (?, ?, ?,?)");
            $stmt->bind_param("ssss", $class, $startTime, $endTime, $day);
			
			$stmt->execute();
			
			$stmt->close();
			$conn->close();
			header("Location: homework2.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Create a Customer</h3>
                    </div>
             
                    <form class="form-horizontal" action="create.php" method="post">
                      <div class="control-group <?php echo !empty($classError)?'error':'';?>">
					    <label class="control-label">Class</label>
					    <div class="controls">
					      	<input name="class" type="text"  placeholder="class" value="<?php echo !empty($class)?$class:'';?>">
					      	<?php if (!empty($classError)): ?>
					      		<span class="help-inline"><?php echo $classError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($startTimeError)?'error':'';?>">
					    <label class="control-label">Start Time</label>
					    <div class="controls">
					      	<input name="startTime" type="text" placeholder="Start Time" value="<?php echo !empty($startTime)?$startTime:'';?>">
					      	<?php if (!empty($startTimeError)): ?>
					      		<span class="help-inline"><?php echo $startTimeError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($endTimeError)?'error':'';?>">
					    <label class="control-label">End Time</label>
					    <div class="controls">
					      	<input name="endTime" type="text" placeholder="End Time" value="<?php echo !empty($endTime)?$endTime:'';?>">
					      	<?php if (!empty($endTimeError)): ?>
					      		<span class="help-inline"><?php echo $endTimeError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($dayError)?'error':'';?>">
					    <label class="control-label">Days</label>
					    <div class="controls">
					      	<input name="day" type="text"  placeholder="Days" value="<?php echo !empty($day)?$day:'';?>">
					      	<?php if (!empty($dayError)): ?>
					      		<span class="help-inline"><?php echo $dayError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Create</button>
                          <a class="btn" href="homework2.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>
        