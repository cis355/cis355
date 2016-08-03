





<?php 

	session_start();
	if (empty($_SESSION['id'])) header("Location: login1.php"); //redirect

	//consider three scenarios. 
	//1. user clicked the create buttong on the list screen (index.php)
	//		if that happens then create.php displays blank entry screen
	//2. User clicked the create button (submit button) on the entry screen but one or more fields were empty
	//		If that happens then error message appears nexxt to empty field(s)
	//3. User clicked create button (submit button) and all data valid
	//		If that happens then the PHP code inserts the record and redirects to the list screen (index.php)
	
	// include connection data and functions
	require ('database.php');
	
	//if there was data passed, then insert the record, otherwise do nothing (that is, just display html)
	if ( !empty($_POST)) {
		// keep track validation errors
		$rateError = null;
		$reviewError = null;
		
		
		
		// keep track post values
		$rating = $_POST['rating'];
		$review = $_POST['review'];
		$thisCustomer = $_SESSION['id'];
		$thisRestaurant = $_POST['restaurant'];
		
		print_r($_POST);
		print_r($_SESSION);
		
		
		
		// validate input
		$valid = true;
		if (empty($rating)) {
			$rateError = 'Please enter a Rating out of 10';
			$valid = false;
		}
		
		if (empty($review)) {
			$reviewError = 'Please enter your review';
			$valid = false;
		} 
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO ratings1 (customers1ID,restaurantID,rating,review) VALUES ($thisCustomer,$thisRestaurant,$rating, '$review')";
			$q = $pdo->prepare($sql);
			var_dump ($q);
			$q->execute(array($thisCustomer,$thisRestaurant,$rating,$review));
			Database::disconnect();
			header("Location: restaurant.php");
		}
	} // end if (!empty($_POST))
	else {
		$thisCustomer = $_SESSION['id'];
		$thisRestaurant = $_GET['id'];
		
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
		    			<h3>Rate and Review</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="createRating.php" method="post">
					
					  <div class="control-group <?php echo !empty($rateError)?'error':'';?>">
					    <label class="control-label">Rating out of 10</label>
					    <div class="controls">
					      	<input name="rating" type="text"  placeholder="Rating" value="<?php echo !empty($rating)?$rating:'';?>">
					      	<?php if (!empty($rateError)): ?>
					      		<span class="help-inline"><?php echo $rateError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($reviewError)?'error':'';?>">
					    <label class="control-label">Review</label>
					    <div class="controls">
					      	<textarea name="review" type="textarea" placeholder="Review" rows="4" cols="25" value="<?php echo !empty($review)?$review:'';?>"></textarea>
					      	<?php if (!empty($reviewError)): ?>
					      		<span class="help-inline"><?php echo $reviewError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					 
					  <input type="hidden" name="restaurant" value="<?php echo $thisRestaurant; ?>" />
					  
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Submit</button>
						  <a class="btn" href="restaurant.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>