<?php 
 
	session_start();
	if (empty($_SESSION['username'])) header("Location: login.php");
 
	$id = $_GET['id'];
	
	require 'database.php';
	
	# if there was data passed, then insert record, 
	# otherwise do nothing (that is, just display html for create)
	if ( !empty($_POST)) {
		// keep track validation errors
		
		$commentError = null;
		
		// keep track post values
		
		$rating= $_POST['rating'];
		$comment = $_POST['comment'];
		$songID = $id;
		$userID = $_SESSION['id'];
	
		
		
		// validate input
		$valid = true;
		if (empty($comment)) {
			$commentError = 'Please enter a comment';
			$valid = false;
		}
	
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO songRatings (userID, songID, rating, comment) values(?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($userID, $songID, $rating, $comment));
			Database::disconnect();
			header("Location: index.php");
		}
	} # end if(!empty($_POST))
		
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
		    			<h3>Rate Song</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="rate.php" method="post">
					
					  <div class="control-group">
					    <label class="control-label">Rating:</label>
					    <div class="controls">
					      	<select name="rating">
								<option value = "1">1</option>
								<option value = "2">2</option>
								<option value = "3">3</option>
								<option value = "4">4</option>
								<option value = "5">5</option>
							</select>
								
					      	
					    </div>
					  </div>
            
             <div class="control-group <?php echo !empty($commentError)?'error':'';?>">
					    <label class="control-label">Comment</label>
					    <div class="controls">
					      	<textarea name="comment" rows = "6" cols = "40" maxlength = "250" placeholder="This song is super" value="<?php echo !empty($comment)?$comment:'';?>"> </textarea>
					      	<?php if (!empty($commentError)): ?>
					      		<span class="help-inline"><?php echo $commentError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
            
            
            
            </br>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Submit</button>
						  <a class="btn" href="index.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>