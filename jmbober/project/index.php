<?php
/* *******************************************************************
* filename : index.php
* author : Jenny Bober
* username : jmbober
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description : "Main menu" page, shows songs table with all the songs
                 and options to listen, rate, update, view ratings and delete song.
                 Also has options to create a song or logout.
*
* Structure:  PHP:
                Start session and check username
              HTML:
                head:
                  -links to bootstrap
                body:
                  create table
                  loop through "songs" (using php) 
                  output records to table 

* precondition : User is logged in, database connection is valid
* postcondition: Table with records is output to the webpage,
                 all buttons link to proper files and send $_GET values where necessary
*
* Code adapted from George Corser
* *******************************************************************/
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
        
        <!-- TABLE -->  
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Title</th>
              <th>Artist</th>
              <th>Genre</th>
            </tr>
          </thead>
          <tbody>
          
          <!-- RECORDS -->
            <?php 
              include 'database.php';
              $pdo = Database::connect();
              $sql = 'SELECT * FROM songs ORDER BY id DESC';
              foreach ($pdo->query($sql) as $row) {
                echo '<tr>';
                echo '<td>'. $row['title'] . '</td>';
                echo '<td>'. $row['artist'] . '</td>';
                echo '<td>'. $row['genre'] . '</td>';

                echo '<td width=300>';
                echo '<a class="btn" href="'.$row['link'].'" target="_blank" >Listen</a>';
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
