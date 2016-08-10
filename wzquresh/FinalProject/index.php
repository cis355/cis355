<?php
  /*CIS355
   *Final Project
   *Waqas Qureshi
   *Food for Fun
   *Page: Index
   *Description: The goals of this application are to create a social media site directed
   * at individuals who like to create recipes and would like to collaborate with others
   * in the pursuit of food.
  */
  
  //On session start redirect to login page
  session_start();
  if(empty($_SESSION['username'])) header("Location: login.php");

include 'database.php';
  
  class Profile{
    private $firstName;
    private $lastName;
    private $recipes;
    private $diet;
    private $favFood;
    private $username;
    private $userID;
    
    //Purpose: Gets the user's ID from User table
    // this is used in later functions to get user's database.
    //Input: None.
    //Precondition: $_SESSION['username'] should be set.
    //Output: None.
    //Postcondition: $userID should be set.
    public function getID(){
      $pdo = Database::connect();
      $username = $_SESSION['username'];
      //echo $username;
      $sql = 'SELECT ID FROM User WHERE UserName = $username'; //Issues with this sql statement
      $q = $pdo->prepare($sql);
      $userID = $q->execute();//gets userID from database
      
      //$userID = $_SESSION['userID'];
      echo $username;
      echo $userID;
      //echo $userID['ID'];
      //echo $username;
      //Use userID to get the users recipes
      Database::disconnect();
    }
    
    //Purpose: Gets the user's personal data.
    //Input: None.
    //Precondition: $userID should be set.
    //Output: None.
    //Postcondition: All private data should be set.
    public function getPersonData(){
      $pdo = Database::connect();
      $sql = 'SELECT * FROM User WHERE ID = $username';
      $q = $pdo->prepare($sql);
      $s = $q->execute();
      $firstName = $s['firstName'];
      $lastName = $s['lastName'];
      $diet = $s['DietType'];
      $favFood = $s['FavoriteFood'];
      Database::disconnect();
    }
    
    //Purpose: Return the user's personal data in a table.
    //Input: None.
    //Precondition: private data should be set.
    //Output: Table.
    //Postcondition: User's profile table should display.
    public function displayPersonData(){
      echo '<div class="container col-lg-3 col-md-3 col-sm-3 col-sx-12">';
        echo '<div class="panel panel-primary">';
          echo '<div class="panel-heading">Profile Info</div>';
          echo '<div class="panel-body">';
            echo '<table class="table table-striped table-bordered"><tbody>';
            echo '<tr>';
            echo '<td>'. $firstName . ' ' . $lastName . '</td>';
            echo '</tr>';
 
            echo '<tr>';
            echo '<td>Diet</td>';
            echo '<td>' . $diet . '</td>';
            echo '</tr>';
            
            echo '<tr>';
            echo '<td>Favorite Food</td>';
            echo '<td>' . $favFood . '</td>';
            echo '</tr>';
            
            echo '</tbody></table>';
          echo '</div>';
        echo '</div>';
      echo '</div>';
    }
    
    //Purpose: Display a list of user's recipes
    //Input: None.
    //Precondition: $userID should be set.
    //Output: Table.
    //Postcondition: Display's table of user's recipes.
    public function displayRecipes(){
      $pdo = Database::connect();
      $sql = "SELECT * FROM Recipe WHERE userID = $userID";
      
      echo '<table class="table table-striped table-bordered">
				<thead>
          <tr>
            <th>Title</th>
          </tr>
			  </thead>
			  <tbody>';	
      
      foreach($pdo->query($sql) as $row){
        
        echo '<tr>';
        echo '<td>'. $row['recipeTitle'] . '</td>';
        echo '</tr>';
      }
      echo '</tbody></table>';
      Database::disconnect();
    }
    
    //Purpose: Display buttons for other pages in application.
    public function displayButtons(){
      echo '<a href="Recipe.php" class="btn btn-success">Recipes</a>';
      echo '<a href="logout.php" class="btn btn-danger">Logout</a><br/>';
    }
    
    //Default constructor
    function __construct () {
    
    }
  }
  
  //Output the website headers
  echo '<html lang="en">
        <head>
            <meta charset="utf-8">
            <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        </head>';
  echo    '<body>';
  //Create a new profile object
  $prof = new Profile;
  $prof->getID();
  $prof->displayButtons();
  $prof->getPersonData();
  $prof->displayPersonData();
  //Display the recipes
  echo '<div class="container col-lg-3 col-md-3 col-sm-3 col-sx-12">';
    echo '<div class="panel panel-primary">';
      echo '<div class="panel-heading">Recipes List</div>';
      echo '<div class="panel-body">';
        $prof->displayRecipes();
      echo '</div>';
    echo '</div>';
  echo '</div>';
?>