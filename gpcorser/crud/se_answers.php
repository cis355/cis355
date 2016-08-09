<?php
session_start();
if (empty($_SESSION['cust_id'])) header('Location: se_login.php'); // redirect
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>
	<!-- The body section does the following.
		1. Displays heading
		2. Displays a "create" button
		3. Displays rows of database records (from MySQL database)
		4. Displays "tutorial" button
		-->
    <div class="container">
    		<div class="row">
    			<h3>Sherwood Elementary: Quiz Answers</h3>
    		</div>
			<div class="row">
				<p>
					<a href="create.php" class="btn btn-success">Create</a>
					<a href="se_logout.php" class="btn btn-danger">Logout</a>
				</p>
				
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Person</th>
		                  <th>Date</th>
		                  <th>Question</th>
		                  <th>Answer</th>
						  <th>Actions</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   include 'database.php';
					   $pdo = Database::connect();
					   $sql = 'SELECT * 
					   FROM se_answers, se_questions, se_customers 
					   WHERE se_answers.cust_id = se_customers.id
					   AND se_answers.ques_id = se_questions.id
					   ORDER BY se_customers.name, se_answers.date, se_answers.ques_id DESC';
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['name'] . '</td>';
							   	echo '<td>'. $row['date'] . '</td>';
							   	echo '<td>'. $row['question'] . '</td>';
								echo '<td>'. $row['answer'] . '</td>';
							   	echo '<td width=250>';
							   	echo '<a class="btn" href="read.php?id='.
								   $row['id'].'">Read</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-success" 
								   href="update.php?id='.$row['id'].'">Update</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-danger" 
								   href="delete.php?id='.$row['id'].'">Delete</a>';
							   	echo '</td>';
							   	echo '</tr>';
					   }
					   Database::disconnect();
					  ?>
				      </tbody>
	            </table>
				<a href="http://www.startutorial.com/articles/view/php-crud-tutorial-part-1" class="btn btn-success">Tutorial</a>
    	</div>
    </div> <!-- /container -->
  </body>
</html>