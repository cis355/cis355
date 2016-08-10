<?php
//Recipe Page
//Define how the database connects
require ("database.php");
session_start();

  class Recipe{
       //Displays the records in the database in the form of a table
    //and displays CRUD buttons
    public function displayRecipes () {
      $pdo = Database::connect();
      $sql = 'SELECT * FROM Recipe ORDER BY ID DESC';
      
      echo '<table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>User</th>
              <th>Title</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>';		
      foreach ($pdo->query($sql) as $row) {
        echo '<tr>';
        $sqlName = 'SELECT User.UserName FROM User, Recipe WHERE User.ID = "$userID"';
        $execute = $pdo->prepare($sqlName);
        echo '<td>'. $execute->execute() . '</td>';
        echo '<td>'. $row['recipeTitle'] . '</td>';
        echo '<td width=250>';
        echo '<a class="btn btn-info" href="read.php?id='. $row['ID'].'">Read</a>';
        echo '&nbsp;';
        if ($_SESSION['userID'] == $row['userID']) {
          echo '<a class="btn btn-success" 
             href="CRUD/update.php?id='.$row['ID'].'">Update</a>';
          echo '&nbsp;';
          echo '<a class="btn btn-danger" 
             href="CRUD/delete.php?id='.$row['ID'].'">Delete</a>';
        }
        echo '</td>';
        echo '</tr>';
      }
      echo '</tbody></table>';
      Database::disconnect();
    }
    
    //Displays the create button, links to create.php
    function displayCreateScreen(){
      echo "<a href='Review.php' class='btn btn-danger'>Reviews</a>";
      echo "<a href='createRecipe.php' class='btn btn-primary'>Create Recipe</a>";
    }
    
    function displayHomeScreen(){
      echo "<a href='index.php' class='btn btn-info'>Profile</a><br/>";
    }
    
    //Default constructor
    function __construct () {
    
    }
  }
  
  
  //Header for the CRUD application
echo '<html lang="en">
        <head>
            <meta charset="utf-8">
            <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        </head>';
echo    '<body>';
//Create a new customer object
$recipe = new Recipe;
//Display the button to create a new users
$recipe->displayCreateScreen();
$recipe->displayHomeScreen();
//Display the records
echo '<div class="container">';
  echo '<div class="panel panel-primary">';
    echo '<div class="panel-heading">Records Table</div>';
    echo '<div class="panel-body">';
      $recipe->displayRecipes();
    echo '</div>';
  echo '</div>';
echo '</div>';

echo '</body>';
echo '</html>';
  
?>