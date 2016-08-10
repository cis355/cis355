<?php 
	
	session_start();
	
	require 'database.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: camps.php");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$userNameError = null;
		$userNumberError = null;

		
		
		// keep track post values
		$userName = $_POST['userName'];
		$userNumber = $_POST['userNumber'];

		
		
		// validate input
		$valid = true;
		if (empty($userName)) {
			$userNameError = 'Please enter User Name';
			$valid = false;
		}
		
		if (empty(userNumber)) {
			$userNumberError = 'Please enter user Number';
			$valid = false;
		}
		
	
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE campUser  set userName = ?, userNumber = ? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($userName,$userNumber,$id));
			Database::disconnect();
			header("Location: camps2.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM campUser where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$userName = $data['userName'];
		$userNumber = $data['userNumber'];
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
    		
	    			<form class="form-horizontal" action="update3.php?id=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($userNameError)?'error':'';?>">
					    <label class="control-label">User Name</label>
					    <div class="controls">
					      	<input name="userName" type="text"  placeholder="user Name" value="<?php echo !empty($userName)?$userName:'';?>">
					      	<?php if (!empty($userNameError)): ?>
					      		<span class="help-inline"><?php echo $userNameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($userNumberError)?'error':'';?>">
					    <label class="control-label">User Number</label>
					    <div class="controls">
					      	<input name="userNumber" type="text" placeholder="userNumber" value="<?php echo !empty($userNumber)?$userNumber:'';?>">
					      	<?php if (!empty($userNumberError)): ?>
					      		<span class="help-inline"><?php echo $userNumberError;?></span>
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