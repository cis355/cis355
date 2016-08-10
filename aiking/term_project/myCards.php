<?php
session_start();
if (empty($_SESSION['name'])) header("Location: home.html"); //redirect
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
            <div class="row">
                <h3>Kreations</h3>
            </div>
            <div class="row">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Kreation Name</th>
                      <th>Align</th>
                      <th>Front</th>
						<th>Inside Left (top)</th>
						<th>Inside Right (bottom)</th>
						<th>Comments</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
				  $cust_id = $_SESSION['id'];
				  
                   include 'CRUD/database.php';
                   $pdo = Database::connect();
                   $sql = 'SELECT * FROM creations ORDER BY id DESC WHERE id = $cust_id';
                   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['creationName'] . '</td>';
                            echo '<td>'. $row['align'] . '</td>';
                            echo '<td>'. $row['front'] . '</td>';
							echo '<td>'. $row['inside1'] . '</td>';
                            echo '<td>'. $row['inside2'] . '</td>';
                            echo '<td>'. $row['comments'] . '</td>';
                            echo '<td><a class="btn btn-primary" href="read.php?id='.$row['id'].'">Read</a>';
                            echo ' ';
                            echo '<a class="btn btn-success" href="update.php?id='.$row['id'].'">Update</a>';
                            echo ' ';
                            echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Delete</a>';
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