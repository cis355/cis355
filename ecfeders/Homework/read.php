<?php 
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: homework2.php");
	} else {
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
			
			if ($stmt = $conn->prepare("SELECT * FROM registrations WHERE id = ?")){
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
		    			<h3>Class Details</h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">Class</label>
						     	<?php echo $class;?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Start Time</label>
						     	<?php echo $startTime;?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">End Time</label>
						     	<?php echo $endTime;?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Days</label>
						     	<?php echo $day;?>
					  </div>
					    <div class="form-actions">
						  <a class="btn" href="homework2.php">Back</a>
					   </div>

					</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>