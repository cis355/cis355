<?php 
	session_start();
	if (empty($_SESSION['username'])) header("Location: login.php");
 
	$id = intval($_GET['id']);
	
	require 'database.php';
		
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
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Username</th>
              <th>Rating</th>
              <th>Comment</th>
            </tr>
          </thead>
          <tbody>
                
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