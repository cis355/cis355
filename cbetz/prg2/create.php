<?php
	# Consider three scenarios.
	# 1. User clicked create button on list screen (index.php)
	#         If that happens then create.php displays entry screen
	# 2. User clicked create button (submit button) on entry screen but one or more fields were empty
	#         If that happens then error message(s) appears next to empty field(s)
	# 3. User clicked create button (submit button) and all data valid
	#         If that happens then PHP code inserts the record and redirect to list screen (index.php)
	
	# include connection data and functions
	require 'database.php';
	
	# if there was data passed, then insert record, 
	# otherwise do nothing (that is, just display html for create)
    if ( !empty($_POST)) {
    		// keep track validation errors
    		$questionError = null;
    		$categoryError = null;
    		$difficultyError = null;
    		
    		// keep track post values
    		$question = $_POST['question'];
    		$category = $_POST['category'];
    		$difficulty = $_POST['difficulty'];
    		
    		// validate input
    		$valid = true;
    		if (empty($question)) {
    			$questionError = 'Please enter a Question';
    			$valid = false;
    		}
    		
    		if (empty($category)) {
    			$categoryError = 'Please enter a Category';
    			$valid = false;
    		}
    		
    		if (empty($difficulty)) {
    			$difficultyError = 'Please enter a difficulty';
    			$valid = false;
    		}
    		
    		// insert data
    		if ($valid) {
    			$pdo = Database::connect();
    			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    			$sql = "INSERT INTO questions (question,category,difficulty) values(?, ?, ?)";
    			$q = $pdo->prepare($sql);
    			$q->execute(array($question,$category,$difficulty));
    			Database::disconnect();
    			header("Location: prg2.php");
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
		    			<h3>Create a Question</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="create.php" method="post">
					
					  <div class="control-group <?php echo !empty($questionError)?'error':'';?>">
					    <label class="control-label">Question</label>
					    <div class="controls">
					      	<input name="question" type="text"  placeholder="Question" value="<?php echo !empty($question)?$question:'';?>">
					      	<?php if (!empty($questionError)): ?>
					      		<span class="help-inline"><?php echo $questionError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($categoryError)?'error':'';?>">
					    <label class="control-label">Category</label>
					    <div class="controls">
					      	<input name="category" type="text" placeholder="Category" value="<?php echo !empty($category)?$category:'';?>">
					      	<?php if (!empty($categoryError)): ?>
					      		<span class="help-inline"><?php echo $categoryError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($difficultyError)?'error':'';?>">
					    <label class="control-label">Difficulty</label>
					    <div class="controls">
					      	<input name="difficulty" type="text"  placeholder="Difficulty" value="<?php echo !empty($difficulty)?$difficulty:'';?>">
					      	<?php if (!empty($difficultyError)): ?>
					      		<span class="help-inline"><?php echo $difficultyError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
				
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="prg2.php">Back</a>
						</div>
						
					</form>
					
				</div>
				
    </div> <!-- /container -->
  </body>
</html>