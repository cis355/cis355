<?php 
	session_start();
	if (empty($_SESSION['name'])) header("Location: se_login.php"); // redirect
	require 'database.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: index.php");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$questionError = null;
		
		// keep track post values
		$question = $_POST['question'];
		$custID = $_SESSION['name'];
		$id = $_POST['id'];
		
		// validate input
		$valid = true;
		if (empty($question)) {
			$questionError = 'Please enter a question';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();		
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE se_questions SET question = ? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($question, $id));
			Database::disconnect();
			header("Location: se_index.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM se_questions WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$question = $data['question'];
		$id = $data['id'];
		$custID = $data['cust_id'];
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
		    			<h3>Update a Question</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="se_update.php?id=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($questionError)?'error':'';?>">
					    <label class="control-label">Question</label>
					    <div class="controls">
							<input name = "id" value="<?php echo !empty($id)?$id:'';?>" hidden /> <br />
					      	<input name="question" type="text"  placeholder="Question" value="<?php echo !empty($question)?$question:'';?>">
					      	<?php if (!empty($questionError)): ?>
					      		<span class="help-inline"><?php echo $questionError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="se_index.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->

	<?php
		echo "<br /><br /><br /><br />";
		show_source(__FILE__);
	?>
	
  </body>
</html>