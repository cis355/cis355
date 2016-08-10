<?php 
	
	require 'database.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: Recipe.php");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$nameError = null;
		$emailError = null;
		$mobileError = null;
		
		// keep track post values
		$name = $_POST['name'];
		$email = $_POST['email'];
		$mobile = $_POST['mobile'];
		
		// validate input
		$valid = true;
		if (empty($name)) {
			$nameError = 'Please enter Name';
			$valid = false;
		}
		
		if (empty($email)) {
			$emailError = 'Please enter Email Address';
			$valid = false;
		} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$emailError = 'Please enter a valid Email Address';
			$valid = false;
		}
		
		if (empty($mobile)) {
			$mobileError = 'Please enter Mobile Number';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      (userID,recipeTitle,Ingredients,Recipe) values(?, ?, ?, ?)
			$sql = "UPDATE customers  set recipeTitle = ?, Ingredients = ?, Recipe =? WHERE ID = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($title,$ingredients,$directions,$id));
			Database::disconnect();
			header("Location: Recipe.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM Recipe where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$name = $data['recipeTitle'];
		$email = $data['Ingredients'];
		$mobile = $data['Recipe'];
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
		    			<h3>Update Recipe</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
            <label>Title</label>
            <input type="text" name="title"><br/>
              <label>Ingredients</label>
                <div class="multi-field-wrapper">
                  <div class="multi-fields">
                    <div class="multi-field">
                      <input type="text" name="ingredients[]">
                      <button type="button" class="remove-field">Remove Ingredient</button>
                    </div>
                  </div>
                  <button type="button" class="add-field">Add Ingredient</button>
                </div>
                
              <textarea class="form-control" rows="5" name="directions" placeholder="Directions" style="width: 50%"></textarea>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="Recipe.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->

  </body>
</html>