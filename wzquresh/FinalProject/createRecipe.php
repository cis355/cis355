<?php
//Define how the database connects
require ("database.php");
session_start();
if ( !empty($_POST)) {
  //Member data for the class
  $title;
  $ingredients = array();
  $directions;
  $id = $_SESSION['userID'];

  //foreach ($_POST['ingredients'] as $ingredient){
  //
  //  $doquery = mysql_query("INSERT INTO Recipe(`Ingredients`) VALUES('".$ingredient."')") or die(mysql_error());
  //}
  
  
    $title = $_POST['title'];
    if($_POST){
      foreach($_POST['ingredients[]'] as $ingredient){
        $ingredients[] = $ingredient;
      }
      //$ingredients[] = $_POST['ingredients[]'];
      $commaIngredients = implode(",", $ingredients);
    }
    //$ingredients[] = $_POST['ingredients[]'];
    //$commaIngredients = implode(",", $ingredients);
    $directions = $_POST['directions'];
    $pdo = Database::connect();
    $sql = "INSERT INTO Recipe (userID,recipeTitle,Ingredients,Recipe) values(?, ?, ?, ?)";
    $q = $pdo->prepare($sql);
    $q->execute(array($id,$title,$commaIngredients,$directions));
	  Database::disconnect();
    header("Location: Recipe.php");

show_source(__FILE__);
}
?>

<DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="CSS/createRecipe.css" rel="stylesheet">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="javascript/createRecipe.js"></script>
</head>

<body background="pictures/createRecipeBackground1.jpg">
    <center>
      <div class="container">
        <div class="panel panel-primary">
          <div class="panel-heading">Create Your Recipe</div>
            <form role="form" action="createRecipe.php" method="post">
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
                <button type="submit" class="btn btn-success">Create Recipe</button>
                <a href="Recipe.php" class="btn btn-danger">Back</a>
              </div>
            </form>
        
      </div>
      </div>
    </center>

</body>
</html>