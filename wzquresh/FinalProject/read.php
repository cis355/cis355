<?php
//Page: Read a Recipe.
//Purpose: Display the recipe and ingredients.
//Info: Displays the recipe who's ID was passed.

	require 'database.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
  //If no ID return to Recipe page
	if ( null==$id ) {
		header("Location: Recipe.php");
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM Recipe where ID = ?";
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
		    			<h3>Recipe Details</h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">Title</label>
						     	<?php echo $data['recipeTitle'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Ingredients</label>
						     	<?php echo $data['Ingredients'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Directions</label>
						     	<?php echo $data['Recipe'];?>
					  </div>
					    <div class="form-actions">
						  <a class="btn" href="Recipe.php">Back</a>
					   </div>

					</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>