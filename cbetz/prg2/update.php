<?php 
	
	require 'database.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: prg2.php");
	}
	
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
			$questionError = 'Please enter question';
			$valid = false;
		}
		
		if (empty($category)) {
			$categoryError = 'Please enter category';
			$valid = false;
		}
		
		if (empty($difficulty)) {
			$difficultyError = 'Please enter difficulty';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE questions set question = ?, category = ?, difficulty =? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($question,$category,$difficulty,$id));
			Database::disconnect();
			header("Location: prg1.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM questions where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$question = $data['question'];
		$category = $data['category'];
		$difficulty = $data['difficulty'];
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
		    			<h3>Update a Customer</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
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
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="prg2.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->

  </body>
</html>