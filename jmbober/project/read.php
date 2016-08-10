<?php 
/* *******************************************************************
* filename : read.php
* author : Jenny Bober
* username : jmbober
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description : Displays a table with ratings for a song
              
*
* Structure: PHP:
              starts session
              set id
              get data from database table
             
             HTML: 
              Head -- link to bootstrap
              Body -- create table
                      loop through records and output (using php)
*
precondition : database connection is valid, songs, users and songRatings tables exist with proper fields,
               user is logged in, and $_GET['id'] is set
postcondition: records are displayed
*
* Code adapted from George Corser
* *******************************************************************/
	session_start();
	if (empty($_SESSION['username'])) header("Location: login.php");
 
  //set id 
	$id = $_GET['id'];
	
	require 'database.php';
	
  //Get data from database table
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = 'SELECT * FROM songs WHERE id = ?';
  $q = $pdo->prepare($sql);
  $q->execute(array($id));
  $data = $q->fetch(PDO::FETCH_ASSOC);
  Database::disconnect();

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
          <?php echo '<h3>Ratings/comments for '. $data["title"] .' by '. $data["artist"] .'</h3>' ?>
        </div>
        <div>
          <a class="btn" href="index.php">Back</a>
        </div>
        <!-- CREATE TABLE -->
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Username</th>
              <th>Rating</th>
              <th>Comment</th>
            </tr>
          </thead>
          <tbody>
            <!-- LOOP THROUGH RECORDS AND OUTPUT-->
            <?php 					   
              $pdo = Database::connect();
              $sql = "SELECT songs.title, songs.artist, users.username, songRatings.rating, songRatings.comment FROM `songs`, `users`, `songRatings` WHERE songs.id = $id AND songs.id = songRatings.songID AND users.id = songRatings.userID";
                            
              foreach ($pdo->query($sql) as $row) {
                echo '<tr>';
                echo '<td>'. $row['username'] . '</td>';
                echo '<td>'. $row['rating'] . '</td>';
                echo '<td>'. $row['comment'] . '</td>';
              } //end foreach
              Database::disconnect();
            ?>
          </tbody>
        </table>          
      </div>
    </div> <!-- /container -->
  </body>
</html>