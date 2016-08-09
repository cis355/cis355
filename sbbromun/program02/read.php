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
    $sql = "SELECT * FROM responses WHERE id = $id"; 
	$result = mysqli_query($connection, $sql);
	$data = mysqli_fetch_assoc($result);
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
		    			<h3>Read a Response</h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">Question Number</label>
						     	<?php echo $data['questionID'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Response Number</label>
						     	<?php echo $data['responseID'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Correct?</label>
						     	<?php if($data['correctResponse'] == 0) {
								echo "False";}
								else {echo "True";}?>
					  </div>
					    <div class="form-actions">
						  <a class="btn btn-primary" href="program02.php">Back</a>
					   </div>

					</div>
				</div>
				
    </div> <!-- /container -->
  </body>
    <?php  show_source(__FILE__);?>
</html>