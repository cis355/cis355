<?php 
	require 'database.php';
	session_start();
	$_SESSION['cust_id'] = 3;
	//if (empty($_SESSION['cust_id'])) 
	//header('Location: se_login.php'); //redirect
	//session_destroy();

	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: index.php");
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM se_reservations where id = ?";
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
		    			<h3>Read a Reservation</h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">Faculty</label>
						     	<?php echo $data['cust_id'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Date</label>
						     	<?php echo $data['date'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Starting Time</label>
						     	<?php echo $data['start_time'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Ending Time</label>
						     	<?php echo $data['end_time'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Comments</label>
						     	<?php echo $data['comments'];?>
					  </div>
					    <div class="form-actions">
						  <a class="btn" href="se_reservations.php">Back</a>
					   </div>

					</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>
<?php
	echo '<br /><br />';
	show_source(__FILE__);
?>