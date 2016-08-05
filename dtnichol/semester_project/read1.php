<?php
session_start();
if (empty($_SESSION['id'])) header("Location: login1.php"); //redirect

?>

<?php 
	require 'database.php';
	$thisRestaurant = null;
		if ( !empty($_POST)) {
		// keep track validation errors
		
		
		
		
		// keep track post values
		
		
		$thisRestaurant = $_POST['restaurant'];
		
		print_r($_POST);
		print_r($_SESSION);
		
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = 'SELECT * FROM `ratings1` INNER JOIN `restaurant` WHERE restaurant.id = ratings1.restaurantID';;
		$q = $pdo->prepare($sql);
		$q->execute(array($thisRestaurant));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();
		
		
		
		
	} // end if (!empty($_POST))
	else {
		
		$thisRestaurant = $_GET['id'];
		
			$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = 'SELECT * FROM `ratings1` INNER JOIN `restaurant` WHERE restaurant.id = ratings1.restaurantID';;
		$q = $pdo->prepare($sql);
		$q->execute(array($thisRestaurant));
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
		    			<h3>Read a Customer</h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">Name</label>
						     	<?php echo $data['venueName'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Rating</label>
						     	<?php echo $data['rating'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Reviews</label>
						     	<?php echo $data['review'];?>
					  </div>
					    <div class="form-actions">
						  <a class="btn" href="restaurant.php">Back</a>
					   </div>
					<input type="hidden" name="restaurant" value="<?php echo $thisRestaurant; ?>" />
					</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>