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
	
	$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);  
    $sql = "DELETE FROM responses WHERE id = $id"; 
	$connection->query($sql);
	header("Location: program02.php");
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
		    			<h3>Delete a Response</h3>
		    		</div>
		    		
	    			<form class="form-horizontal" action="delete.php" method="post">
	    			  <input type="hidden" name="id" value="<?php echo $id;?>"/>
					  <p class="alert alert-error">Are you sure to delete ?</p>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-danger">Yes</button>
						  <a class="btn btn-primary" href="program02.php">No</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
  <?php  show_source(__FILE__);?>
</html>