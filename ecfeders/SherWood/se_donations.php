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
                <h3>Donations</h3>
            </div>
            <div class="row">
			    <p>
                    <a href="create.php" class="btn btn-success">Create</a>
                </p>
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Name </th>
                      <th>Wish Item</th>
                      <th>Quantity</th>
					  <th>Comments</th>
					  <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                   include 'database.php';
                   $pdo = Database::connect();
                   $sql = 'SELECT se_customers.name as Name, se_wishes.item As WISHItem, se_donations.qty As QTY, se_donations.comments AS Comments,
							se_donations.id AS id FROM se_donations INNER JOIN se_customers ON se_donations.cust_id = se_customers.id
				           INNER JOIN se_wishes ON se_donations.wish_id = se_wishes.id ORDER BY id DESC';
                   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['Name'] . '</td>';
                            echo '<td>'. $row['WISHItem'] . '</td>';
                            echo '<td>'. $row['QTY'] . '</td>';
							echo '<td>'. $row['Comments'] . '</td>';
							echo '<td width=250>';
                            echo '<a class="btn btn-info" href="read.php?id='.$row['id'].'">Read</a>';
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