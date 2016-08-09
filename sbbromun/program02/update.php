<?php 

	session_start();	
	define('DBHOST', 'localhost'); 
	define('DBNAME', 'sbbromun'); 
	define('DBUSER', 'sbbromun'); 
	define('DBPASS', '592880'); 

	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: program02.php");
	}
	
	if ( !empty($_POST)) {
		// keep track post values
		$questionID = $_POST['questionID'];
		$responseID = $_POST['responseID'];
		$correctResponse = $_POST['correctResponse'];
		$valid =true;
		
		// update data
		if ($valid) {
			$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);  
			$sql = "UPDATE responses set questionID = $questionID, responseID = $responseID, correctResponse = $correctResponse WHERE id = $id"; 
			$connection->query($sql);
			header("Location: program02.php");
		}
	} else {
		$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);  
		$sql = "SELECT * from responses where id = $id"; 
		$result = mysqli_query($connection, $sql);
		$data = mysqli_fetch_assoc($result);
		$questionID = $data['questionID'];
		$responseID = $data['responseID'];
		$correctResponse = $data['correctResponse'];			

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
		    			<h3>Update a Response</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
					  <div class="control-group 
					    <label class="control-label">Question Number</label>
					    <div class="controls">
					      	<input name="questionID" type="text" value="<?php echo !empty($questionID)?$questionID:'';?>">

					    </div>
					  </div>
					  <div class="control-group 
					    <label class="control-label">Response Number</label>
					    <div class="controls">
					      	<input name="email" type="text"  value="<?php echo !empty($responseID)?$responseID:'';?>">
					    </div>
					  </div>
					  <div class="control-group
					    <label class="control-label">Correct?</label>
					    <div class="controls">
					      	<input name="mobile" type="text"  placeholder="0 for false, 1 for true" value="<?php echo !empty($correctResponse)?$correctResponse:'';?>">

					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn btn-primary" href="program02.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->

  </body>
    <?php  show_source(__FILE__);?>
</html>