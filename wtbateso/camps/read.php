<?php 
	
	session_start();
	//if (empty($_SESSION['name'])) header("Location: login.php");

	require 'database.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: index.php");
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM campRating where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
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
		    			<h3>Read a Customer</h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">User Name</label>
						     	<?php echo $data['userName'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Camp Name</label>
						     	<?php echo $data['campName'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Rating</label>
						     	<?php echo $data['rating'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Comments</label>
						     	<?php echo $data['commets'];?>
					  </div>
					    <div class="form-actions">
						  <a class="btn" href="camps.php">Back</a>
					   </div>

					</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>