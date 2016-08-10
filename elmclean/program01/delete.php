<?php
	session_start();
	if(empty($_SESSION['name'])) header("Location: login.php");
?>

<?php 
	require 'database.php';
	
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( !empty($_POST)) {
		// keep track post values
		$id = $_POST['id'];
		
		// delete data
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql1 = "DELETE FROM ratings WHERE customerID = ?";
		$sql2 = "DELETE FROM customers WHERE id = ?";
		$q1 = $pdo->prepare($sql1);
		$q1->execute(array($id));

		$q2 = $pdo->prepare($sql2);
		$q2->execute(array($id));

		Database::disconnect();
		header("Location: program1.php"); 
		
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
		    			<h3>Delete a Customer</h3>
		    		</div>
		    		
	    			<form class="form-horizontal" action="delete.php" method="post">
	    			  <input type="hidden" name="id" value="<?php echo $id;?>"/>
					  <p class="alert alert-error">Are you sure to delete ?</p>
					  <div class="form-actions">
						  <br><button type="submit" class="btn btn-danger">Yes</button>
						  <a class="btn btn-primary" href="program1.php">No</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>