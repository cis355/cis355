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
						  <input type="submit" class="button" name="create" value="create" />
						  <a class="btn" href="prg2.php">Back</a>
						</div>
						
					</form>
					
				</div>
				
    </div> <!-- /container -->
  </body>
</html>