<?php 
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
		$sql = "SELECT * FROM questions where id = ?";
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
		    			<h3>Read a Question</h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">Question</label>
						     	<?php echo $data['question'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Category</label>
						     	<?php echo $data['category'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Difficulty</label>
						     	<?php echo $data['difficulty'];?>
					  </div>
					    <div class="form-actions">
						  <a class="btn" href="prg2.php">Back</a>
					   </div>

					</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>