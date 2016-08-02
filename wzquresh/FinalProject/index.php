<?php
  /*CIS355
   *Final Project
   *Waqas Qureshi
   *Food for Fun
  */
  
  //On session start redirect to login page
  session_start();
  if(empty($_SESSION['name'])) header("Location: login.php");
  
  include 'database.php';
  $pdo = Database::connect();
  $name = $_SESSION['name'];
  $sql = "SELECT ID FROM User WHERE firstName = '$name'";
  $userID = $pdo->query($sql);//gets userID from database
  //Use userID to get the users recipes
  
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- The head section does the following.
      1. Sets character set
      2. Includes Bootstrap
      -->
      <meta charset="utf-8">
      <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  
      <h1><?php echo $name;?></h1>
  </head>
  <body>
    
  </body>
</html>