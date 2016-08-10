<?php
//Review Page
//Define how the database connects
require ("database.php");
session_start();

  class Review{
       //Displays the records in the database in the form of a table
    //and displays CRUD buttons
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
//Create a new customer object
$review = new Review;
//Display the button to create a new users
$review->displayButtons();
//Display the records
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