<?php
//Page: Reviews for recipes.
//Purpose: Displays the reviews for the recipes.
//Info: Displays all the reviews in the Rating table.

//Define how the database connects
require ("database.php");
session_start();

  class Review{
    
    //Purpose: Display reviews in a table.
    //Input: None.
    //Precondition: None.
    //Output: Table.
    //Postcondition: A table of all the reviews, with CRUD buttons.
    public function displayReviews () {
      $pdo = Database::connect();
      $sql = 'SELECT * FROM Rating';
      
      echo '<table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>User</th>
              <th>Recipe</th>
              <th>Review</th>
              <th>Tips</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>';		
      foreach ($pdo->query($sql) as $row) {
        echo '<tr>';
        echo '<td>'. $row['UserID'] . '</td>';
        echo '<td>'. $row['RecipeID'] . '</td>';
        echo '<td>'. $row['Rating'] . '</td>';
        echo '<td>'. $row['Tips'] . '</td>';
        echo '<td width=250>';
        echo '<a class="btn btn-info" href="readReview.php?id='. $row['id'].'">Read</a>';
        echo '&nbsp;';
        echo $_SESSION['userID'] . " and " . $row['userID'];
        if ($_SESSION['userID'] == $row['userID']) {
          echo '<a class="btn btn-success" 
             href="updateReview.php?id='.$row['id'].'">Update</a>';
          echo '&nbsp;';
          echo '<a class="btn btn-danger" 
             href="deleteReview.php?id='.$row['id'].'">Delete</a>';
        }
        echo '</td>';
        echo '</tr>';
      }
      echo '</tbody></table>';
      Database::disconnect();
    }
    
    //Purpose: Display buttons for the other pages.
    function displayButtons(){
      echo "<a href='createReview.php' class='btn btn-danger'>Add Review</a>";
      echo "<a href='index.php' class='btn btn-info'>Profile</a><br/>";
      echo "<a href='Recipe.php' class='btn btn-success'>Recipes</a>";
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
//Create a new Review object
$review = new Review;
//Displays buttons for other pages
$review->displayButtons();
//Display the reviews
echo '<div class="container">';
  echo '<div class="panel panel-primary">';
    echo '<div class="panel-heading">Reviews</div>';
    echo '<div class="panel-body">';
      $recipe->displayReviews();
    echo '</div>';
  echo '</div>';
echo '</div>';

echo '</body>';
echo '</html>';
?>