<?php 

	session_start();
	if (empty($_SESSION['name'])) header("Location: login.php");

	
	# Consider three scenarios.
	# 1. User clicked create button on list screen (index.php)
	#		If that happens then create.php displays entry screen
	# 2. User clicked create button (submit button) on entry but one or more fields were empty
	#		If that happens then error message(s) appears next to empty field(s)
	# 3. User clicked create button (submit button) and all data valid
	#		If that happens then PHP code inserts the record and redirect to list screen (index.php)
	
	# includes connection to database and functions
	require '../crud/database.php';
	
	# if there is data passed, then insert record, otherwise do nothing 
	if ( !empty($_POST)) {
		// keep track validation errors
		$userNameError = null;
		$nameError = null;
		$ratingError = null;
		$commentsError = null;
		
		// keep track post values
		$userName = $_POST['userName'];
		$name = $_POST['name'];
		$rating = $_POST['rating'];
		$comments = $_POST['comments'];
		
		// validate input
		$valid = true;
		if (empty($userName)) {
			$userNameError = 'Please enter your User Name';
			$valid = false;
		}
		if (empty($name)) {
			$nameError = 'Please enter Name';
			$valid = false;
		}
		
		if (empty($rating)) {
			$ratingError = 'Please enter rating';
			$valid = false;
		} else if ( !filter_var($rating,FILTER_VALIDATE_INT, array("options" => array("min_range"=>0, "max_range"=>5))) ) {
			$ratingError = 'Please enter a valid rating';
			$valid = false;
		}
		
		if (empty($comments)) {
			$commentsError = 'Please enter comments';
			$valid = false;
		}
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO campRating (userName,campName,rating,comments) values(?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($userName,$name,$rating,$comments));
			Database::disconnect();
			header("Location: camps.php");
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
		    			<h3>Create a Rating</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="create.php" method="post">
					<div class="control-group <?php echo !empty($userNameError)?'error':'';?>">
					    <label class="control-label">User Name</label>
					    <div class="controls">
					      	<input name="userName" type="text"  placeholder="User Name" value="<?php echo !empty($userName)?$userName:'';?>">
					      	<?php if (!empty($userNameError)): ?>
					      		<span class="help-inline"><?php echo $userNameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					    <label class="control-label">Camp Name</label>
					    <div class="controls">
					      	<input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
					      	<?php if (!empty($nameError)): ?>
					      		<span class="help-inline"><?php echo $nameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($ratingError)?'error':'';?>">
					    <label class="control-label">Rating (0 - 5)</label>
					    <div class="controls">
					      	<input name="rating" type="text" placeholder="rating" value="<?php echo !empty($rating)?$rating:'';?>">
					      	<?php if (!empty($ratingError)): ?>
					      		<span class="help-inline"><?php echo $ratingError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($commentsError)?'error':'';?>">
					    <label class="control-label">Comments</label>
					    <div class="controls">
					      	<input name="comments" type="text"  placeholder="Comments" value="<?php echo !empty($comments)?$comments:'';?>">
					      	<?php if (!empty($commentsError)): ?>
					      		<span class="help-inline"><?php echo $commentsError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="camps.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>