<?php 

	
	# include connection data and functions
	require 'database.php';
	
	# if there was data passed, then insert record, 
	# otherwise do nothing (that is, just display html for create)
	if ( !empty($_POST)) {
		// keep track validation errors
		$nameError = null;
		
		// keep track post values
		$actorID = $_POST['id'];
		
		// validate input
		$valid = true;
		if (empty($name)) {
			$nameError = 'Please enter Name';
			$valid = false;
		}
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO `mjgrusni`.`films` (`film_id`, `film_name`) VALUES (NULL, ?);";
			$q = $pdo->prepare($sql);
			$q->execute(array($name));
			Database::disconnect();
			header("Location: index.php");
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
		    			<h3>Add a Film to an Actor</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="addFilm.php" method="post">
					
					<div class="span10 offset1">
    		
					<div class="control-group ">
					</div>
					 					  
					<div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						<a class="btn" href="index.php">Back</a>
					</div>
					<?php 
					  echo $_POST;
					  ?>
					
				</div>
		
						
					</form>
					
				</div>
				
    </div> <!-- /container -->
  </body>
</html>