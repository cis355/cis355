<?php 
	
	session_start();
	
	require 'database.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: camps2.php");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$userNameError = null;
		$campNameError = null;
		$ratingError = null;
		$commentsError = null;
		
		// keep track post values
		$userName = $_POST['userName'];
		$campName = $_POST['campName'];
		$rating = $_POST['rating'];
		$comments = $_POST['comments'];
		
		// validate input
		$valid = true;
		if (empty($userName)) {
			$userNameError = 'Please enter User Name';
			$valid = false;
		}
		
		if (empty($campName)) {
			$campNameError = 'Please enter Camp Name';
			$valid = false;
		}
		
		if (empty($rating)) {
			$ratingError = 'Please enter Rating';
			$valid = false;
		}
		
		if (empty($comments)) {
			$commentsError = 'Please enter comments';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE campRating  set userName = ?, campName = ?, rating =?, comments=? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($userName,$campName,$rating,$comments,$id));
			Database::disconnect();
			header("Location: camps2.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM campRating where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$userName = $data['userName'];
		$campName = $data['campName'];
		$rating = $data['rating'];
		$comments = $data['comments'];
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
    		
	    			<form class="form-horizontal" action="update4.php?id=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($userNameError)?'error':'';?>">
					    <label class="control-label">User Name</label>
					    <div class="controls">
					      	<input name="userName" type="text"  placeholder="user Name" value="<?php echo !empty($userName)?$userName:'';?>">
					      	<?php if (!empty($userNameError)): ?>
					      		<span class="help-inline"><?php echo $userNameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($campNameError)?'error':'';?>">
					    <label class="control-label">Camp Name</label>
					    <div class="controls">
					      	<input name="campName" type="text" placeholder="Camp Name" value="<?php echo !empty($campName)?$campName:'';?>">
					      	<?php if (!empty($campNameError)): ?>
					      		<span class="help-inline"><?php echo $campNameError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($ratingError)?'error':'';?>">
					    <label class="control-label">rating</label>
					    <div class="controls">
					      	<input name="rating" type="text"  placeholder="rating" value="<?php echo !empty($rating)?$rating:'';?>">
					      	<?php if (!empty($ratingError)): ?>
					      		<span class="help-inline"><?php echo $ratingError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($commentsError)?'error':'';?>">
					    <label class="control-label">comments</label>
					    <div class="controls">
					      	<input name="comments" type="text"  placeholder="comments" value="<?php echo !empty($comments)?$comments:'';?>">
					      	<?php if (!empty($commentsError)): ?>
					      		<span class="help-inline"><?php echo $commentsError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="camps2.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->

  </body>
</html>