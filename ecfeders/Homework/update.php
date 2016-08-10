<?php 
	
	require '../crud/database.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: homework2.php");
	}
	
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
		
		// update data
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
			
           if ($stmt = $conn->prepare("UPDATE registrations  SET class = ?, startTime = ?, endTime =?, day =? WHERE id = ?")){
            $stmt->bind_param("sssss", $class, $startTime, $endTime, $day, $id);
			echo $id;
			$stmt->execute();
			
			$stmt->close();
			}
			$conn->close();
			header("Location: homework2.php");
		} 
		}else {
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
	        if ($stmt = $conn->prepare("SELECT * FROM registrations where id = ?")){
               $stmt->bind_param("s", $id);
			
			   $stmt->execute();
			
			   $stmt->bind_result($id, $class, $startTime, $endTime, $day);
               $stmt->fetch();
			   $stmt->close();
			}
			$conn->close();
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
		    			<h3>Update a Class</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($classError)?'error':'';?>">
					    <label class="control-label">Class</label>
					    <div class="controls">
					      	<input name="class" type="text"  placeholder="Class" value="<?php echo !empty($class)?$class:'';?>">
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
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="homework2.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->

  </body>
</html>