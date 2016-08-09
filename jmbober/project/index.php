<?php
 session_start();
 if (empty($_SESSION['username'])) header("Location: login.php"); // redirect

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
          <div class="row">
            <h3>Songs</h3>
          </div>
          <div class="row">
            <p>
              <a href="uploadSong.php" class="btn btn-success">Add a song</a> 
              <a href="logout.php" class="btn btn-success">Logout</a>

            </p>

            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Artist</th>
                  <th>Genre</th>

                </tr>
              </thead>
              <tbody>
                <?php 
					   include 'database.php';
					   $pdo = Database::connect();
					   $sql = 'SELECT * FROM songs ORDER BY id DESC';
	 				   foreach ($pdo->query($sql) as $row) {
              echo '<tr>';
              echo '<td>'. $row['title'] . '</td>';
              echo '<td>'. $row['artist'] . '</td>';
              echo '<td>'. $row['genre'] . '</td>';
              
              echo '<td width=350>';
              echo '<a class="btn" href='.$row['link'].'">Listen</a>';
              echo '<a class="btn" href="rate.php?id='.$row['id'].'">Rate</a>';
              echo '<a class="btn" href="update.php?id='.$row['id'].'">Update</a>';
              echo '<a class="btn" href="read.php?id='.$row['id'].'">View Ratings</a>';
              echo '<a class="btn"  href="delete.php?id='.$row['id'].'">Delete</a>';
              echo '</td>';
              echo '</tr>';
					   }
					   Database::disconnect();
					  ?>
              </tbody>
            </table>

          </div>
        </div> <!-- /container -->
      </body>
    </html>
    <?php   show_source(__FILE__); ?>